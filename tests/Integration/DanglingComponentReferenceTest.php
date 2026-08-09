<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Generator\Tests\Support\SkipPlanFixture;

/**
 * a-skipped-component-leaves-dangling-references-behind-it: skipping a
 * component whose type is still referenced used to emit cleanly and leave a
 * dangling class reference behind — the run reported success on a tree that
 * does not analyse. The owner ruling is refuse, not cascade
 * (refuse-a-skip-that-leaves-dangling-references): the run stops, names
 * every operation and component still reaching the skipped one, and prints
 * the `Profile::$skip` entries that would resolve it.
 *
 * Fixture: tests/fixtures/schemas/dangling-component-reference-3.0.yaml.
 * `Gadget.owner` is an undiscriminated union, so the whole `Gadget`
 * component is unrepresentable (the same shape
 * `unrepresentable-3.0.yaml` already covers). `Wrapper` is a fully
 * representable object whose only property is a `$ref` to `Gadget` — a
 * component reaching a skipped one. `getGadget` returns `Gadget` directly;
 * `getWrapper` returns `Wrapper`, which is only a problem once `Wrapper`
 * itself is excluded by the cascade, proving the closure reaches a second
 * level rather than stopping at the first. `ping` touches none of this.
 */
final class DanglingComponentReferenceTest extends TestCase
{
    use GeneratedTreeSandbox;
    use SkipPlanFixture;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/dangling-component-reference-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\DanglingComponentReference';

    /** Accepts every problem the fixture raises — the "everything named" case. */
    private const array FULLY_ACCEPTED_SKIP = [
        'Gadget' => 'undiscriminated union',
        'Wrapper' => 'references skipped component `Gadget`',
        'getGadget' => 'references skipped component `Gadget`',
        'getWrapper' => 'references skipped component `Wrapper`',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testSkippingOnlyTheComponentRefusesNamingEveryReferencer(): void
    {
        try {
            $this->plan(['Gadget' => 'undiscriminated union']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            // Gadget itself is accepted; the three problems left are the
            // referencers this task is about — one cascaded component, two
            // operations.
            self::assertStringContainsString('3 problems found', $message);
            // The component cascade: Wrapper still references Gadget.
            self::assertStringContainsString('component `Wrapper`', $message);
            self::assertStringContainsString('references skipped component `Gadget`', $message);
            // Both operations that reach a skipped component, named by id.
            self::assertStringContainsString('getGadget', $message);
            self::assertStringContainsString('getWrapper', $message);
        }
    }

    public function testMessagePrintsPasteReadySkipEntries(): void
    {
        try {
            $this->plan(['Gadget' => 'undiscriminated union']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            // Literal, copy-pasteable Profile::$skip entries — the ruling's
            // "ready to paste", not merely a prose pointer at the feature.
            self::assertStringContainsString("'Wrapper' => 'references skipped component `Gadget`',", $message);
            self::assertStringContainsString("'getGadget' => 'references skipped component `Gadget`',", $message);
            self::assertStringContainsString("'getWrapper' => 'references skipped component `Wrapper`',", $message);
        }
    }

    public function testAcceptingEveryPrintedEntryProducesACleanTreeWithNoDanglingReference(): void
    {
        $plan = $this->plan(self::FULLY_ACCEPTED_SKIP);

        self::assertCount(2, $plan->skippedOperations);
        self::assertCount(2, $plan->skippedComponents);

        $sources = implode("\n", array_values($plan->writes));

        // The whole point: nothing in the emitted tree names the omitted
        // classes, so nothing in it can produce a PHPStan class.notFound —
        // the defect this task closes was exactly this string appearing.
        self::assertStringNotContainsString('Gadget', $sources);
        self::assertStringNotContainsString('Wrapper', $sources);

        self::assertStringContainsString('function ping(', $sources);
        self::assertStringNotContainsString('function getGadget(', $sources);
        self::assertStringNotContainsString('function getWrapper(', $sources);
    }

    public function testOperationSkipListedOnlyBecauseOfACascadedComponentIsNotStale(): void
    {
        // `Wrapper` deliberately left unaccepted: it still fails (below),
        // but `getWrapper` — accepted only because it reaches `Wrapper` —
        // must not be reported stale for want of `Wrapper`'s own entry.
        // poagen used to judge an operation representable on its own and
        // call this exact entry stale; this is the acceptance criterion for
        // that fix.
        try {
            $this->plan([
                'Gadget' => 'undiscriminated union',
                'getGadget' => 'references skipped component `Gadget`',
                'getWrapper' => 'references skipped component `Wrapper`',
            ]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('1 problem found', $message);
            self::assertStringContainsString('component `Wrapper`', $message);
            self::assertStringNotContainsString('getWrapper', $message);
            self::assertStringNotContainsString("Profile::\$skip['getWrapper']", $message);
            self::assertStringNotContainsString('stale', $message);
        }
    }

    public function testAnUnrelatedSkipEntryIsStillReportedStale(): void
    {
        $skip = self::FULLY_ACCEPTED_SKIP;
        $skip['ping'] = 'no longer needed';

        try {
            $this->plan($skip);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('1 problem found', $message);
            self::assertStringContainsString("Profile::\$skip['ping']", $message);
            self::assertStringContainsString('stale', $message);
        }
    }
}
