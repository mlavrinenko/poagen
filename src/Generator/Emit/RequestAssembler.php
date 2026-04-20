<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\ScalarFormat;
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
        $this->emitQueryAssembly($method, $queryParams, $bindings);

        $method->addBody(
            '$request = $this->requestFactory->createRequest(?, \rtrim($this->baseUri, \'/\') . $path);',
            [strtoupper($httpMethod)],
        );

        if ($body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            $this->emitBodyAttachment($method, $body);
        }

        foreach ($headerParams as $resolved) {
            $schema = $resolved->param->schema instanceof Schema ? $resolved->param->schema : null;
            $check = new Literal('$' . $resolved->phpName);
            $value = $this->stringExpr($resolved->phpName, $schema, $bindings);
            $method->addBody(
                'if (? !== null) { $request = $request->withHeader(?, ?); }',
                [$check, $resolved->rawName(), $value],
            );
        }

        $this->emitSecurityHeaders($method, $activeSchemes);
    }

    /**
     * Attach the request body per {@see BodySpec::$kind}. JSON kinds round
     * through `json_encode`; FORM uses `http_build_query` in RFC1738 form
     * — the shape OAuth2 token endpoints and Stripe-style APIs expect.
     *
     * UNSUPPORTED is never reached here — the caller bails out of the
     * assembler entirely and emits a throwing stub instead.
     */
    private function emitBodyAttachment(Method $method, BodySpec $body): void
    {
        if ($body->kind === BodySpec::KIND_FORM) {
            $method->addBody('$__form = [];');

            foreach ($body->formFields as $field) {
                if ($field->required) {
                    $method->addBody(
                        '$__form[?] = $' . $field->name . ';',
                        [$field->name],
                    );
                    continue;
                }
                $method->addBody(
                    'if ($' . $field->name . ' !== null) { $__form[?] = $' . $field->name . '; }',
                    [$field->name],
                );
            }

            $method->addBody('$request = $request');
            $method->addBody("    ->withHeader('Content-Type', 'application/x-www-form-urlencoded')");
            $method->addBody('    ->withBody($this->streamFactory->createStream(\\http_build_query($__form, \'\', \'&\', \\PHP_QUERY_RFC1738)));');

            return;
        }

        $payload = $body->isList()
            ? '\\array_map(fn(object $__m): array => $this->marshaller->marshal($__m), $body)'
            : '$this->marshaller->marshal($body)';

        $method->addBody('$request = $request');
        $method->addBody("    ->withHeader('Content-Type', 'application/json')");
        $method->addBody('    ->withBody($this->streamFactory->createStream(\\json_encode(' . $payload . ', \\JSON_THROW_ON_ERROR)));');
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
     * @param list<ResolvedParameter> $pathParams
     */
    private function emitPathInterpolation(Method $method, array $pathParams, Bindings $bindings): void
    {
        foreach ($pathParams as $resolved) {
            $schema = $resolved->param->schema instanceof Schema ? $resolved->param->schema : null;
            $valueExpr = $this->stringExpr($resolved->phpName, $schema, $bindings);
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
     * @param list<ResolvedParameter> $queryParams
     */
    private function emitQueryAssembly(Method $method, array $queryParams, Bindings $bindings): void
    {
        if ($queryParams === []) {
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

        if ($hasUnconditionalPush) {
            $method->addBody('$path .= \'?\' . \implode(\'&\', $query);');

            return;
        }

        $method->addBody('if ($query !== []) { $path .= \'?\' . \implode(\'&\', $query); }');
    }

    private function emitScalarQueryPush(Method $method, ResolvedParameter $resolved, string $indent, Bindings $bindings): void
    {
        $schema = $resolved->param->schema instanceof Schema ? $resolved->param->schema : null;
        $valueExpr = $this->stringExpr($resolved->phpName, $schema, $bindings);
        $method->addBody(
            $indent . '$query[] = ? . \urlencode(?);',
            [$resolved->rawName() . '=', $valueExpr],
        );
    }

    private function emitArrayQueryPush(Method $method, ResolvedParameter $resolved, Bindings $bindings): void
    {
        $itemSchema = $resolved->param->schema instanceof Schema ? $resolved->param->schema->items : null;
        $itemExpr = $this->stringExpr('__v', $itemSchema instanceof Schema ? $itemSchema : null, $bindings);

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
