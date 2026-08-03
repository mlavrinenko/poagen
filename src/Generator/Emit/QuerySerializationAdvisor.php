<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Schema;

use function count;
use function implode;
use function is_object;
use function sprintf;

use const SORT_STRING;

/**
 * Names every query parameter whose repeated-key wire form rests on an
 * OpenAPI default the document never spelled out.
 *
 * `Endpoint::query()` has exactly one serialisation for a list value: one
 * repeated key per item. That is what `style: form` / `explode: true`
 * means, and it is also `query`'s own OpenAPI default — so a document that
 * says nothing about either still gets the right wire form
 * (`ParameterShape::supportsQuery()` refuses the one case this would not
 * be true: a document that spells out something else). Correct, but
 * silent, and `real-world-schemas` asks the generator to say so rather
 * than let a reader assume the vendor was explicit — the same reasoning
 * `FormatAdvisor` already applies to an unrecognised `format`.
 *
 * `support-the-parameter-shapes-real-documents-use`: DigitalOcean's
 * `job_names` and GitHub's `fields`/`has` are exactly this — nine
 * operations across both, none of which declares `style` or `explode`.
 *
 * @internal
 */
final readonly class QuerySerializationAdvisor
{
    /**
     * @return list<string> zero or one notice; the whole set is reported as
     *                      one line, same reason {@see OperationIdAdvisor} does
     */
    public static function notices(OpenApi $openApi): array
    {
        $defaulted = [];

        foreach (self::listValuedQueryParameters($openApi) as [$operationId, $param]) {
            if (self::declaresSerialization($param)) {
                continue;
            }

            $defaulted[] = sprintf('%s (%s)', $param->name, $operationId);
        }

        if ($defaulted === []) {
            return [];
        }

        sort($defaulted, SORT_STRING);

        return [sprintf(
            '%d query parameter(s) whose value can repeat declare neither `style` nor `explode`: %s. The OpenAPI '
                . 'default for `query` applies — `style: form`, `explode: true` — so a list value is sent as one '
                . 'repeated key per item, which is what Endpoint::query() emits.',
            count($defaulted),
            implode(', ', $defaulted),
        )];
    }

    /**
     * Every emitted query parameter ({@see ParameterShape::supports()})
     * whose value can be a list — a plain array of scalars, or a
     * `oneOf`/`anyOf` of a scalar and a list of one — in declaration order.
     *
     * @return list<array{string, Parameter}>
     */
    private static function listValuedQueryParameters(OpenApi $openApi): array
    {
        $paths = $openApi->paths;

        if ($paths === null) {
            return [];
        }

        $out = [];

        foreach ($paths as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                $params = ParameterCollector::collect($operation, $pathItem);

                if ($params === null) {
                    continue;
                }

                $id = (string) ($operation->operationId ?? '');

                foreach ($params as $param) {
                    if ($param->in === 'query' && ParameterShape::supports($param) && self::isListValued($param)) {
                        $out[] = [$id, $param];
                    }
                }
            }
        }

        return $out;
    }

    private static function isListValued(Parameter $param): bool
    {
        if (ParameterShape::isArrayQuery($param)) {
            return true;
        }

        $schema = $param->schema;

        return $schema instanceof Schema && CompositionResolver::resolveScalarOrList($schema) instanceof TypeResolver;
    }

    /**
     * True when the document itself spelled out `style` or `explode` for
     * this parameter, rather than relying on the specification's default.
     * `getSerializableData()` carries only what the document declared —
     * unlike the `style`/`explode` accessors, which cebe's own reader
     * already backfills with the default before this ever sees it.
     */
    private static function declaresSerialization(Parameter $param): bool
    {
        $raw = $param->getSerializableData();

        return is_object($raw) && (isset($raw->style) || isset($raw->explode));
    }
}
