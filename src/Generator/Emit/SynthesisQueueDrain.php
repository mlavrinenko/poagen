<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameRegistry;

use const DIRECTORY_SEPARATOR;

/**
 * Drains the FIFO queue of synthesised inline-object classes (T-013) that
 * {@see ModelPlanner} accumulates — an object's own inline-object children,
 * and the inline branches {@see UnionBranchSynthesiser} queues. Each
 * emission may itself queue grandchildren; this keeps going until the
 * queue is empty. Sorting each batch by name keeps byte-stability across
 * runs regardless of the order children were discovered.
 *
 * Lives apart from {@see ModelPlanner} for the same reason the sibling
 * {@see UnionBranchSynthesiser} does: linecop's cap
 * (`quality-gates-at-maximum-strictness`) left no room for it there.
 *
 * @internal
 */
final readonly class SynthesisQueueDrain
{
    public function __construct(private ModelEmitter $emitter) {}

    /**
     * @param list<SynthesisedModel> $pending
     * @param array<string,string>   $writes
     * @param list<string>           $failures profile guidance a synthesised model could not honour —
     *                                         appended to, so a caller collecting failures from the
     *                                         named-component path too need not distinguish the two
     */
    public function drain(
        array $pending,
        string $modelNamespace,
        string $modelDir,
        NameRegistry $registry,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$writes,
        ModelNameLedger $ledger,
        array &$failures = [],
    ): void {
        while ($pending !== []) {
            usort(
                $pending,
                static fn(SynthesisedModel $a, SynthesisedModel $b): int => strcmp($a->name, $b->name),
            );

            $batch = $pending;
            $pending = [];

            foreach ($batch as $child) {
                $ledger->claim($child->name, $child->origin);
                $emission = $this->emitter->emit(
                    $modelNamespace,
                    $child->name,
                    $child->schema,
                    $bindings,
                    $enums,
                    $registry,
                    $child->implements,
                );
                $writes[$modelDir . DIRECTORY_SEPARATOR . $child->name . '.php'] = $emission->source;
                $failures = [...$failures, ...$emission->failures];

                foreach ($emission->children as $grand) {
                    $pending[] = $grand;
                }
            }
        }
    }
}
