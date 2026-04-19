<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Nette\PhpGenerator\Method;

/**
 * Emits the body lines that send the request and decode the response.
 *
 * Every method first branches on the HTTP status: anything outside 2xx
 * throws the per-profile `ApiException` (T-012, ADR-009). Successful
 * responses then flow into one of five shapes (mirrored on
 * {@see ReturnSpec::KIND_*}): void, single Model, list-of-Model, scalar
 * (returned via cast on the raw body), and map (decoded
 * `additionalProperties`, returned as the typed associative array).
 *
 * @internal
 */
final readonly class ResponseHandler
{
    public function emit(Method $method, ReturnSpec $return): void
    {
        // Use a `$__status` local to avoid colliding with method parameters
        // named `$status` (e.g. `findPetsByStatus`).
        $method->addBody('$response = $this->httpClient->sendRequest($request);');
        $method->addBody('$__status = $response->getStatusCode();');
        $method->addBody('if ($__status < 200 || $__status >= 300) {');
        $method->addBody('    throw new ApiException($__status, $request, $response);');
        $method->addBody('}');

        if ($return->kind === ReturnSpec::KIND_VOID) {
            // Implicit `return;` at the end of a `void` method; emitting an
            // explicit one would make rector flag it as dead.
            return;
        }

        if ($return->kind === ReturnSpec::KIND_SCALAR) {
            $cast = $return->scalarPhpType ?? 'string';
            $method->addBody('return (' . $cast . ') $response->getBody();');

            return;
        }

        if ($return->kind === ReturnSpec::KIND_MAP) {
            $method->addBody('/** @var array<string, ' . $return->mapValuePhpType . '> $data */');
            $method->addBody('$data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);');
            $method->addBody('return $data;');

            return;
        }

        $method->addBody('/** @var mixed $data */');
        $method->addBody('$data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);');

        if ($return->kind === ReturnSpec::KIND_LIST) {
            $model = (string) $return->model;
            $method->addBody('\assert(\is_array($data));');
            $method->addBody('return \array_values(\array_map(');
            $method->addBody('    static fn(mixed $item): ' . $model . ' => self::hydrate(' . $model . '::class, $item),');
            $method->addBody('    $data,');
            $method->addBody('));');

            return;
        }

        $model = (string) $return->model;
        $method->addBody('return self::hydrate(' . $model . '::class, $data);');
    }
}
