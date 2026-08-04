<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use function str_ends_with;
use function strlen;
use function substr;

/**
 * The `Profile::$skip` key spelling for a webhook: the webhook's own key in
 * the document's `webhooks:` map, suffixed `.webhook` so it cannot collide
 * with an operation id or a raw component name — the other two things
 * `Profile::$skip` already names bare. Settled by
 * `webhooks-refuse-with-no-opt-out`: widen the one opt-out surface
 * `skip-is-the-only-opt-out` already governs rather than open a second map.
 *
 * Same shape as {@see InlineModelSite}'s `'<operationId>.<position>'` and
 * `Profile::$xmlElements`'s `'<operationId>.item'`: split on the last dot,
 * dynamic part first, a literal role last. Here the literal part marks the
 * *kind* of the leading identifier — "this is a webhook name, not an
 * operation id" — rather than picking a facet of one shared owner, which is
 * what every other dotted key in this family does instead. A webhook name
 * containing a literal dot would be misparsed the same way a dotted
 * operation id already would by {@see InlineModelSite}; no fixture in this
 * project or its examples has one.
 *
 * @internal
 */
final readonly class WebhookSkipKey
{
    private const string SUFFIX = '.webhook';

    /** The `Profile::$skip` key naming this webhook whole. */
    public static function forName(string $webhookName): string
    {
        return $webhookName . self::SUFFIX;
    }

    /**
     * @return string|null the webhook name a `Profile::$skip` key names, or
     *                      null when the key does not carry the webhook suffix
     */
    public static function webhookNameOf(string $skipKey): ?string
    {
        return str_ends_with($skipKey, self::SUFFIX)
            ? substr($skipKey, 0, -strlen(self::SUFFIX))
            : null;
    }
}
