<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Schema;

use function array_keys;
use function sprintf;

/**
 * Refuses a JSON Schema 2020-12 keyword that reached the emitters through
 * OpenAPI 3.1 and that none of them implements.
 *
 * A 3.1-native parser widens the input surface: keywords the 3.0 pipeline
 * never had to reason about now arrive parsed and intact. Every one of them
 * has a third outcome available besides "represented" and "refused" — read,
 * misinterpreted, emitted as something else — and that outcome is the one
 * `openapi-31-through-a-maintained-parser` accepted the wider surface on
 * condition of closing. A keyword listed here therefore stops the run by
 * name rather than being ignored into a client that quietly says less than
 * the document does.
 *
 * These are refusals, not gaps in the walk: implementing any of them is a
 * task of its own, and until one is asked for, the honest output is no output.
 *
 * The keyword has to be read through `__isset()` because the parser models
 * none of them — it keeps an unknown key verbatim and answers for it through
 * its magic accessors, so `__isset()` is the public question "did the
 * document write this keyword here". A JSON `null` written as `const: null`
 * reads as absent through that accessor and is the one spelling this misses;
 * it is also the one spelling that says nothing a bare type does not.
 *
 * @internal
 */
final readonly class UnsupportedKeywordScanner
{
    /**
     * Keyword → what poagen would have to invent to emit it, and the way out
     * that does not need poagen to change.
     *
     * @var array<string,string>
     */
    private const array KEYWORDS = [
        'const' => 'pins the value, not the type, and no emitter carries a value constraint — poagen would emit '
            . 'the declared type and accept everything the vendor rejects. Write it as a single-member `enum`, '
            . 'which poagen emits as a backed enum with one case',
        'prefixItems' => 'types an array position by position, and PHP has no tuple type — an emitted `array` '
            . 'would say nothing about which position holds what. Give the array one `items` type, or model the '
            . 'positions as named properties of an object',
        'unevaluatedProperties' => 'constrains whatever no subschema evaluated, which is a fact about the whole '
            . 'composition rather than about this node — poagen resolves composition itself and would drop the '
            . 'constraint on the floor. Use `additionalProperties` on the schema that owns the properties',
        'contentMediaType' => 'says this string carries a document of another media type inside it, and poagen '
            . 'would emit a plain `string` and leave the payload unparsed. Model the embedded document as a '
            . 'schema of its own and reference it',
    ];

    /**
     * @return string|null a complete diagnostic for a node this refuses, null
     *                     for one it accepts
     */
    public static function probe(Schema $schema): ?string
    {
        foreach (self::KEYWORDS as $keyword => $problem) {
            if (!$schema->__isset($keyword)) {
                continue;
            }

            return sprintf(
                'schema at %s uses the JSON Schema 2020-12 keyword `%s`, which poagen does not implement: it %s. '
                    . 'Or name this operation or component in Profile::$skip to generate without it',
                SynthesisedModel::originOf($schema),
                $keyword,
                $problem,
            );
        }

        return null;
    }

    /**
     * `webhooks` is refused whole rather than through {@see SkippedOperation},
     * because it is not an operation poagen could have emitted and left out.
     * It sits beside `paths` at the top of a 3.1 document and describes calls
     * the vendor makes to the consumer — the opposite direction from every
     * client poagen emits. The default stays a refusal even once a consumer
     * can opt out: `webhooks-refuse-with-no-opt-out` widened
     * `Profile::$skip`'s key space ({@see WebhookSkipKey}) rather than making
     * a webhook disappear unasked, because the omission the vendor's document
     * asked about is not one poagen would take silently — see
     * `skip-is-the-only-opt-out`.
     *
     * Generating the `paths` half alone and saying nothing is the outcome
     * `fail-loud-never-silent` exists to prevent: the client would look
     * complete and describe half the document. A webhook named in `$skip`
     * is therefore left out of this list entirely — it fails nothing and
     * prints nothing here, and {@see skippedWebhooks} reports it as an
     * accepted omission instead.
     *
     * @param  array<string,string> $skip Profile::$skip
     * @return list<string>         failure lines, one per unskipped webhook entry
     */
    public static function webhookFailures(OpenApi $openApi, array $skip): array
    {
        $out = [];

        foreach ($openApi->webhooks ?? [] as $name => $webhook) {
            if (isset($skip[WebhookSkipKey::forName((string) $name)])) {
                continue;
            }

            $out[] = sprintf(
                '`webhooks` at #/webhooks/%s (%s) — an OpenAPI 3.1 webhook describes a call the vendor makes to '
                    . 'the consumer, and poagen emits a client that calls the vendor. No emitter models one, and '
                    . 'generating the paths alone would drop it silently. Remove the webhook from the document '
                    . 'poagen generates from, ask for webhook support, or name it in Profile::$skip as \'%s\' to '
                    . 'generate the paths alone.',
                (string) $name,
                self::describeWebhook($webhook),
                WebhookSkipKey::forName((string) $name),
            );
        }

        return $out;
    }

    /**
     * The webhooks `$skip` accepted this run — the mirror image of
     * {@see webhookFailures}: every entry here is one the consumer asked to
     * omit, so nothing about it fails or feeds a diagnostic. Reported to the
     * consumer the same way an accepted operation or component skip is, so
     * an omission the consumer wrote stays visible rather than vanishing
     * quietly into a smaller client (`silence-means-success`).
     *
     * @param  array<string,string>  $skip Profile::$skip
     * @return list<SkippedWebhook>
     */
    public static function skippedWebhooks(OpenApi $openApi, array $skip): array
    {
        $out = [];

        foreach (array_keys($openApi->webhooks ?? []) as $name) {
            $key = WebhookSkipKey::forName((string) $name);

            if (isset($skip[$key])) {
                $out[] = new SkippedWebhook((string) $name, $skip[$key]);
            }
        }

        return $out;
    }

    /**
     * The methods a webhook entry declares, and the operation ids behind them,
     * so the line names something a reader can find in their own document
     * rather than only the entry it hangs off.
     */
    private static function describeWebhook(mixed $webhook): string
    {
        if (!$webhook instanceof PathItem) {
            return 'not a path item';
        }

        $parts = [];

        foreach ($webhook->getOperations() as $httpMethod => $operation) {
            $id = (string) ($operation->operationId ?? '');
            $parts[] = $id === ''
                ? strtoupper((string) $httpMethod)
                : sprintf('%s, operationId `%s`', strtoupper((string) $httpMethod), $id);
        }

        return $parts === [] ? 'no operations' : implode('; ', $parts);
    }
}
