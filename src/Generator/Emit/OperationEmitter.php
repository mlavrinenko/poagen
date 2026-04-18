<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

/**
 * Emits one method on the ApiClient class for one OpenAPI operation.
 *
 * Scope covered by the PoC:
 *   - parameters must all be `in: path` (required) — operations with
 *     query/header/cookie/form parameters are skipped;
 *   - request body may be absent or `application/json` referencing a Model;
 *   - response body may be absent, `$ref`-to-Model, or `list<$ref>`.
 *
 * Anything else is skipped. No exception: the op is simply not emitted.
 */
final readonly class OperationEmitter
{
    public function __construct(
        private string $modelNamespace,
    ) {}

    public function emit(
        ClassType $class,
        PhpNamespace $namespace,
        string $httpMethod,
        string $pathUri,
        Operation $operation,
        Bindings $bindings,
    ): bool {
        $operationId = (string) ($operation->operationId ?? '');

        if ($operationId === '') {
            return false;
        }

        $pathParams = OperationAnalyzer::pathParameters($operation);

        if ($pathParams === null) {
            return false;
        }

        $bodyRef = OperationAnalyzer::requestBodyRef($operation->requestBody);

        if ($operation->requestBody !== null && $bodyRef === null) {
            return false;
        }

        $queryParams = OperationAnalyzer::queryParameters($operation);
        $requiredQuery = array_values(array_filter($queryParams, static fn(Parameter $p): bool => $p->required));
        $optionalQuery = array_values(array_filter($queryParams, static fn(Parameter $p): bool => !$p->required));

        $return = OperationAnalyzer::returnType($operation->responses);

        $method = $class->addMethod($operationId)->setPublic();

        $this->addPathParams($method, $pathParams, $bindings);
        $this->addQueryParams($method, $requiredQuery, $bindings, required: true);

        if ($bodyRef !== null) {
            $this->addBodyParam($method, $namespace, $bodyRef);
        }

        $this->addQueryParams($method, $optionalQuery, $bindings, required: false);

        $this->applyReturnType($method, $namespace, $return);
        $this->emitBody($method, $httpMethod, $pathUri, $pathParams, $queryParams, $bodyRef, $return);

        return true;
    }

    /**
     * @param list<Parameter> $pathParams
     */
    private function addPathParams(Method $method, array $pathParams, Bindings $bindings): void
    {
        foreach ($pathParams as $param) {
            $resolved = TypeResolver::resolve($param->schema ?? new Schema([]), $bindings, $this->modelNamespace);
            $phpParam = $method->addParameter($param->name);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }
        }
    }

    /**
     * @param list<Parameter> $queryParams
     */
    private function addQueryParams(Method $method, array $queryParams, Bindings $bindings, bool $required): void
    {
        foreach ($queryParams as $param) {
            $resolved = TypeResolver::resolve($param->schema ?? new Schema([]), $bindings, $this->modelNamespace);
            $phpParam = $method->addParameter($param->name);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }

            if (!$required) {
                $phpParam->setNullable()->setDefaultValue(null);
            }
        }
    }

    private function addBodyParam(Method $method, PhpNamespace $namespace, string $bodyRef): void
    {
        $fqcn = '\\' . trim($this->modelNamespace, '\\') . '\\' . $bodyRef;
        $method->addParameter('body')->setType($fqcn);
        $namespace->addUse(ltrim($fqcn, '\\'));
    }

    private function applyReturnType(Method $method, PhpNamespace $namespace, ReturnSpec $return): void
    {
        if ($return->model === null) {
            $method->setReturnType('void');

            return;
        }

        $fqcn = '\\' . trim($this->modelNamespace, '\\') . '\\' . $return->model;
        $namespace->addUse(ltrim($fqcn, '\\'));

        if ($return->isList) {
            $method->setReturnType('array');
            $method->addComment('@return list<' . $fqcn . '>');

            return;
        }

        $method->setReturnType($fqcn);
    }

    /**
     * @param list<Parameter> $pathParams
     * @param list<Parameter> $queryParams
     */
    private function emitBody(
        Method $method,
        string $httpMethod,
        string $pathUri,
        array $pathParams,
        array $queryParams,
        ?string $bodyRef,
        ReturnSpec $return,
    ): void {
        $method->addBody('$path = ?;', [$pathUri]);

        foreach ($pathParams as $param) {
            $schema = $param->schema;
            $alreadyString = $schema instanceof Schema && $schema->type === 'string';
            $valueExpr = $alreadyString
                ? new Literal('$' . $param->name)
                : new Literal('(string) $' . $param->name);

            $method->addBody(
                '$path = \str_replace(?, ?, $path);',
                ['{' . $param->name . '}', $valueExpr],
            );
        }

        $this->emitQueryAssembly($method, $queryParams);

        $method->addBody(
            '$request = $this->requestFactory->createRequest(?, \rtrim($this->baseUri, \'/\') . $path);',
            [strtoupper($httpMethod)],
        );

        if ($bodyRef !== null) {
            $method->addBody('$request = $request');
            $method->addBody("    ->withHeader('Content-Type', 'application/json')");
            $method->addBody('    ->withBody($this->streamFactory->createStream(\\json_encode($body, \\JSON_THROW_ON_ERROR)));');
        }

        if ($return->model === null) {
            $method->addBody('$this->httpClient->sendRequest($request);');

            return;
        }

        $method->addBody('$response = $this->httpClient->sendRequest($request);');
        $method->addBody('/** @var mixed $data */');
        $method->addBody('$data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);');

        if ($return->isList) {
            $method->addBody('\assert(\is_array($data));');
            $method->addBody('return \array_values(\array_map(');
            $method->addBody('    static fn(mixed $item): ' . $return->model . ' => self::hydrate(' . $return->model . '::class, $item),');
            $method->addBody('    $data,');
            $method->addBody('));');

            return;
        }

        $method->addBody('return self::hydrate(' . $return->model . '::class, $data);');
    }

    /**
     * @param list<Parameter> $queryParams
     */
    private function emitQueryAssembly(Method $method, array $queryParams): void
    {
        if ($queryParams === []) {
            return;
        }

        $anyOptional = false;

        $method->addBody('$query = [];');

        foreach ($queryParams as $param) {
            $var = new Literal('$' . $param->name);

            if ($param->required) {
                $method->addBody('$query[?] = ?;', [$param->name, $var]);
                continue;
            }

            $anyOptional = true;
            $method->addBody('if (? !== null) { $query[?] = ?; }', [$var, $param->name, $var]);
        }

        if ($anyOptional) {
            $method->addBody('if ($query !== []) { $path .= \'?\' . \http_build_query($query); }');

            return;
        }

        $method->addBody('$path .= \'?\' . \http_build_query($query);');
    }
}
