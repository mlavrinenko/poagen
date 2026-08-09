<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\ResponseMapGroups;

/**
 * `opt-in-collapse-for-repeated-response-maps`: the half of
 * `Profile::$responseMaps` validation that needs nothing but the profile, so
 * it runs before the document is read. Every failure line names the entry it
 * came from — the shape every other profile validator here already follows.
 */
final class ResponseMapGroupsTest extends TestCase
{
    public function testNoGroupsPasses(): void
    {
        self::assertSame([], ResponseMapGroups::structuralFailures([]));
    }

    public function testTwoWellFormedGroupsPass(): void
    {
        self::assertSame([], ResponseMapGroups::structuralFailures([
            'gatewayMutation' => ['deleteInvoice', 'voidInvoice'],
            'readOutcome' => ['getInvoice', 'getCustomer'],
        ]));
    }

    public function testAKeyThatIsNotAPhpMethodNameFails(): void
    {
        $failures = ResponseMapGroups::structuralFailures([
            'gateway mutation' => ['deleteInvoice', 'voidInvoice'],
        ]);

        self::assertCount(1, $failures);
        self::assertStringContainsString("Profile::\$responseMaps['gateway mutation']", $failures[0]);
        self::assertStringContainsString('not a valid PHP method name', $failures[0]);
    }

    public function testTwoKeysDifferingOnlyInCaseFail(): void
    {
        $failures = ResponseMapGroups::structuralFailures([
            'gatewayMutation' => ['deleteInvoice', 'voidInvoice'],
            'GatewayMutation' => ['getInvoice', 'getCustomer'],
        ]);

        self::assertCount(1, $failures);
        self::assertStringContainsString("Profile::\$responseMaps['GatewayMutation']", $failures[0]);
        self::assertStringContainsString("collides with 'gatewayMutation'", $failures[0]);
    }

    public function testAGroupOfOneFails(): void
    {
        $failures = ResponseMapGroups::structuralFailures([
            'gatewayMutation' => ['deleteInvoice'],
        ]);

        self::assertCount(1, $failures);
        self::assertStringContainsString("Profile::\$responseMaps['gatewayMutation']", $failures[0]);
        self::assertStringContainsString('fewer than two operations', $failures[0]);
    }

    public function testAnEmptyGroupFails(): void
    {
        $failures = ResponseMapGroups::structuralFailures(['gatewayMutation' => []]);

        self::assertCount(1, $failures);
        self::assertStringContainsString('fewer than two operations', $failures[0]);
    }

    public function testAnOperationNamedTwiceInOneGroupFails(): void
    {
        $failures = ResponseMapGroups::structuralFailures([
            'gatewayMutation' => ['deleteInvoice', 'voidInvoice', 'deleteInvoice'],
        ]);

        self::assertCount(1, $failures);
        self::assertStringContainsString("names the operation id 'deleteInvoice' twice", $failures[0]);
    }

    public function testAnOperationClaimedByTwoGroupsFails(): void
    {
        $failures = ResponseMapGroups::structuralFailures([
            'gatewayMutation' => ['deleteInvoice', 'voidInvoice'],
            'readOutcome' => ['getCustomer', 'deleteInvoice'],
        ]);

        self::assertCount(1, $failures);
        self::assertStringContainsString("Profile::\$responseMaps['readOutcome']", $failures[0]);
        self::assertStringContainsString("'gatewayMutation' already claims", $failures[0]);
    }

    public function testEveryProblemIsReportedInOnePass(): void
    {
        $failures = ResponseMapGroups::structuralFailures([
            'gateway mutation' => ['deleteInvoice', 'voidInvoice'],
            'readOutcome' => ['getCustomer'],
        ]);

        self::assertCount(2, $failures);
    }

    public function testAssertWellFormedThrowsNamingTheEntry(): void
    {
        $this->expectException(UnrepresentableConstructsException::class);
        $this->expectExceptionMessageMatches("/responseMaps\\['gatewayMutation'\\]/");

        ResponseMapGroups::assertWellFormed(['gatewayMutation' => ['deleteInvoice']]);
    }

    public function testAssertWellFormedAcceptsAWellFormedProfile(): void
    {
        $groups = ['gatewayMutation' => ['deleteInvoice', 'voidInvoice']];
        ResponseMapGroups::assertWellFormed($groups);

        // Reached only because the call above did not throw; the assertion
        // pins the same fact from the other side rather than asserting `true`.
        self::assertSame([], ResponseMapGroups::structuralFailures($groups));
    }
}
