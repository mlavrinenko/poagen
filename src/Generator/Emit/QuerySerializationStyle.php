<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Parameter;

/**
 * Whether a query parameter's effective `style`/`explode` — the document's
 * own, or the specification's default when it left them unspecified, cebe's
 * reader backfills either way — is the one pair `Endpoint::query()`
 * implements: a list value as one repeated key per item.
 *
 * `query`'s (and `cookie`'s) own OpenAPI default already is `style: form` /
 * `explode: true`, so a document that says nothing about either is
 * unaffected — {@see ParameterShape::supportsQuery()} is the only caller
 * that needs the false case, and {@see QuerySerializationAdvisor} the true
 * one, so it is asked once here rather than reimplemented per caller.
 *
 * Extracted from {@see ParameterShape} to keep that file under
 * `quality-gates-at-maximum-strictness`'s 250-line limit, the same reason
 * {@see ScalarOrListResolver} sits beside {@see CompositionResolver} rather
 * than inside it.
 *
 * @internal
 */
final readonly class QuerySerializationStyle
{
    public static function isFormExploded(Parameter $param): bool
    {
        return $param->style === 'form' && $param->explode === true;
    }
}
