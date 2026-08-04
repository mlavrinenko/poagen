<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Parameter;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Generator\Generator\Naming\NormalisationContext;
use Poagen\Generator\Generator\Naming\SymbolKind;

/**
 * One OpenAPI parameter paired with the PHP identifier the emitter
 * uses for it inside a method signature and body.
 *
 * The OpenAPI name (`Content-Type`, `X-Trace-ID`) is what the wire
 * needs — the path template token, the header key, the query key.
 * The PHP name (`contentType`, `xTraceId`) is what `Method::addParameter`
 * accepts and what `$path = \str_replace('{Content-Type}', ...)` would
 * never produce. T-025 routes both through the registry so poagen no
 * longer skips an op just because its raw parameter is `Content-Type`.
 *
 * @internal
 */
final readonly class ResolvedParameter
{
    public function __construct(
        public Parameter $param,
        public string $phpName,
    ) {}

    /**
     * Pair every parameter with the PHP identifier the registry gives it.
     *
     * @param  list<Parameter>         $params
     * @return list<ResolvedParameter>
     */
    public static function resolveAll(array $params, NameRegistry $registry): array
    {
        $context = new NormalisationContext(SymbolKind::ParameterName);
        $out = [];

        foreach ($params as $param) {
            $out[] = new self($param, $registry->resolve($param->name, $context));
        }

        return $out;
    }

    public function rawName(): string
    {
        return $this->param->name;
    }
}
