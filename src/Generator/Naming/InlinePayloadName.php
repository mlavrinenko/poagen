<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

use Mlavrinenko\Paogen\Generator\Emit\InlinePayloadPlanner;

/**
 * One derivation rule for every class {@see InlinePayloadPlanner}
 * synthesises from an operation's own request or response body:
 * `{OperationId}{Position}Content`, where `Position` is the response status
 * exactly as the document spells it — `200`, `403`, `default`, `4XX` — or the
 * literal word `Request` where a status would sit for the request direction.
 * One rule, read two ways, rather than two independently-invented ones
 * (name-inline-schemas-by-operation-and-status).
 *
 * The status half is deliberately *not* run through {@see PascalCaseSanitiser}
 * or any other case-normalising strategy the way a component or operation id
 * is. `default` stays `default` and `4XX` stays `4XX` — the document's own
 * spelling is the point, so a reader who has the schema open recognises the
 * class instantly. The only transformation applied is the minimum needed to
 * keep the result a legal PHP identifier fragment: a character outside
 * `[A-Za-z0-9_]` is folded to `_`. A bare status code never needs it — every
 * character in `200`, `403`, `4XX` and `default` is already legal — but a
 * vendor is free to invent stranger status keys than the ones measured here.
 *
 * `$base` is always the *normalised* operation id, already `ucfirst`-ed by
 * the caller, so it always starts with a letter — which is what makes a
 * digit-led position token such as `200` safe to append: nothing here ever
 * has to be the first character of the whole identifier.
 *
 * @internal
 */
final readonly class InlinePayloadName
{
    private const string SUFFIX = 'Content';

    /**
     * `{Base}RequestContent`, or `{Base}RequestContentItem` for the item
     * class of a request body that is an array of inline objects.
     */
    public static function request(string $base, bool $item = false): string
    {
        return self::compose($base, 'Request', $item);
    }

    /**
     * `{Base}{Status}Content`, or `{Base}{Status}ContentItem` for the item
     * class of a response that is an array of inline objects. `$status` is
     * the response's own key in the document — `'200'`, `'403'`, `'default'`,
     * `'4XX'` — read verbatim except for the minimal legality mangling
     * {@see statusToken()} performs.
     */
    public static function response(string $base, string $status, bool $item = false): string
    {
        return self::compose($base, self::statusToken($status), $item);
    }

    /**
     * The status exactly as the document spells it, mangled only as far as
     * making it a legal PHP identifier fragment requires: any character
     * outside `[A-Za-z0-9_]` becomes `_`. Public so a caller building its own
     * diagnostic or notice can name the same token this class would derive
     * without duplicating the rule.
     */
    public static function statusToken(string $status): string
    {
        $mangled = preg_replace('/[^A-Za-z0-9_]/', '_', $status);

        return $mangled === null || $mangled === '' ? '_' : $mangled;
    }

    private static function compose(string $base, string $positionToken, bool $item): string
    {
        return $base . $positionToken . self::SUFFIX . ($item ? 'Item' : '');
    }
}
