<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function array_fill_keys;
use function array_intersect;
use function array_keys;
use function array_map;
use function array_unique;
use function array_values;
use function count;
use function implode;
use function sort;
use function sprintf;

use const SORT_STRING;

/**
 * A skipped component is never emitted, but nothing about excluding it stops
 * another component's property or another operation's parameter/response
 * from still naming it by `$ref` — the emitted tree then points at a class
 * that does not exist, and the run reports success anyway
 * (a-skipped-component-leaves-dangling-references-behind-it).
 *
 * The owner ruling is refuse, not cascade: this scanner finds every
 * component and operation still reachable from an unrepresentable one and
 * reports it as a problem of its own, on the same footing as the
 * unrepresentable component itself — {@see SkipListValidator} then requires
 * `Profile::$skip` to name it too, exactly as it already requires for any
 * other unrepresentable construct. Nothing here decides to omit a
 * referencer on the consumer's behalf; a referencer still gets emitted
 * unless its own name is in `Profile::$skip`.
 *
 * Component references close over a fixed point, because the cascade is not
 * always one level deep: a component the generator can otherwise represent
 * becomes unrepresentable the moment it is left pointing at an omitted
 * class, so anything that in turn references *that* component inherits the
 * same problem. Operations are always leaves in this graph — nothing in the
 * document references an operation — so they are checked once, against the
 * closed set.
 */
final readonly class DanglingReferenceScanner
{
    /**
     * @param  list<SkippedComponent> $unrepresentable every component the generator already
     *                                                  refuses to emit this run — {@see
     *                                                  ComponentCatalog::skipped()}, a {@see
     *                                                  DiscriminatorEnforcer} union failure, and a
     *                                                  {@see SchemaScan} component skip, merged
     * @param  array<string,string>   $alreadySkipped   operationId => reason, for operations a
     *                                                  different pass already refused — not
     *                                                  re-reported here under a second reason
     * @return array{
     *     excluded: array<string,true>,
     *     components: list<SkippedComponent>,
     *     operations: array<string,string>,
     * }
     */
    public static function scan(OpenApi $openApi, array $unrepresentable, array $alreadySkipped): array
    {
        $seed = array_fill_keys(array_map(static fn(SkippedComponent $c): string => $c->rawName, $unrepresentable), true);
        [$excluded, $cascaded] = self::closeComponents(self::componentReferences($openApi), $seed);

        $components = [];

        foreach ($cascaded as $rawName => $targets) {
            $components[] = new SkippedComponent($rawName, self::componentReason($rawName, $targets));
        }

        return [
            'excluded' => $excluded,
            'components' => $components,
            'operations' => self::danglingOperations($openApi, $excluded, $alreadySkipped),
        ];
    }

    /**
     * @return array<string,list<string>> raw component name => raw names it references directly
     */
    private static function componentReferences(OpenApi $openApi): array
    {
        $components = $openApi->components;
        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components === null ? [] : ($components->schemas ?? []);
        $out = [];

        foreach ($schemas as $rawName => $schema) {
            if ($schema instanceof Schema) {
                $out[(string) $rawName] = ReferencedComponents::of($schema);
            }
        }

        return $out;
    }

    /**
     * A component that references anything already excluded is excluded
     * too — the class it would point at does not exist either way — and the
     * search repeats until a pass finds nothing new.
     *
     * @param  array<string,list<string>> $refsOf
     * @param  array<string,true>         $seed
     * @return array{0: array<string,true>, 1: array<string,list<string>>}
     */
    private static function closeComponents(array $refsOf, array $seed): array
    {
        $excluded = $seed;
        $cascaded = [];

        do {
            $changed = false;

            foreach ($refsOf as $rawName => $refs) {
                if (isset($excluded[$rawName])) {
                    continue;
                }

                $hit = array_values(array_intersect($refs, array_keys($excluded)));

                if ($hit === []) {
                    continue;
                }

                sort($hit, SORT_STRING);
                $excluded[$rawName] = true;
                $cascaded[$rawName] = $hit;
                $changed = true;
            }
        } while ($changed);

        return [$excluded, $cascaded];
    }

    /**
     * @param  array<string,true>   $excluded
     * @param  array<string,string> $alreadySkipped
     * @return array<string,string> operationId => reason
     */
    private static function danglingOperations(OpenApi $openApi, array $excluded, array $alreadySkipped): array
    {
        $out = [];

        foreach (OperationOrder::inEmissionOrder($openApi) as [, , $operation, $pathItem]) {
            $operationId = (string) ($operation->operationId ?? '');

            if ($operationId === '') {
                continue;
            }

            if (isset($alreadySkipped[$operationId])) {
                continue;
            }

            $refs = OperationReferencedComponents::of($operation, $pathItem);
            $hit = array_values(array_unique(array_intersect($refs, array_keys($excluded))));

            if ($hit === []) {
                continue;
            }

            sort($hit, SORT_STRING);
            $out[$operationId] = self::operationReason($operationId, $hit);
        }

        return $out;
    }

    /**
     * @param list<string> $targets
     */
    private static function componentReason(string $rawName, array $targets): string
    {
        $isPlural = count($targets) > 1;
        $plural = $isPlural ? 's' : '';
        $list = implode(', ', array_map(static fn(string $t): string => "`{$t}`", $targets));

        return sprintf(
            'component `%s` still declares a property, item or branch typed as skipped component%s %s — '
                . 'Profile::$skip already omits %s entirely, so `%s` would reference a class that does not '
                . "exist. Paste into Profile::\$skip to omit `%s` too:\n      '%s' => 'references skipped "
                . "component%s %s',",
            $rawName,
            $plural,
            $list,
            $isPlural ? 'them' : 'it',
            $rawName,
            $rawName,
            $rawName,
            $plural,
            $list,
        );
    }

    /**
     * @param list<string> $targets
     */
    private static function operationReason(string $operationId, array $targets): string
    {
        $plural = count($targets) > 1 ? 's' : '';
        $list = implode(', ', array_map(static fn(string $t): string => "`{$t}`", $targets));

        return sprintf(
            'references skipped component%s %s — a parameter or response type would point at a class that does '
                . "not exist. Paste into Profile::\$skip to omit this operation too:\n      '%s' => 'references "
                . "skipped component%s %s',",
            $plural,
            $list,
            $operationId,
            $plural,
            $list,
        );
    }
}
