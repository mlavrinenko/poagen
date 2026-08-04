<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\SecurityRequirement;
use stdClass;

use function is_string;

/**
 * Reads the scheme names, and the scopes beside them, out of a `security`
 * block — the document's global one or an operation's own.
 *
 * A security requirement names its schemes as its own keys: a
 * `SecurityRequirement` has no fixed attribute list, so `{"apiKey": []}` is
 * one object whose single key is the scheme name and whose value is the
 * list of scopes that scheme's declaration has to cover.
 *
 * `devizzent/cebe-php-openapi` hands `$openApi->security` and
 * `$operation->security` over as a plain list of those objects, which is
 * what its docblock says. The parser this replaced wrapped the list in a
 * `SecurityRequirements` container with a `getRequirements()` accessor and
 * declared the same docblock type anyway; that class does not exist in the
 * fork (`vendor/devizzent/cebe-php-openapi/src/spec/` has
 * `SecurityRequirement` only). `getSerializableData()` is the public way to
 * read the keys of an object with no fixed attributes.
 *
 * @internal
 */
final readonly class SecurityRequirements
{
    /**
     * `null` is the absent-override case on an Operation, kept apart from an
     * empty list by {@see forOperation}.
     *
     * @param array<SecurityRequirement>|null $security
     *
     * @return array<string, list<string>> scheme name → declared scopes, in document order
     */
    public static function read(?array $security): array
    {
        $out = [];

        foreach ($security ?? [] as $requirement) {
            if (!$requirement instanceof SecurityRequirement) {
                continue;
            }

            $data = $requirement->getSerializableData();

            if (!$data instanceof stdClass) {
                continue;
            }

            foreach (get_object_vars($data) as $name => $scopes) {
                // An object property name is always a string, but PHP array
                // keys are not, so the key is normalised rather than left as
                // the `array-key` the iteration hands over.
                $key = (string) $name;
                $out[$key] = [...($out[$key] ?? []), ...self::scopes($scopes)];
            }
        }

        return $out;
    }

    /**
     * OpenAPI 3.0.3 §4.8.20:
     *   - an operation-level `security: []` (empty array) overrides and
     *     disables the global requirement;
     *   - an absent operation-level `security` inherits the global;
     *   - a non-empty operation-level `security` replaces the global.
     *
     * Absent means "inherit" and `security: []` means "no auth here" — two
     * different facts that both read as an empty name map. The parser
     * presents the absent one as `null` (per attributeDefaults) and the
     * empty one as `[]`, so telling them apart needs `isset`, not a count.
     *
     * @param  array<string, list<string>> $global
     * @return array<string, list<string>>
     */
    public static function forOperation(Operation $operation, array $global): array
    {
        if (!isset($operation->security)) {
            return $global;
        }

        return self::read($operation->security);
    }

    /**
     * @return list<string>
     */
    private static function scopes(mixed $scopes): array
    {
        $out = [];

        foreach (is_array($scopes) ? $scopes : [] as $scope) {
            if (is_string($scope) && $scope !== '') {
                $out[] = $scope;
            }
        }

        return $out;
    }
}
