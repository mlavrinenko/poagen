<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use Poagen\Generator\Generator\Emit\DiscriminatorEnforcer;
use Poagen\Runtime\Codec;
use Poagen\Runtime\Format\Base64Codec;
use Poagen\Runtime\ScalarBinding;

/**
 * What the emitters must look up per node and cannot read off the schema,
 * indexed for O(1) lookup at emit time.
 *
 * Three things qualify. The user-side type bindings discovered by scanning the
 * consumer's own namespaces, the per-property overrides `Profile::$propertyFormats`
 * declares directly (bind-a-format-per-property), and the branch-selection
 * each property-level union resolved to — computed once against the whole
 * document, then needed one property at a time by an emitter that holds only
 * that property's node.
 *
 * The union catalog rides here rather than as a parameter of its own because
 * this object is already threaded to every site that needs it, down to
 * `ModelAttributeApplier::apply()`. The obvious alternative, another parameter
 * on `ModelPlanner::plan()`, is not available: that file sits at 245 of
 * linecop's 250 lines.
 */
final readonly class Bindings
{
    /**
     * @param array<string,class-string> $formats Map of OpenAPI format → user value-object FQCN,
     *                                             applying document-wide wherever that format appears.
     *                                             Scanner-verified: every entry came off a real
     *                                             {@see ReflectionClass}, never a hand-typed string.
     * @param array<string,string> $profileFormats Profile::$formats — the same document-wide reach as
     *                                             $formats, declared in the profile rather than
     *                                             discovered on a class, and consulted ahead of it so
     *                                             that naming a binding explicitly overrides whatever
     *                                             the scan happened to find for that format. Verified
     *                                             before the run starts {@see FormatBindingValidator},
     *                                             so unlike $propertyFormats every entry here is known
     *                                             to name a real ScalarBinding by the time an emitter
     *                                             reads it.
     * @param array<string,string> $propertyFormats Profile::$propertyFormats, unsliced and not yet
     *                                             checked — keyed `'<ModelClassName>.<wirePropertyName>'`.
     *                                             Consulted first, ahead of $formats, whenever a caller
     *                                             passes a non-empty `$scopeKey`; a caller that never
     *                                             learnt the owning model's name (an operation parameter,
     *                                             a top-level array wrapper) always passes '' and this
     *                                             map never applies to it. Unlike $formats, an entry here
     *                                             is a bare user-supplied class-string {@see Emit\PropertyFormatKeys}
     *                                             checks per model as it emits, so it may still name a
     *                                             class that does not exist.
     * @param Emit\UnionCatalog $unions How each property-level union picks a branch.
     */
    public function __construct(
        public array $formats,
        public array $profileFormats = [],
        public array $propertyFormats = [],
        public Emit\UnionCatalog $unions = new Emit\UnionCatalog(),
    ) {}

    /**
     * The same bindings with the run's resolved unions attached. Called once,
     * after {@see DiscriminatorEnforcer} has
     * read the whole document — the scan that produces the format bindings runs
     * before the document is even parsed, so the two cannot be built together.
     */
    public function withUnions(Emit\UnionCatalog $unions): self
    {
        return new self($this->formats, $this->profileFormats, $this->propertyFormats, $unions);
    }

    public function formatType(string $format, string $scopeKey = ''): ?string
    {
        return $this->boundType($format, $scopeKey);
    }

    /**
     * Return the bound FQCN for `$format` (or, when `$scopeKey` matches a
     * `Profile::$propertyFormats` entry, for that property regardless of its
     * own `format`) only when that VO opts into the transparent scalar
     * round-trip contract of `hydration-and-serialization-contract`.
     *
     * @return class-string<ScalarBinding>|null
     */
    public function scalarBindingType(string $format, string $scopeKey = ''): ?string
    {
        $fqcn = $this->boundType($format, $scopeKey);

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
     * Resolve a `format` to a scalar-boundary binding: a per-property override
     * if `$scopeKey` names one, else a document-wide user VO implementing
     * {@see ScalarBinding} if one is registered, else a document-wide
     * {@see Codec} if one is, otherwise a poagen built-in (`date-time` and
     * `date` → `\DateTimeImmutable`, `byte` → `Format\Base64Codec` —
     * `base64-binding-for-format-byte`; `byte` is a built-in rather than a
     * ready-made candidate like `uuid` because both directions are PHP core
     * and cost nobody a dependency, the same reason `date-time` is one). A
     * `ScalarBinding` wins over a `Codec` on the same format because it
     * needs nothing further from the emitter — the property is typed as the
     * binding itself — while both win over a built-in so consumers can swap
     * in Carbon, Chronos, or their own base64 handling.
     */
    public function scalarFormat(string $format, string $scopeKey = ''): ?ScalarFormat
    {
        $userBinding = $this->scalarBindingType($format, $scopeKey);

        if ($userBinding !== null) {
            return ScalarFormat::userScalar($userBinding);
        }

        $codec = $this->codecType($format, $scopeKey);

        if ($codec !== null) {
            return ScalarFormat::codec($codec, $codec::targetType());
        }

        // A binding exists (scoped or document-wide) but is neither a
        // ScalarBinding nor a Codec — a whole-object binding, stays off the
        // scalar path.
        if ($this->boundType($format, $scopeKey) !== null) {
            return null;
        }

        return match ($format) {
            'date-time' => ScalarFormat::dateTime(),
            'date' => ScalarFormat::date(),
            'byte' => ScalarFormat::codec(Base64Codec::class, Base64Codec::targetType()),
            default => null,
        };
    }

    /**
     * Return the bound FQCN for `$format` only when it implements
     * {@see Codec} — the foreign-type sibling of {@see scalarBindingType()}.
     * A class satisfying both interfaces is unreachable here in practice
     * (nothing ships one), but if it ever happened `scalarFormat()` still
     * prefers `ScalarBinding`, checked first.
     *
     * @return class-string<Codec>|null
     */
    public function codecType(string $format, string $scopeKey = ''): ?string
    {
        $fqcn = $this->boundType($format, $scopeKey);

        if ($fqcn === null) {
            return null;
        }

        if (!is_a($fqcn, Codec::class, true)) {
            return null;
        }

        /** @var class-string<Codec> $fqcn */
        return $fqcn;
    }

    /**
     * Most specific answer wins. `$propertyFormats[$scopeKey]` beats both
     * document-wide maps whenever `$scopeKey` is non-empty and matches — a
     * scoped entry answers for its one property regardless of what either map
     * says about the same format string, which is the entire point of scoping
     * one (bind-a-format-per-property). Between the two document-wide maps,
     * `$profileFormats` beats `$formats`: the profile named that class on
     * purpose, while a `#[BindsFormat]` under `$discoverIn` was found by a
     * scan the consumer may not have had this format in mind for.
     */
    private function boundType(string $format, string $scopeKey): ?string
    {
        if ($scopeKey !== '' && isset($this->propertyFormats[$scopeKey])) {
            return $this->propertyFormats[$scopeKey];
        }

        if ($format === '') {
            return null;
        }

        return $this->profileFormats[$format] ?? $this->formats[$format] ?? null;
    }
}
