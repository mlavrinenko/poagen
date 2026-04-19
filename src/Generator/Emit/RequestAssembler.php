<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\ScalarFormat;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\Method;

/**
 * Emits the body lines that build the PSR-7 request: path interpolation,
 * query-string assembly, body attachment and optional header pinning.
 *
 * Kept separate from {@see OperationEmitter} so the latter can stay under
 * ADR-004's 250-line limit while still owning the method-signature shape.
 *
 * @internal
 */
final readonly class RequestAssembler
{
    /**
     * @param list<Parameter>      $pathParams
     * @param list<Parameter>      $queryParams
     * @param list<Parameter>      $headerParams
     * @param list<SecurityScheme> $activeSchemes
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
        $this->emitQueryAssembly($method, $queryParams, $bindings);

        $method->addBody(
            '$request = $this->requestFactory->createRequest(?, \rtrim($this->baseUri, \'/\') . $path);',
            [strtoupper($httpMethod)],
        );

        if ($body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            $method->addBody('$request = $request');
            $method->addBody("    ->withHeader('Content-Type', 'application/json')");
            $method->addBody('    ->withBody($this->streamFactory->createStream(\\json_encode($body, \\JSON_THROW_ON_ERROR)));');
        }

        foreach ($headerParams as $param) {
            $schema = $param->schema instanceof Schema ? $param->schema : null;
            $check = new Literal('$' . $param->name);
            $value = $this->stringExpr($param->name, $schema, $bindings);
            $method->addBody(
                'if (? !== null) { $request = $request->withHeader(?, ?); }',
                [$check, $param->name, $value],
            );
        }

        $this->emitSecurityHeaders($method, $activeSchemes);
    }

    /**
     * Attach each active security scheme as a header. Runs after the
     * per-parameter header loop so auth headers consistently land last
     * in the emitted method body — makes request diffs predictable and
     * matches the "auth is transport policy" framing of ADR-002.
     *
     * @param list<SecurityScheme> $activeSchemes
     */
    private function emitSecurityHeaders(Method $method, array $activeSchemes): void
    {
        foreach ($activeSchemes as $scheme) {
            switch ($scheme->kind) {
                case SecurityScheme::KIND_API_KEY_HEADER:
                    $method->addBody(
                        '$request = $request->withHeader(?, $this->' . $scheme->ctorArg . ');',
                        [$scheme->headerName],
                    );
                    break;

                case SecurityScheme::KIND_BEARER:
                    $method->addBody(
                        '$request = $request->withHeader(?, ? . $this->' . $scheme->ctorArg . ');',
                        [$scheme->headerName, 'Bearer '],
                    );
                    break;
            }
        }
    }

    /**
     * @param list<Parameter> $pathParams
     */
    private function emitPathInterpolation(Method $method, array $pathParams, Bindings $bindings): void
    {
        foreach ($pathParams as $param) {
            $schema = $param->schema instanceof Schema ? $param->schema : null;
            $valueExpr = $this->stringExpr($param->name, $schema, $bindings);
            $method->addBody(
                '$path = \str_replace(?, ?, $path);',
                ['{' . $param->name . '}', $valueExpr],
            );
        }
    }

    /**
     * Assemble the query string by hand so an `explode: true` array
     * parameter is serialised as `tags=a&tags=b` rather than
     * `http_build_query`'s `tags%5B0%5D=a` syntax.
     *
     * @param list<Parameter> $queryParams
     */
    private function emitQueryAssembly(Method $method, array $queryParams, Bindings $bindings): void
    {
        if ($queryParams === []) {
            return;
        }

        $method->addBody('$query = [];');

        $hasUnconditionalPush = false;

        foreach ($queryParams as $param) {
            $isArray = OperationAnalyzer::isArrayQueryParam($param);

            if ($isArray) {
                $this->emitArrayQueryPush($method, $param, $bindings);
                continue;
            }

            if ($param->required) {
                $this->emitScalarQueryPush($method, $param, indent: '', bindings: $bindings);
                $hasUnconditionalPush = true;
                continue;
            }

            $method->addBody('if ($' . $param->name . ' !== null) {');
            $this->emitScalarQueryPush($method, $param, indent: '    ', bindings: $bindings);
            $method->addBody('}');
        }

        if ($hasUnconditionalPush) {
            $method->addBody('$path .= \'?\' . \implode(\'&\', $query);');

            return;
        }

        $method->addBody('if ($query !== []) { $path .= \'?\' . \implode(\'&\', $query); }');
    }

    private function emitScalarQueryPush(Method $method, Parameter $param, string $indent, Bindings $bindings): void
    {
        $schema = $param->schema instanceof Schema ? $param->schema : null;
        $valueExpr = $this->stringExpr($param->name, $schema, $bindings);
        $method->addBody(
            $indent . '$query[] = ? . \urlencode(?);',
            [$param->name . '=', $valueExpr],
        );
    }

    private function emitArrayQueryPush(Method $method, Parameter $param, Bindings $bindings): void
    {
        $itemSchema = $param->schema instanceof Schema ? $param->schema->items : null;
        $itemExpr = $this->stringExpr('__v', $itemSchema instanceof Schema ? $itemSchema : null, $bindings);

        $loop = 'foreach ($' . $param->name . ' as $__v) { $query[] = ? . \urlencode(?); }';

        if ($param->required) {
            $method->addBody($loop, [$param->name . '=', $itemExpr]);

            return;
        }

        $method->addBody(
            'if ($' . $param->name . ' !== null) { ' . $loop . ' }',
            [$param->name . '=', $itemExpr],
        );
    }

    /**
     * Build the smallest expression that produces a `string` for use in the
     * URL: avoid the `(string)` cast when the parameter is already typed as
     * `string`; route through `format()` for built-in datetime scalar
     * formats; unwrap backed enums via `->value`.
     */
    private function stringExpr(string $varName, ?Schema $schema, Bindings $bindings): Literal
    {
        if ($schema instanceof Schema && $this->isEnumSchema($schema)) {
            return new Literal('$' . $varName . '->value');
        }

        if ($schema instanceof Schema && \is_string($schema->format)) {
            $scalarFormat = $bindings->scalarFormat($schema->format);

            if ($scalarFormat instanceof \Mlavrinenko\Paogen\Generator\ScalarFormat) {
                $expr = match ($scalarFormat->kind) {
                    ScalarFormat::KIND_DATETIME => '$' . $varName . '->format(\DateTimeInterface::RFC3339)',
                    ScalarFormat::KIND_DATE => '$' . $varName . '->format(\'Y-m-d\')',
                    ScalarFormat::KIND_SCALAR => '$' . $varName . '->toScalar()',
                    default => null,
                };

                if ($expr !== null) {
                    return new Literal($expr);
                }
            }
        }

        $alreadyString = $schema instanceof Schema && $schema->type === 'string';

        return $alreadyString
            ? new Literal('$' . $varName)
            : new Literal('(string) $' . $varName);
    }

    private function isEnumSchema(Schema $schema): bool
    {
        if (\is_array($schema->enum) && $schema->enum !== []) {
            return \in_array($schema->type, ['string', 'integer'], true);
        }

        return false;
    }
}
