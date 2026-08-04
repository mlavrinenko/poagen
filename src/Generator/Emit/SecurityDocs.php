<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Operation;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;

use function sprintf;

/**
 * The half of a security declaration that is not a credential, carried
 * across into the emitted client: flow endpoints, scope vocabulary, and the
 * one scheme that has nothing to send.
 *
 * A consumer reaching for `league/oauth2-client` needs a token endpoint and
 * a scope list. Both are in the document they already handed poagen, and
 * without this they would go back to the vendor's YAML to read them beside
 * the typed client they were given instead of it. That is the "help the
 * consumer wire their own transport" half of the ruling: poagen does not
 * acquire the token — `operations-delegate-to-an-injected-transport` puts
 * that in the transport, and sending a token and obtaining one are
 * different jobs — but it does hand over everything the document says
 * about obtaining one.
 *
 * Only the root client carries it. The metadata is a fact about the
 * document, not about a tag, so restating it on every sub-client would say
 * one thing per tag and bury the operations a reader opened that class for.
 * The root is the composition root — where a consumer wires the transport,
 * which is exactly when a token endpoint is what they need.
 *
 * @internal
 */
final readonly class SecurityDocs
{
    /**
     * Hard-wrapped rather than one long line: this lands in a docblock a
     * consumer reads in their editor, and nothing reflows a generated
     * comment for them.
     */
    private const string CLOSING = "poagen never acquires, refreshes, stores or validates a credential. It\n"
        . "puts the value you pass to the constructor on the request; obtaining\n"
        . "one is your transport's job.";

    /**
     * The root client's class docblock, or `''` when the document says
     * nothing a constructor parameter does not already say. A schema whose
     * only schemes are an apiKey and a bearer token emits no comment at
     * all, so its committed tree is untouched by any of this.
     */
    public static function clientComment(SecuritySchemeCatalog $catalog): string
    {
        $blocks = [];

        foreach ($catalog->requiredSchemes() as $scheme) {
            if ($scheme->isReported()) {
                $blocks[] = SecurityAudit::mutualTls($scheme);

                continue;
            }

            if ($scheme->hasFlowMetadata()) {
                $blocks[] = self::flowBlock($scheme);
            }
        }

        if ($blocks === []) {
            return '';
        }

        return implode("\n\n", [...$blocks, self::CLOSING]);
    }

    /**
     * The same metadata as constants, so a caller can read a token endpoint
     * out of the client it already has rather than out of a docblock.
     */
    public static function addConstants(ClassType $class, SecuritySchemeCatalog $catalog): void
    {
        foreach ($catalog->requiredSchemes() as $scheme) {
            $flows = $scheme->flows;
            if (!$scheme->hasFlowMetadata()) {
                continue;
            }
            if (!$flows instanceof SecurityFlows) {
                continue;
            }

            $prefix = self::constantPrefix($scheme->name);

            if ($flows->flows !== []) {
                $class->addConstant($prefix . '_FLOWS', $flows->flows)
                    ->setPublic()
                    ->setType('array')
                    ->addComment(sprintf('The flows `%s` declares, as the document declares them.', $scheme->name));
            }

            if ($flows->discoveryUrl !== null) {
                $class->addConstant($prefix . '_OPENID_CONNECT_URL', $flows->discoveryUrl)
                    ->setPublic()
                    ->setType('string')
                    ->addComment(sprintf('The OpenID Connect discovery document `%s` points at.', $scheme->name));
            }
        }
    }

    /**
     * An operation's required scopes, on the operation. A consumer asking
     * their OAuth library for a token needs to know which scopes this call
     * wants, and the document says so per operation rather than per client.
     */
    public static function addOperationComment(Method $method, ?SecuritySchemeCatalog $catalog, Operation $operation): void
    {
        if (!$catalog instanceof SecuritySchemeCatalog) {
            return;
        }

        $comment = self::operationComment($catalog, $operation);

        if ($comment !== '') {
            $method->addComment($comment);
        }
    }

    /**
     * The scopes one operation's own requirement asks for, with the
     * vendor's description of each. An operation names scopes without
     * saying which flow they came from, so the description is looked up
     * across the scheme's flows.
     */
    public static function operationComment(SecuritySchemeCatalog $catalog, Operation $operation): string
    {
        $lines = [];

        foreach ($catalog->requirementsFor($operation) as $name => $scopes) {
            $scheme = $catalog->scheme($name);
            if ($scopes === []) {
                continue;
            }
            if (!$scheme instanceof SecurityScheme) {
                continue;
            }

            $lines[] = sprintf('Requires `%s` scopes: %s.', $name, implode(', ', self::quote($scopes)));
        }

        return implode("\n", $lines);
    }

    private static function flowBlock(SecurityScheme $scheme): string
    {
        $flows = $scheme->flows;
        $lines = [sprintf(
            '`%s` (%s) — one access token, sent as `%s: %s <token>`.',
            $scheme->name,
            $scheme->typeLabel,
            $scheme->wireName,
            $scheme->schemeToken,
        )];

        if (!$flows instanceof SecurityFlows) {
            return $lines[0];
        }

        foreach ($flows->flows as $flowName => $flow) {
            $lines[] = sprintf('  %s flow:', $flowName);

            foreach (['authorizationUrl', 'tokenUrl', 'refreshUrl'] as $field) {
                if ($flow[$field] !== null) {
                    $lines[] = sprintf('    %s: %s', $field, $flow[$field]);
                }
            }

            foreach ($flow['scopes'] as $scope => $description) {
                $lines[] = sprintf('    scope `%s` — %s', $scope, $description);
            }
        }

        if ($flows->discoveryUrl !== null) {
            $lines[] = sprintf('  openIdConnectUrl: %s', $flows->discoveryUrl);
        }

        $lines[] = sprintf('  Also readable as self::%s_*.', self::constantPrefix($scheme->name));

        return implode("\n", $lines);
    }

    /**
     * Scope names only. The vendor's description of each is a fact about
     * the scheme rather than about the call, and it is already stated once
     * on the client — repeating it under every operation that wants the
     * same two scopes teaches a reader nothing after the first, and the
     * duplication gate on emitted output measures exactly that.
     *
     * @param  list<string> $scopes
     * @return list<string>
     */
    private static function quote(array $scopes): array
    {
        return array_map(static fn(string $scope): string => sprintf('`%s`', $scope), $scopes);
    }

    /**
     * `petstore_auth` becomes `PETSTORE_AUTH`, `apiKeyAuth` becomes
     * `API_KEY_AUTH` — the scheme's own name in constant case, so a reader
     * can go from the document to the constant without a lookup table.
     */
    private static function constantPrefix(string $name): string
    {
        $camel = SecurityScheme::camelize($name);
        $snake = preg_replace('/(?<!^)[A-Z]/', '_$0', $camel);

        return strtoupper($snake ?? $camel);
    }
}
