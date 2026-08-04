<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Runtime\Contract\Endpoint;

use function sprintf;
use function var_export;

/**
 * Describes one operation's request as a chain of {@see Endpoint} calls.
 *
 * What is left in an emitted operation after the invariant half moved to the
 * runtime: a verb, a path template, the parameters the document declared,
 * the credentials it requires and the body it accepts. Nothing here decides
 * how any of that reaches the wire — that is the transport's, said once.
 *
 * Segment order matches the order the old inline assembly used — path,
 * query, credentials in the query, headers, credential headers, body — so a
 * regenerated client sends byte-identical requests.
 *
 * @internal
 */
final readonly class EndpointChainEmitter
{
    private const array VERBS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE'];

    private WireValueExpr $values;

    private EndpointBodyEmitter $bodies;

    private SecurityEmitter $security;

    public function __construct(
        private string $modelNamespace = '',
        private ?EnumCatalog $enums = null,
        private ?NameRegistry $registry = null,
        ?ComponentCatalog $components = null,
    ) {
        $this->values = new WireValueExpr($components);
        $this->bodies = new EndpointBodyEmitter();
        $this->security = new SecurityEmitter();
    }

    /**
     * The chain, one call per segment, starting with the verb.
     *
     * @param list<ResolvedParameter> $pathParams
     * @param list<ResolvedParameter> $queryParams
     * @param list<ResolvedParameter> $headerParams
     * @param list<SecurityScheme> $activeSchemes
     *
     * @return list<string>
     */
    public function segments(
        PhpNamespace $namespace,
        string $httpMethod,
        string $pathUri,
        array $pathParams,
        array $queryParams,
        array $headerParams,
        ?BodySpec $body,
        Bindings $bindings,
        array $activeSchemes,
    ): array {
        $namespace->addUse(Endpoint::class);
        $endpoint = $namespace->simplifyName(Endpoint::class);
        $segments = [$this->opening($endpoint, $httpMethod, $pathUri)];

        foreach ($pathParams as $resolved) {
            $segments[] = sprintf(
                '->path(%s, %s)',
                var_export($resolved->rawName(), true),
                $this->values->build($resolved->phpName, $resolved->param->schema, $bindings, $namespace, required: true),
            );
        }

        foreach ($queryParams as $resolved) {
            $segments[] = $this->querySegment($resolved, $bindings, $namespace);
        }

        foreach ($this->security->querySchemes($activeSchemes) as $scheme) {
            $segments[] = $this->security->querySegment($scheme);
        }

        foreach ($headerParams as $resolved) {
            $segments[] = sprintf(
                '->header(%s, %s)',
                var_export($resolved->rawName(), true),
                $this->values->build($resolved->phpName, $resolved->param->schema, $bindings, $namespace, required: false),
            );
        }

        foreach ($this->security->headerSegments($activeSchemes, $namespace) as $segment) {
            $segments[] = $segment;
        }

        if ($body instanceof BodySpec) {
            $segments[] = $this->bodies->segment($body);
        }

        return $segments;
    }

    private function opening(string $endpoint, string $httpMethod, string $pathUri): string
    {
        $verb = strtoupper($httpMethod);
        $path = var_export($pathUri, true);

        return in_array($verb, self::VERBS, true)
            ? sprintf('%s::%s(%s)', $endpoint, strtolower($verb), $path)
            : sprintf('%s::method(%s, %s)', $endpoint, var_export($verb, true), $path);
    }

    /**
     * A scalar query parameter passes its value straight through — null
     * included, which is how an optional parameter drops itself. An
     * `explode: true` array passes the list, and `Endpoint` repeats the key
     * once per item.
     */
    private function querySegment(ResolvedParameter $resolved, Bindings $bindings, PhpNamespace $namespace): string
    {
        $name = var_export($resolved->rawName(), true);
        $required = $resolved->param->required;

        if (!OperationAnalyzer::isArrayQueryParam($resolved->param)) {
            return sprintf(
                '->query(%s, %s)',
                $name,
                $this->values->build($resolved->phpName, $resolved->param->schema, $bindings, $namespace, $required),
            );
        }

        return sprintf('->query(%s, %s)', $name, $this->listExpr($resolved, $bindings, $namespace, $required));
    }

    /**
     * The list handed to `Endpoint`. Items that reach the wire as they are
     * need no mapping at all; a bound format or a scalar value object does,
     * and gets a typed closure so the emitted file still analyses at max.
     */
    private function listExpr(ResolvedParameter $resolved, Bindings $bindings, PhpNamespace $namespace, bool $required): string
    {
        $var = '$' . $resolved->phpName;
        $schema = $resolved->param->schema;
        $items = $schema instanceof Schema ? $schema->items : null;

        if ($this->values->isTransparent($items, $bindings, $namespace)) {
            return $var;
        }

        $map = sprintf(
            'array_map(static fn(%s $__v): string => %s, %s)',
            $this->itemType($items, $bindings, $namespace),
            $this->values->itemExpr('__v', $items, $bindings, $namespace),
            $var,
        );
        $namespace->addUseFunction('array_map');

        return $required ? $map : sprintf('%s === null ? null : %s', $var, $map);
    }

    private function itemType(Schema|Reference|null $items, Bindings $bindings, PhpNamespace $namespace): string
    {
        if ($items === null || !$this->registry instanceof NameRegistry) {
            return 'mixed';
        }

        $resolved = TypeResolver::resolve($items, $bindings, $this->modelNamespace, $this->registry, $this->enums);
        $phpType = $resolved->phpType;

        if ($phpType === null || !str_contains($phpType, '\\')) {
            return $phpType ?? 'mixed';
        }

        $namespace->addUse(ltrim($phpType, '\\'));

        return $namespace->simplifyName($phpType);
    }
}
