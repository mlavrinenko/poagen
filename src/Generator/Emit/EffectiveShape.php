<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function is_array;

/**
 * What one schema actually declares, once `allOf` has been folded in.
 *
 * A union branch rarely spells its fields out in one place. GitHub composes
 * most of them — `oneOf: [$ref A]` where `A` is `allOf: [$ref B, {...}]` — so
 * reading `properties` and `required` off the branch node answers "nothing"
 * for a schema that declares plenty. {@see BranchSelectors} needs the real
 * answer, because a field it thinks no branch declares is a field it would
 * wrongly treat as decisive.
 *
 * Two sets, deliberately kept apart. `required` is what a payload of this
 * branch is promised to carry; `declared` is every name the branch knows about
 * at all. The discriminating-field rule reads one of each — required *here*,
 * not declared *there* — and collapsing them would make it either far too
 * strict or unsound.
 *
 * References are followed only through `allOf`, and only to a bounded depth, so
 * a document that composes a cycle cannot spin this forever.
 *
 * @internal
 */
final readonly class EffectiveShape
{
    private const int MAX_DEPTH = 8;

    /**
     * @param array<string,true> $declared every property name the branch knows about
     * @param array<string,true> $required the subset a payload must carry
     * @param bool               $closed   the branch accepts `{}` and nothing else
     */
    private function __construct(
        public array $declared,
        public array $required,
        public bool $closed,
    ) {}

    public static function of(Schema $schema, OpenApi $openApi): self
    {
        [$declared, $required] = self::walk($schema, $openApi, 0);

        return new self($declared, $required, $declared === [] && ObjectShape::declaresClosedShape($schema));
    }

    /**
     * @return array{0:array<string,true>,1:array<string,true>}
     */
    private static function walk(Schema $schema, OpenApi $openApi, int $depth): array
    {
        $declared = [];
        $required = [];

        if (is_array($schema->properties)) {
            foreach (array_keys($schema->properties) as $name) {
                $declared[(string) $name] = true;
            }
        }

        if (is_array($schema->required)) {
            foreach ($schema->required as $name) {
                $required[(string) $name] = true;
            }
        }

        if ($depth >= self::MAX_DEPTH || !is_array($schema->allOf)) {
            return [$declared, $required];
        }

        foreach ($schema->allOf as $branch) {
            $target = self::resolve($branch, $openApi);

            if (!$target instanceof Schema) {
                continue;
            }

            [$branchDeclared, $branchRequired] = self::walk($target, $openApi, $depth + 1);
            $declared += $branchDeclared;
            $required += $branchRequired;
        }

        return [$declared, $required];
    }

    public static function resolve(Schema|Reference $node, OpenApi $openApi): ?Schema
    {
        if ($node instanceof Schema) {
            return $node;
        }

        $components = $openApi->components;

        if ($components === null) {
            return null;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $target = $schemas[ComponentName::rawFromRef($node->getReference())] ?? null;

        return $target instanceof Schema ? $target : null;
    }
}
