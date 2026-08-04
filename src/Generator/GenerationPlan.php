<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

/**
 * The outcome of planning a generation run without touching disk.
 *
 * Split out so that `--dry-run` and `--diff` can inspect the would-be
 * writes and prunes without committing them; `Generator::generate()`
 * runs the plan and then applies it in the usual path.
 */
final readonly class GenerationPlan
{
    /**
     * @param array<string,string>   $writes              Absolute paths mapped to their would-be file contents.
     * @param list<string>           $prunes              Absolute paths that would be deleted by the prune step.
     * @param list<Emit\SkippedOperation> $skippedOperations Operations the generator did not emit. Reaching a
     *                                                    successful plan with a non-empty list here means every
     *                                                    one of them was explicitly accepted via `Profile::$skip`
     *                                                    (abort-on-unrepresentable-constructs) — otherwise
     *                                                    {@see Generator::plan()}
     *                                                    throws instead of returning.
     * @param list<Emit\SkippedComponent> $skippedComponents Components (or components with an undiscriminated
     *                                                    union property) the generator did not emit. Same
     *                                                    skip-list guarantee as $skippedOperations.
     * @param list<Emit\SkippedWebhook> $skippedWebhooks Top-level `webhooks:` entries the generator did not emit
     *                                                    because `Profile::$skip` named them
     *                                                    (webhooks-refuse-with-no-opt-out). Unlike the two lists
     *                                                    above, reaching a successful plan says nothing about
     *                                                    whether every webhook was accounted for — a webhook the
     *                                                    document declares and `$skip` does not name still throws,
     *                                                    it never lands here empty-handed.
     * @param list<string>           $notices             Facts about the document worth a reader's attention that
     *                                                    are not omissions: nothing here was left out of the
     *                                                    emitted tree. They name an opportunity the consumer's
     *                                                    guidance could take — an operation id with no word
     *                                                    boundaries, a format annotation poagen does not know —
     *                                                    which is what `real-world-schemas` means by asking for
     *                                                    guidance and saying exactly what is needed. Distinct from
     *                                                    the skip lists on purpose: a notice never affects the
     *                                                    exit status, because a run that shrank the client is a
     *                                                    failure and a run that could be more pleasant is not.
     */
    public function __construct(
        public array $writes,
        public array $prunes,
        public array $skippedOperations = [],
        public array $skippedComponents = [],
        public array $skippedWebhooks = [],
        public array $notices = [],
    ) {}
}
