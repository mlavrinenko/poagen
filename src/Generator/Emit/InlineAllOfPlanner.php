<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Schema;
use LogicException;
use Poagen\Generator\Generator\Naming\InlinePayloadName;

/**
 * Turns an {@see AllOfMerge} into what {@see InlinePayloadPlanner} needs for
 * one operation's request body or response — a {@see BodySpec}/{@see ReturnSpec}
 * on success, or a refusal reason written to the `$refusal` out-parameter
 * (never silently returned as a plain null the caller cannot explain;
 * abort-on-unrepresentable-constructs).
 *
 * Split from {@see InlinePayloadPlanner} to keep both under the linecop
 * limit.
 *
 * Request and response share the single-object merge (a class named through
 * {@see InlinePayloadName}, matching the non-`allOf` synthesis naming already
 * in {@see RequestBodyPlanner}/`InlinePayloadPlanner::planResponse()`),
 * but only the request side accepts a `oneOf`/`anyOf` branch union: turning
 * it into N synthesised classes and a PHP union parameter is safe because
 * the caller already holds a concrete instance of one of them. A response
 * union would need to hydrate an incoming JSON body into the right branch —
 * a discriminator or union-pin decision this class does not make on the
 * corpus's behalf — so a response `allOf` with a union member refuses by
 * name rather than guessing.
 *
 * @internal
 */
final readonly class InlineAllOfPlanner
{
    /**
     * @param list<SynthesisedModel> $roots
     */
    public static function planRequest(
        Schema $schema,
        string $base,
        ?string $pin,
        OpenApi $openApi,
        ModelNameLedger $ledger,
        array &$roots,
        ?string &$refusal,
    ): ?BodySpec {
        $merge = CompositionResolver::mergeAllOf($schema, $openApi);

        if (!$merge instanceof AllOfMerge) {
            return null;
        }

        if ($merge->isRefused()) {
            $refusal = $merge->refusal;

            return null;
        }

        if ($merge->isUnion()) {
            $models = [];

            foreach ($merge->branches ?? [] as $branch) {
                $models[] = InlinePayloadPlanner::claim($base . $branch->label, $branch->schema, $ledger, $roots, $branch->origin);
            }

            return BodySpec::jsonUnion($models);
        }

        $name = InlineModelClaim::named(
            $pin,
            InlinePayloadName::request($base),
            $merge->schema ?? throw new LogicException('allOf merge missing schema'),
            $ledger,
            $roots,
            SynthesisedModel::originOf($schema),
        );

        return BodySpec::json($name);
    }

    /**
     * @param list<SynthesisedModel> $roots
     */
    public static function planResponse(
        Schema $schema,
        string $base,
        string $status,
        ?string $pin,
        OpenApi $openApi,
        ModelNameLedger $ledger,
        array &$roots,
        ?string &$refusal,
    ): ?ReturnSpec {
        $merge = CompositionResolver::mergeAllOf($schema, $openApi);

        if (!$merge instanceof AllOfMerge) {
            return null;
        }

        if ($merge->isUnion()) {
            $refusal = 'allOf response has a oneOf/anyOf member — poagen does not synthesise a response branch '
                . 'union (hydrating an incoming body into the right branch needs a discriminator or a union pin '
                . 'this class does not have); merge the branches in the document, or skip the operation';

            return null;
        }

        if ($merge->isRefused()) {
            $refusal = $merge->refusal;

            return null;
        }

        $name = InlineModelClaim::named(
            $pin,
            InlinePayloadName::response($base, $status),
            $merge->schema ?? throw new LogicException('allOf merge missing schema'),
            $ledger,
            $roots,
            SynthesisedModel::originOf($schema),
        );

        return ReturnSpec::model($name);
    }
}
