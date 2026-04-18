<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\Schema;
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
     * @param list<Parameter> $pathParams
     * @param list<Parameter> $queryParams
     * @param list<Parameter> $headerParams
     */
    public function emitRequest(
        Method $method,
        string $httpMethod,
        string $pathUri,
        array $pathParams,
        array $queryParams,
        array $headerParams,
        ?BodySpec $body,
    ): void {
        $method->addBody('$path = ?;', [$pathUri]);

        $this->emitPathInterpolation($method, $pathParams);
        $this->emitQueryAssembly($method, $queryParams);

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
            $var = new Literal('$' . $param->name);
            $method->addBody(
                'if (? !== null) { $request = $request->withHeader(?, ?); }',
                [$var, $param->name, $var],
            );
        }
    }

    /**
     * @param list<Parameter> $pathParams
     */
    private function emitPathInterpolation(Method $method, array $pathParams): void
    {
        foreach ($pathParams as $param) {
            $schema = $param->schema instanceof Schema ? $param->schema : null;
            $valueExpr = $this->stringExpr($param->name, $schema);
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
    private function emitQueryAssembly(Method $method, array $queryParams): void
    {
        if ($queryParams === []) {
            return;
        }

        $method->addBody('$query = [];');

        $hasUnconditionalPush = false;

        foreach ($queryParams as $param) {
            $isArray = OperationAnalyzer::isArrayQueryParam($param);

            if ($isArray) {
                $this->emitArrayQueryPush($method, $param);
                continue;
            }

            if ($param->required) {
                $this->emitScalarQueryPush($method, $param, indent: '');
                $hasUnconditionalPush = true;
                continue;
            }

            $method->addBody('if ($' . $param->name . ' !== null) {');
            $this->emitScalarQueryPush($method, $param, indent: '    ');
            $method->addBody('}');
        }

        if ($hasUnconditionalPush) {
            $method->addBody('$path .= \'?\' . \implode(\'&\', $query);');

            return;
        }

        $method->addBody('if ($query !== []) { $path .= \'?\' . \implode(\'&\', $query); }');
    }

    private function emitScalarQueryPush(Method $method, Parameter $param, string $indent): void
    {
        $schema = $param->schema instanceof Schema ? $param->schema : null;
        $valueExpr = $this->stringExpr($param->name, $schema);
        $method->addBody(
            $indent . '$query[] = ? . \urlencode(?);',
            [$param->name . '=', $valueExpr],
        );
    }

    private function emitArrayQueryPush(Method $method, Parameter $param): void
    {
        $itemSchema = $param->schema instanceof Schema ? $param->schema->items : null;
        $itemExpr = $this->stringExpr('__v', $itemSchema instanceof Schema ? $itemSchema : null);

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
     * `string` so PHPStan doesn't flag a useless cast on the generated
     * client.
     */
    private function stringExpr(string $varName, ?Schema $schema): Literal
    {
        $alreadyString = $schema instanceof Schema && $schema->type === 'string';

        return $alreadyString
            ? new Literal('$' . $varName)
            : new Literal('(string) $' . $varName);
    }
}
