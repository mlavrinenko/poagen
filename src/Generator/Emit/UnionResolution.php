<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use function count;
use function rtrim;
use function sprintf;

/**
 * How one property-level union picks a branch, decided once at plan time and
 * read back by {@see ModelAttributeApplier} when the property is emitted.
 *
 * Four outcomes, in the precedence {@see DiscriminatorEnforcer} applies them.
 * A tag inside the value is the document's own `discriminator` and keeps the
 * behaviour it always had. A tag on the parent is the layer the two largest
 * GitHub unions need, because that is where GitHub actually puts theirs. A
 * structural selector is computed from the branches themselves and needs no
 * guidance at all. A pin narrows the property to one branch, and is the only
 * one of the four that throws declared shapes away — which is why it is
 * stale-checked like `Profile::$skip` and reported on every run, not only on
 * the run that introduced it.
 *
 * @internal
 */
final readonly class UnionResolution
{
    public const string KIND_TAG_IN_VALUE = 'tag-in-value';
    public const string KIND_TAG_ON_PARENT = 'tag-on-parent';
    public const string KIND_STRUCTURAL = 'structural';
    public const string KIND_PIN = 'pin';

    /**
     * @param array<string,string> $map wire tag => raw branch component name
     */
    private function __construct(
        public string $kind,
        public string $notice,
        public ?string $field = null,
        public array $map = [],
        public ?BranchSelectors $selectors = null,
    ) {}

    public static function tagInValue(string $position, string $field, int $branches): self
    {
        return new self(
            self::KIND_TAG_IN_VALUE,
            sprintf(
                'union at %s selects on the `%s` field inside the value, across %d branches, as the document\'s own '
                    . '`discriminator` declares. A tag the mapping does not name raises at runtime.',
                $position,
                $field,
                $branches,
            ),
            field: $field,
        );
    }

    /**
     * @param array<string,string> $map
     */
    public static function tagOnParent(string $position, string $field, array $map, string $source, string $unmapped = ''): self
    {
        return new self(
            self::KIND_TAG_ON_PARENT,
            sprintf(
                'union at %s selects on the enclosing object\'s `%s` field (%s), across %d branches. An absent tag, '
                    . 'or a value the mapping does not name, raises at runtime.%s',
                $position,
                $field,
                $source,
                count($map),
                $unmapped,
            ),
            field: $field,
            map: $map,
        );
    }

    public static function structural(string $position, BranchSelectors $selectors): self
    {
        return new self(
            self::KIND_STRUCTURAL,
            sprintf(
                'union at %s selects by discriminating field: %s. A payload carrying none of these fields, or more '
                    . 'than one, raises at runtime.',
                $position,
                $selectors->describe(),
            ),
            selectors: $selectors,
        );
    }

    public static function pin(string $position, string $key, string $branch, string $reason, int $discarded): self
    {
        return new self(
            self::KIND_PIN,
            sprintf(
                'union at %s is pinned to `%s` by Profile::$unionPins[\'%s\'] — %s. The other %d branch(es) are '
                    . 'unreachable through this property, and a payload of one of them hydrates as `%s` without '
                    . 'error, because these branches accept each other\'s payloads. This line is printed on every '
                    . 'run, not only the one that added the pin.',
                $position,
                $branch,
                $key,
                rtrim($reason, ' .'),
                $discarded,
                $branch,
            ),
        );
    }
}
