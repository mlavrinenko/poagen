<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Runtime\ScalarBinding;

/**
 * Discovered user-side type bindings, indexed for O(1) lookup at emit time.
 */
final readonly class Bindings
{
    /**
     * @param array<string,class-string> $formats Map of OpenAPI format → user value-object FQCN.
     */
    public function __construct(public array $formats) {}

    public function formatType(string $format): ?string
    {
        return $this->formats[$format] ?? null;
    }

    /**
     * Return the bound FQCN for `$format` only when that VO opts into the
     * transparent scalar round-trip contract of ADR-007.
     *
     * @return class-string<ScalarBinding>|null
     */
    public function scalarBindingType(string $format): ?string
    {
        $fqcn = $this->formats[$format] ?? null;

        if ($fqcn === null) {
            return null;
        }

        if (!is_a($fqcn, ScalarBinding::class, true)) {
            return null;
        }

        /** @var class-string<ScalarBinding> $fqcn */
        return $fqcn;
    }

    /**
     * Resolve a `format` to a scalar-boundary binding: a user VO implementing
     * {@see ScalarBinding} if one is registered, otherwise a paogen built-in
     * (currently `date-time` and `date` → `\DateTimeImmutable`). User bindings
     * always win so consumers can swap in Carbon, Chronos, etc.
     */
    public function scalarFormat(string $format): ?ScalarFormat
    {
        $userBinding = $this->scalarBindingType($format);

        if ($userBinding !== null) {
            return ScalarFormat::userScalar($userBinding);
        }

        // User-registered non-ScalarBinding VO (object binding) stays on the
        // whole-object path — not a scalar format.
        if (isset($this->formats[$format])) {
            return null;
        }

        return match ($format) {
            'date-time' => ScalarFormat::dateTime(),
            'date' => ScalarFormat::date(),
            default => null,
        };
    }
}
