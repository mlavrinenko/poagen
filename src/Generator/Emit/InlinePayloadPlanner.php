<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;

/**
 * Names a model class for every operation payload the document declared inline.
 *
 * The model pipeline is rooted in `components.schemas`, so a document that
 * names nothing gives it nothing to walk. This planner supplies the missing
 * roots: it visits each operation, finds the request body and the first 2xx
 * response, and where either is an inline object (or an array of inline
 * objects) it derives a class name and hands the node to the same FIFO that
 * already drains inline children found inside named components. Everything
 * below the root — nested objects, arrays of objects, inline enums — is then
 * reached by the machinery that was always there.
 *
 * The derivation reads the *normalised* method name rather than the raw
 * operation identifier, so a profile rename improves the model names too:
 * renaming `getclientfullbalance` to `getClientFullBalance` turns
 * `GetclientfullbalanceResponse` into `GetClientFullBalanceResponse` without a
 * second entry. `Profile::$inlineModels` overrides the derivation outright,
 * which is also how a consumer keeps their own callers working when a vendor
 * renames an operation: point the pin at the new identifier and the class name
 * they publish stays put.
 *
 * @internal
 */
final readonly class InlinePayloadPlanner
{
    public const string ROLE_REQUEST = 'request';
    public const string ROLE_RESPONSE = 'response';

    /**
     * @param array<string,string> $pins        `'<operationId>.request'|'<operationId>.response'` → PHP class name
     * @param array<string,string> $xmlElements Profile::$xmlElements
     */
    public static function build(
        OpenApi $openApi,
        NameRegistry $operationIdRegistry,
        array $pins,
        ModelNameLedger $ledger,
        array $xmlElements = [],
    ): InlinePayloadCatalog {
        $bodies = [];
        $returns = [];
        $roots = [];

        foreach (OperationOrder::inEmissionOrder($openApi) as [, , $operation]) {
            $rawId = (string) ($operation->operationId ?? '');

            if ($rawId === '') {
                continue;
            }

            $base = ucfirst($operationIdRegistry->resolve($rawId, new NormalisationContext(SymbolKind::OperationId)));

            $body = self::planRequest($operation, $rawId, $base, $pins, $ledger, $roots, $xmlElements);

            if ($body instanceof BodySpec) {
                $bodies[$rawId] = $body;
            }

            $return = self::planResponse($operation, $rawId, $base, $pins, $ledger, $roots);

            if ($return instanceof ReturnSpec) {
                $returns[$rawId] = $return;
            }
        }

        return new InlinePayloadCatalog($bodies, $returns, $roots);
    }

    /**
     * @param array<string,string>   $pins
     * @param list<SynthesisedModel> $roots
     * @param array<string,string>   $xmlElements
     */
    private static function planRequest(
        Operation $operation,
        string $rawId,
        string $base,
        array $pins,
        ModelNameLedger $ledger,
        array &$roots,
        array $xmlElements = [],
    ): ?BodySpec {
        $resolved = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        if (!$resolved instanceof \cebe\openapi\spec\RequestBody) {
            return null;
        }

        $pin = $pins[$rawId . '.' . self::ROLE_REQUEST] ?? null;
        $schema = self::jsonSchemaOf($resolved->content);

        if (!$schema instanceof Schema) {
            // JSON is preferred where an operation offers both, so an XML body is
            // only reached when it is the only one on offer — which is why
            // pairing the two warns about nothing.
            return self::planXmlRequest($resolved, $rawId, $base, $pin, $ledger, $roots, $xmlElements);
        }

        if (self::isSynthesisableObject($schema)) {
            $name = self::claim($pin ?? $base . 'Request', $schema, $ledger, $roots);

            return BodySpec::json($name);
        }

        $items = self::inlineObjectItemsOf($schema);

        if ($items instanceof Schema) {
            $name = self::claim($pin ?? $base . 'RequestItem', $items, $ledger, $roots);

            return BodySpec::jsonList($name);
        }

        // An inline `type: object` the document left unconstrained — no
        // declared properties to synthesise a class from. The map is what the
        // schema says, so it is what the caller passes; dropping the operation
        // for want of a class name would shrink the client over a body the
        // vendor deliberately left open.
        if (SchemaType::of($schema)->is('object')) {
            return BodySpec::jsonMap($schema);
        }

        return null;
    }

    /**
     * An `application/xml` request body, whose payload model is synthesised
     * exactly as a JSON one is — the schema is declared, so nothing about the
     * shape is different. Only the element names are, and they come from the
     * profile because OpenAPI supplies no default for the document root.
     *
     * Returns null when the profile named nothing, which the caller reports as an
     * unrepresentable body rather than emitting XML with an invented root.
     *
     * @param array<string,string>   $xmlElements
     * @param list<SynthesisedModel> $roots
     */
    private static function planXmlRequest(
        \cebe\openapi\spec\RequestBody $body,
        string $rawId,
        string $base,
        ?string $pin,
        ModelNameLedger $ledger,
        array &$roots,
        array $xmlElements,
    ): ?BodySpec {
        $xml = $body->content['application/xml'] ?? null;
        $schema = $xml instanceof MediaType && $xml->schema instanceof Schema ? $xml->schema : null;

        if (!$schema instanceof Schema) {
            return null;
        }

        $root = $xmlElements[$rawId] ?? null;

        if (!\is_string($root) || $root === '') {
            return null;
        }

        if (self::isSynthesisableObject($schema)) {
            return BodySpec::xml(self::claim($pin ?? $base . 'Request', $schema, $ledger, $roots), $root);
        }

        $items = self::inlineObjectItemsOf($schema);
        $item = $xmlElements[$rawId . '.item'] ?? null;

        if ($items instanceof Schema && \is_string($item) && $item !== '') {
            return BodySpec::xmlList(self::claim($pin ?? $base . 'RequestItem', $items, $ledger, $roots), $root, $item);
        }

        return null;
    }

    /**
     * @param array<string,string>   $pins
     * @param list<SynthesisedModel> $roots
     */
    private static function planResponse(
        Operation $operation,
        string $rawId,
        string $base,
        array $pins,
        ModelNameLedger $ledger,
        array &$roots,
    ): ?ReturnSpec {
        $schema = self::successResponseSchema($operation);

        if (!$schema instanceof Schema) {
            return null;
        }

        $pin = $pins[$rawId . '.' . self::ROLE_RESPONSE] ?? null;

        if (self::isSynthesisableObject($schema)) {
            $name = self::claim($pin ?? $base . 'Response', $schema, $ledger, $roots);

            return ReturnSpec::model($name);
        }

        $items = self::inlineObjectItemsOf($schema);

        if ($items instanceof Schema) {
            $name = self::claim($pin ?? $base . 'ResponseItem', $items, $ledger, $roots);

            return ReturnSpec::listOf($name);
        }

        return null;
    }

    /**
     * @param list<SynthesisedModel> $roots
     */
    private static function claim(string $name, Schema $schema, ModelNameLedger $ledger, array &$roots): string
    {
        $ledger->claim($name, SynthesisedModel::originOf($schema));
        $roots[] = SynthesisedModel::forNode($name, $schema);

        return $name;
    }

    private static function isSynthesisableObject(Schema $schema): bool
    {
        return SchemaType::of($schema)->is('object') && InlineObjectResolver::classify($schema) === 'synthesise';
    }

    /**
     * The item schema of an inline array whose items are themselves an inline
     * object worth a class, or null.
     */
    private static function inlineObjectItemsOf(Schema $schema): ?Schema
    {
        if (!SchemaType::of($schema)->is('array')) {
            return null;
        }

        $items = $schema->items;

        return $items instanceof Schema && self::isSynthesisableObject($items) ? $items : null;
    }

    /**
     * @param array<MediaType> $content cebe types the map's keys as `int|string`
     */
    private static function jsonSchemaOf(array $content): ?Schema
    {
        $json = $content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return null;
        }

        $schema = $json->schema;

        return $schema instanceof Schema ? $schema : null;
    }

    private static function successResponseSchema(Operation $operation): ?Schema
    {
        $responses = $operation->responses;

        if ($responses === null) {
            return null;
        }

        foreach ($responses->getResponses() as $status => $response) {
            if (!str_starts_with((string) $status, '2')) {
                continue;
            }
            if (!$response instanceof Response) {
                continue;
            }

            return self::jsonSchemaOf($response->content);
        }

        return null;
    }
}
