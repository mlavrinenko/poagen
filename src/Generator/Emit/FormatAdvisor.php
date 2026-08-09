<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\ReadyMadeBindings;
use Poagen\Generator\Generator\ScalarFormat;

use function is_string;
use function spl_object_id;
use function sprintf;

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
 * values across 292 uses, of which poagen knows one. `date time` is `date-time`
 * misspelled with a space, and `data`/`data time` are further typos of it — 15
 * timestamps that would reach a consumer as strings with nothing said.
 *
 * `binary-format-advisory-fires-on-a-format-that-now-drives-behaviour`: a
 * request or response body's own content-type schema is a different case
 * from a property's. `represent-non-json-request-and-response-bodies` made
 * {@see BodyMediaType} read `format: binary` there to choose the whole
 * body's shape — a `Psr\Http\Message\StreamInterface` parameter instead of
 * a JSON model — so "the property keeps its base type" is false exactly
 * where that reading applies: nothing degrades, the caller gets the type
 * the vendor asked for. A `format: binary` anywhere else — nested in a
 * property, on a parameter — is not read by anything, so it stays
 * unrecognised like any other unbound format. {@see isRecognised()} tells
 * the two apart by asking {@see BodyMediaType} itself, at the exact schema
 * node in question, rather than special-casing the string `'binary'` here
 * — a second copy of that literal is exactly the kind of list that drifts
 * the day {@see BodyMediaType} changes what it reads as binary.
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
        $bodyMediaTypes = self::bodyMediaTypesByObject($openApi);

        foreach (SchemaWalk::roots($openApi) as $schema) {
            self::walk($schema, $bindings, $bodyMediaTypes, $counts, $firstSeen);
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
            $notices[] = sprintf(
                "format '%s' is not one poagen recognises — %d use(s), first at %s. The property keeps its base "
                    . 'type. %s',
                $format,
                $counts[$format],
                $firstSeen[$format],
                self::advice($format),
            );
        }

        return $notices;
    }

    /**
     * What to do about it. Two answers, because for a format poagen already
     * ships a binding for, telling the consumer to go write a value object is
     * advice that costs them an afternoon poagen could have saved
     * (`ship-ready-made-uuid-bindings`). Naming the package alongside the
     * class is deliberate: selecting a binding whose library is not installed
     * fails at run time with a class-not-found, and this is the line that
     * could have said so first.
     */
    private static function advice(string $format): string
    {
        $candidates = ReadyMadeBindings::candidatesFor($format);

        if ($candidates !== null) {
            return sprintf(
                "poagen ships a binding for it: put ['%s' => <one of %s>] in Profile::\$formats and require that "
                    . 'package. A value object of your own goes in the same map.',
                $format,
                $candidates,
            );
        }

        return sprintf(
            'To give it a type of your own, implement Runtime\\ScalarBinding on a value object and either name '
                . "it in Profile::\$formats as ['%s' => YourValueObject::class], or put #[BindsFormat('%s')] on "
                . 'it in a namespace listed in Profile::$discoverIn; poagen round-trips it as the underlying '
                . 'scalar at the wire boundary.',
            $format,
            $format,
        );
    }

    /**
     * @param array<int,string>    $bodyMediaTypes schema object id => media type, from
     *                                              {@see bodyMediaTypesByObject()}
     * @param array<string,int>    $counts
     * @param array<string,string> $firstSeen
     */
    private static function walk(Schema $schema, Bindings $bindings, array $bodyMediaTypes, array &$counts, array &$firstSeen): void
    {
        $format = $schema->format;

        if (is_string($format) && $format !== '' && !self::isRecognised($format, $schema, $bindings, $bodyMediaTypes)) {
            $counts[$format] = ($counts[$format] ?? 0) + 1;
            $firstSeen[$format] ??= SynthesisedModel::originOf($schema);
        }

        foreach (SchemaWalk::children($schema) as $child) {
            self::walk($child, $bindings, $bodyMediaTypes, $counts, $firstSeen);
        }
    }

    /**
     * Every request-body and response content schema in the document,
     * keyed by object identity against the media type it sits under — the
     * exact pair {@see BodyMediaType::isBinary()} takes. Object identity
     * rather than the schema's own position in the walk, because {@see
     * SchemaWalk} flattens components, bodies, responses and parameters
     * into one undifferentiated list; this is what lets {@see
     * isRecognised()} tell a body's own schema apart from a component or a
     * parameter without SchemaWalk having to carry that distinction for
     * every other caller too.
     *
     * @return array<int,string>
     */
    private static function bodyMediaTypesByObject(OpenApi $openApi): array
    {
        $out = [];

        foreach (SchemaWalk::bodySchemas($openApi) as [$mediaType, $schema]) {
            $out[spl_object_id($schema)] = $mediaType;
        }

        return $out;
    }

    /**
     * Recognised means poagen already resolves it to a real type: one of its own
     * built-ins, or a format the consumer bound to a value object of theirs —
     * or, when `$schema` is itself a request/response body's content schema,
     * a format {@see BodyMediaType} reads to choose the body's whole shape
     * rather than a property's type. Everything else is an opportunity
     * nobody has taken yet — including the standard width hints like
     * `int64`, because a consumer may well want a value object over one, and
     * a rule that guessed which formats are "already good enough" would be
     * the generator deciding on their behalf.
     *
     * @param array<int,string> $bodyMediaTypes
     */
    private static function isRecognised(string $format, Schema $schema, Bindings $bindings, array $bodyMediaTypes): bool
    {
        $mediaType = $bodyMediaTypes[spl_object_id($schema)] ?? null;

        if ($mediaType !== null && BodyMediaType::isBinary($mediaType, $schema)) {
            return true;
        }

        return $bindings->scalarFormat($format) instanceof ScalarFormat
            || $bindings->formatType($format) !== null;
    }

}
