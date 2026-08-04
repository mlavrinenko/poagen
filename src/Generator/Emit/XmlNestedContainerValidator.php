<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter;

use function array_keys;
use function count;
use function explode;
use function in_array;
use function is_int;
use function sprintf;

/**
 * Cross-checks the `'<operationId>.item.<property>'` form of
 * `Profile::$xmlElements` against the document — the nested-container layer
 * {@see XmlWriter} reads, keyed one property below the plain root/item pair
 * {@see ProfileTargetValidator} leaves unchecked (that pair has always been
 * permitted to go stale silently; this key form is new, so it does not
 * inherit that gap).
 *
 * Same discipline as every other profile-guidance validator here
 * (abort-on-unrepresentable-constructs): a binding naming an operation id, or
 * a property of that operation's XML item schema, absent from the document
 * fails the run instead of silently doing nothing. {@see InlineXmlRequestPlanner}
 * wires a validated entry straight onto the generated `Endpoint::xmlList()`
 * call (thread-the-validated-nested-container-map-into-the-generated-client),
 * so this check runs before that happens — a stale entry would otherwise
 * reach the wire as a wrong nesting rather than merely looking like working
 * guidance.
 *
 * @internal
 */
final readonly class XmlNestedContainerValidator
{
    /**
     * @param  array<string,string> $xmlElements Profile::$xmlElements
     * @param  array<string,true>   $known       every operation id the document declares
     * @return list<string>         failure lines; empty means the run may proceed
     */
    public static function validate(OpenApi $openApi, array $xmlElements, array $known): array
    {
        $failures = [];

        foreach (array_keys($xmlElements) as $key) {
            $parts = explode('.', $key, 3);

            if (count($parts) !== 3) {
                continue;
            }

            if ($parts[1] !== 'item') {
                continue;
            }

            $failure = self::validateEntry($openApi, $key, $parts[0], $parts[2], $known);

            if ($failure !== null) {
                $failures[] = $failure;
            }
        }

        return $failures;
    }

    /**
     * @param array<string,true> $known
     */
    private static function validateEntry(
        OpenApi $openApi,
        string $key,
        string $operationId,
        string $property,
        array $known,
    ): ?string {
        if (!isset($known[$operationId])) {
            return sprintf(
                "Profile::\$xmlElements['%s'] names an operation id absent from the schema — remove this entry, "
                    . 'or point it at the operation id the vendor now uses.',
                $key,
            );
        }

        $items = InlineXmlRequestPlanner::itemSchemaOf($openApi, $operationId);

        if (!$items instanceof Schema) {
            return sprintf(
                "Profile::\$xmlElements['%s'] names a nested container, but '%s' has no application/xml request "
                    . 'body whose schema is an array of objects — remove this entry, or point it at an operation '
                    . 'that does.',
                $key,
                $operationId,
            );
        }

        if (in_array($property, self::propertyNames($items), true)) {
            return null;
        }

        return sprintf(
            "Profile::\$xmlElements['%s'] names the property '%s', absent from operation '%s''s XML item schema — "
                . 'remove this entry, or point it at the property name the vendor now uses.',
            $key,
            $property,
            $operationId,
        );
    }

    /**
     * @return list<string>
     */
    private static function propertyNames(Schema $schema): array
    {
        $names = [];

        // YAML parses a purely numeric key as an int; coerce to string the
        // same way {@see \Mlavrinenko\Paogen\Generator\PropertyRenameValidator} does.
        foreach (array_keys($schema->properties ?? []) as $name) {
            $names[] = is_int($name) ? (string) $name : $name;
        }

        return $names;
    }
}
