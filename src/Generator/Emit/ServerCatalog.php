<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Server;
use stdClass;

use function array_keys;
use function array_map;
use function count;
use function get_object_vars;
use function implode;
use function is_array;
use function preg_match;
use function preg_replace;
use function sprintf;
use function strtoupper;
use function trim;

/**
 * Resolves the document's `servers:` list — read by nothing before this —
 * into the constants {@see ServerConstantEmitter} puts on the root client,
 * and the failures that abort a run declaring a server variable, which
 * poagen does not substitute (emit-declared-servers-so-the-base-address-
 * comes-from-the-document).
 *
 * OpenAPI 3.0.3 §4.7.9.1 defaults an absent or empty `servers:` to a single
 * synthetic entry with `url: /`, so nothing the consumer wrote is behind
 * it. {@see self::declared()} reads the raw parsed data rather than the
 * `OpenApi::$servers` magic property specifically to tell that synthetic
 * default apart from a document that genuinely declares one server — every
 * fixture and vendored document in this repo besides the four servers ones
 * would otherwise gain a useless `SERVER_1 = '/'` constant.
 *
 * @internal
 */
final readonly class ServerCatalog
{
    /**
     * Servers without variables, in declaration order, each carrying the
     * constant name it will be emitted under. A server with variables is
     * excluded here — {@see self::variableProblems} is what refuses the run
     * over it, so no caller ever emits a constant for one.
     *
     * @return list<ResolvedServer>
     */
    public static function resolve(OpenApi $openApi): array
    {
        $used = [];
        $out = [];

        foreach (self::declared($openApi) as $index => $server) {
            if (self::hasVariables($server)) {
                continue;
            }

            $description = self::description($server);
            $name = self::disambiguate(self::baseName($description, $index), $used);
            $out[] = new ResolvedServer($name, (string) $server->url, $description);
        }

        return $out;
    }

    /**
     * One failure line per declared server that templates its URL with a
     * `{variable}` — the construct the acceptance criteria refuse by name
     * rather than emit half-resolved: a constant carrying an unsubstituted
     * template reads like a usable URL and is not one.
     *
     * @return list<string>
     */
    public static function variableProblems(OpenApi $openApi): array
    {
        $out = [];

        foreach (self::declared($openApi) as $index => $server) {
            if (!self::hasVariables($server)) {
                continue;
            }

            $names = array_map(static fn(int|string $name): string => "'" . $name . "'", array_keys($server->variables));

            $out[] = sprintf(
                "server #/servers/%d ('%s') declares variable(s) %s — poagen does not substitute server-variable "
                    . 'templates, and emitting the URL unresolved would produce a constant that looks like a usable '
                    . 'address and is not one. Replace the template in the server URL with a literal value in the '
                    . 'document, or drop the variable. Profile::$skip cannot accept it, because a skip entry names '
                    . 'an operation under `paths` or a component, and a server is neither.',
                $index,
                (string) $server->url,
                implode(', ', $names),
            );
        }

        return $out;
    }

    /**
     * The document's own `servers:` entries, or an empty list when the key
     * is absent or explicitly empty — both read identically off `OpenApi`'s
     * public magic property because the parser substitutes the same
     * synthetic default for either. `getSerializableData()` is read instead
     * because it reflects only what the document itself set, before that
     * substitution runs.
     *
     * @return list<Server>
     */
    private static function declared(OpenApi $openApi): array
    {
        $raw = $openApi->getSerializableData();
        $rawVars = $raw instanceof stdClass ? get_object_vars($raw) : [];
        $rawServers = $rawVars['servers'] ?? [];

        if (!is_array($rawServers) || count($rawServers) === 0) {
            return [];
        }

        // `OpenApi::$servers`' own docblock types it `Server[]`, which
        // PHPStan reads as `array<int, Server>` rather than `list<Server>` —
        // the parser always hands the YAML/JSON array back with sequential
        // keys, so narrowing here is honest, not a workaround.
        /** @var list<Server> $servers */
        $servers = $openApi->servers;

        return $servers;
    }

    private static function hasVariables(Server $server): bool
    {
        return $server->variables !== [];
    }

    private static function description(Server $server): ?string
    {
        $description = $server->description;

        return $description !== null && trim($description) !== '' ? $description : null;
    }

    private static function baseName(?string $description, int $index): string
    {
        if ($description !== null) {
            $slug = self::slug($description);

            if ($slug !== '') {
                return $slug;
            }
        }

        return 'SERVER_' . ($index + 1);
    }

    /**
     * Upper-cases and collapses everything that is not `[A-Z0-9]` into a
     * single underscore, so `"production"` becomes `PRODUCTION` and a
     * description made only of punctuation resolves to the empty string —
     * {@see self::baseName} falls back to the positional name when it does.
     * A slug PHP cannot start an identifier with (leading digit) is
     * prefixed rather than dropped, so it stays traceable to the
     * description that produced it.
     */
    private static function slug(string $text): string
    {
        $upper = strtoupper($text);
        $replaced = preg_replace('/[^A-Z0-9]+/', '_', $upper) ?? '';
        $trimmed = trim($replaced, '_');

        if ($trimmed === '') {
            return '';
        }

        return preg_match('/^\d/', $trimmed) === 1 ? 'SERVER_' . $trimmed : $trimmed;
    }

    /**
     * Breaks a collision between two servers whose descriptions (or
     * positional fallback) produced the same base name — same discipline as
     * {@see SecuritySchemeCatalog::disambiguateCtorArgs}, one field over.
     *
     * @param array<string,true> $used
     */
    private static function disambiguate(string $base, array &$used): string
    {
        $name = $base;
        $suffix = 2;

        while (isset($used[$name])) {
            $name = $base . '_' . $suffix;
            ++$suffix;
        }

        $used[$name] = true;

        return $name;
    }
}
