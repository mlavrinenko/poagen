<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;

/**
 * Names every `format` annotation the generator does not recognise, with a
 * count and one place it appeared, and says what binds it.
 *
 * An unknown format falls through to the base type. That is the right fallback —
 * the base type does carry the value — but done silently it loses the one thing
 * the consumer would have wanted to know: that a field they think of as a
 * timestamp, a phone number or a money amount arrived as a bare string, and that
 * a value object of their own would have typed it. Aborting instead is worse: it
 * would cost a whole client over an annotation the vendor invented.
 *
 * So this reports, and reporting is all it does. Nothing is omitted from the
 * emitted tree, so nothing here moves the exit status — the distinction
 * `silence-means-success` draws is between a run that shrank the client and a
 * run that could be more pleasant, and this is the second kind.
 *
 * The kilbil loyalty document is what makes the case: nine distinct format
 * values across 292 uses, of which paogen knows one. `date time` is `date-time`
 * misspelled with a space, and `data`/`data time` are further typos of it — 15
 * timestamps that would reach a consumer as strings with nothing said.
 *
 * @internal
 */
final readonly class FormatAdvisor
{
    /**
     * @return list<string> one line per distinct unrecognised format, ordered by
     *                      descending use count so the most consequential reads first
     */
    public static function notices(OpenApi $openApi, Bindings $bindings): array
    {
        /** @var array<string,int> $counts */
        $counts = [];
        /** @var array<string,string> $firstSeen */
        $firstSeen = [];

        foreach (self::schemasOf($openApi) as $schema) {
            self::walk($schema, $bindings, $counts, $firstSeen);
        }

        if ($counts === []) {
            return [];
        }

        // Sort by count descending, then by name, so the order is a fact about
        // the document rather than about iteration.
        $formats = array_keys($counts);
        usort($formats, static fn(string $a, string $b): int => [$counts[$b], $a] <=> [$counts[$a], $b]);

        $notices = [];

        foreach ($formats as $format) {
            $notices[] = \sprintf(
                "format '%s' is not one paogen recognises — %d use(s), first at %s. The property keeps its base "
                    . "type. To give it a type of your own, put #[BindsFormat('%s')] on a value object in a "
                    . 'namespace listed in Profile::$discoverIn; implement Runtime\\ScalarBinding on it and paogen '
                    . 'round-trips it as the underlying scalar at the wire boundary.',
                $format,
                $counts[$format],
                $firstSeen[$format],
                $format,
            );
        }

        return $notices;
    }

    /**
     * @param array<string,int>    $counts
     * @param array<string,string> $firstSeen
     */
    private static function walk(Schema $schema, Bindings $bindings, array &$counts, array &$firstSeen): void
    {
        $format = $schema->format;

        if (\is_string($format) && $format !== '' && !self::isRecognised($format, $bindings)) {
            $counts[$format] = ($counts[$format] ?? 0) + 1;
            $firstSeen[$format] ??= SynthesisedModel::originOf($schema);
        }

        foreach (\is_array($schema->properties) ? $schema->properties : [] as $property) {
            if ($property instanceof Schema) {
                self::walk($property, $bindings, $counts, $firstSeen);
            }
        }

        foreach ([$schema->items, $schema->additionalProperties] as $child) {
            if ($child instanceof Schema) {
                self::walk($child, $bindings, $counts, $firstSeen);
            }
        }

        foreach ([$schema->allOf, $schema->oneOf, $schema->anyOf] as $branches) {
            foreach (\is_array($branches) ? $branches : [] as $branch) {
                if ($branch instanceof Schema) {
                    self::walk($branch, $bindings, $counts, $firstSeen);
                }
            }
        }
    }

    /**
     * Recognised means paogen already resolves it to a real type: one of its own
     * built-ins, or a format the consumer bound to a value object of theirs.
     * Everything else is an opportunity nobody has taken yet — including the
     * standard width hints like `int64`, because a consumer may well want a
     * value object over one, and a rule that guessed which formats are "already
     * good enough" would be the generator deciding on their behalf.
     */
    private static function isRecognised(string $format, Bindings $bindings): bool
    {
        return $bindings->scalarFormat($format) instanceof \Mlavrinenko\Paogen\Generator\ScalarFormat
            || $bindings->formatType($format) !== null;
    }

    /**
     * Every schema root in the document: named components, and each operation's
     * body, responses and parameters.
     *
     * @return list<Schema>
     */
    private static function schemasOf(OpenApi $openApi): array
    {
        $out = [];
        $components = $openApi->components;

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components === null ? [] : ($components->schemas ?? []);

        foreach ($schemas as $schema) {
            if ($schema instanceof Schema) {
                $out[] = $schema;
            }
        }

        $paths = $openApi->paths;

        foreach ($paths ?? [] as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                $out = [...$out, ...self::operationSchemas($operation)];
            }
        }

        return $out;
    }

    /**
     * @return list<Schema>
     */
    private static function operationSchemas(Operation $operation): array
    {
        $out = [];
        $body = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        foreach ($body instanceof \cebe\openapi\spec\RequestBody ? $body->content : [] as $media) {
            if ($media->schema instanceof Schema) {
                $out[] = $media->schema;
            }
        }

        $responses = $operation->responses;

        foreach ($responses === null ? [] : $responses->getResponses() as $response) {
            if (!$response instanceof Response) {
                continue;
            }

            foreach ($response->content as $media) {
                if ($media->schema instanceof Schema) {
                    $out[] = $media->schema;
                }
            }
        }

        foreach ($operation->parameters ?? [] as $parameter) {
            if (!$parameter instanceof Reference && $parameter->schema instanceof Schema) {
                $out[] = $parameter->schema;
            }
        }

        return $out;
    }
}
