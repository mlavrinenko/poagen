<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\Method;

/**
 * Emits the body lines that build the PSR-7 request: path interpolation,
 * query-string assembly, body attachment and optional header pinning.
 *
 * Always uses the *raw* OpenAPI parameter name for wire keys (path
 * template tokens, query/header keys) and the *PHP* parameter name for
 * variable references. {@see ResolvedParameter} carries both halves so
 * a header named `Content-Type` lands on the wire as `Content-Type`
 * while the PHP method takes a `$contentType` argument (T-025).
 *
 * Kept separate from {@see OperationEmitter} so the latter can stay under
 * ADR-004's 250-line limit while still owning the method-signature shape.
 *
 * @internal
 */
final readonly class RequestAssembler
{
    private ParameterStringExpr $stringExprBuilder;
    private BodyAttachmentEmitter $bodyAttachment;
    private SecurityEmitter $security;

    public function __construct(
        ?ComponentCatalog $components = null,
    ) {
        $this->stringExprBuilder = new ParameterStringExpr($components);
        $this->bodyAttachment = new BodyAttachmentEmitter();
        $this->security = new SecurityEmitter();
    }

    /**
     * @param list<ResolvedParameter> $pathParams
     * @param list<ResolvedParameter> $queryParams
     * @param list<ResolvedParameter> $headerParams
     * @param list<SecurityScheme>    $activeSchemes
     */
    public function emitRequest(
        Method $method,
        string $httpMethod,
        string $pathUri,
        array $pathParams,
        array $queryParams,
        array $headerParams,
        ?BodySpec $body,
        Bindings $bindings,
        array $activeSchemes = [],
    ): void {
        $method->addBody('$path = ?;', [$pathUri]);

        $this->emitPathInterpolation($method, $pathParams, $bindings);
        $this->emitQueryAssembly($method, $queryParams, $activeSchemes, $bindings);

        $method->addBody(
            '$request = $this->requestFactory->createRequest(?, \rtrim($this->baseUri, \'/\') . $path);',
            [strtoupper($httpMethod)],
        );

        if ($body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            $this->bodyAttachment->emit($method, $body);
        }

        foreach ($headerParams as $resolved) {
            $schemaNode = $resolved->param->schema;
            $check = new Literal('$' . $resolved->phpName);
            $value = $this->stringExpr($resolved->phpName, $schemaNode, $bindings);
            $method->addBody(
                'if (? !== null) { $request = $request->withHeader(?, ?); }',
                [$check, $resolved->rawName(), $value],
            );
        }

        $this->security->emitHeaders($method, $activeSchemes);
    }

    /**
     * @param list<ResolvedParameter> $pathParams
     */
    private function emitPathInterpolation(Method $method, array $pathParams, Bindings $bindings): void
    {
        foreach ($pathParams as $resolved) {
            $valueExpr = $this->stringExpr($resolved->phpName, $resolved->param->schema, $bindings);
            $method->addBody(
                '$path = \str_replace(?, ?, $path);',
                ['{' . $resolved->rawName() . '}', $valueExpr],
            );
        }
    }

    /**
     * Assemble the query string by hand so an `explode: true` array
     * parameter is serialised as `tags=a&tags=b` rather than
     * `http_build_query`'s `tags%5B0%5D=a` syntax.
     *
     * A query-kind security scheme (T-260730) joins the same `$query`
     * array as a declared parameter — it has no header to ride on — and
     * counts as an unconditional push: an active credential is always
     * sent, so it forces the same unguarded `?` append a required
     * parameter does, whether or not the operation has query params of
     * its own.
     *
     * @param list<ResolvedParameter> $queryParams
     * @param list<SecurityScheme>    $activeSchemes
     */
    private function emitQueryAssembly(Method $method, array $queryParams, array $activeSchemes, Bindings $bindings): void
    {
        $querySchemes = $this->security->querySchemes($activeSchemes);

        if ($queryParams === [] && $querySchemes === []) {
            return;
        }

        $method->addBody('$query = [];');

        $hasUnconditionalPush = false;

        foreach ($queryParams as $resolved) {
            $isArray = OperationAnalyzer::isArrayQueryParam($resolved->param);

            if ($isArray) {
                $this->emitArrayQueryPush($method, $resolved, $bindings);
                continue;
            }

            if ($resolved->param->required) {
                $this->emitScalarQueryPush($method, $resolved, indent: '', bindings: $bindings);
                $hasUnconditionalPush = true;
                continue;
            }

            $method->addBody('if ($' . $resolved->phpName . ' !== null) {');
            $this->emitScalarQueryPush($method, $resolved, indent: '    ', bindings: $bindings);
            $method->addBody('}');
        }

        foreach ($querySchemes as $scheme) {
            $this->security->emitQueryPush($method, $scheme);
            $hasUnconditionalPush = true;
        }

        if ($hasUnconditionalPush) {
            $method->addBody('$path .= \'?\' . \implode(\'&\', $query);');

            return;
        }

        $method->addBody('if ($query !== []) { $path .= \'?\' . \implode(\'&\', $query); }');
    }

    private function emitScalarQueryPush(Method $method, ResolvedParameter $resolved, string $indent, Bindings $bindings): void
    {
        $valueExpr = $this->stringExpr($resolved->phpName, $resolved->param->schema, $bindings);
        $method->addBody(
            $indent . '$query[] = ? . \urlencode(?);',
            [$resolved->rawName() . '=', $valueExpr],
        );
    }

    private function emitArrayQueryPush(Method $method, ResolvedParameter $resolved, Bindings $bindings): void
    {
        $itemSchema = $resolved->param->schema instanceof Schema ? $resolved->param->schema->items : null;
        $itemExpr = $this->stringExpr('__v', $itemSchema, $bindings);

        $loop = 'foreach ($' . $resolved->phpName . ' as $__v) { $query[] = ? . \urlencode(?); }';

        if ($resolved->param->required) {
            $method->addBody($loop, [$resolved->rawName() . '=', $itemExpr]);

            return;
        }

        $method->addBody(
            'if ($' . $resolved->phpName . ' !== null) { ' . $loop . ' }',
            [$resolved->rawName() . '=', $itemExpr],
        );
    }

    private function stringExpr(string $varName, Schema|Reference|null $node, Bindings $bindings): Literal
    {
        return $this->stringExprBuilder->build($varName, $node, $bindings);
    }
}
