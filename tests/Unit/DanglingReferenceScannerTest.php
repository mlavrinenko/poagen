<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use Mlavrinenko\Paogen\Generator\Emit\DanglingReferenceScanner;
use Mlavrinenko\Paogen\Generator\Emit\DiscriminatorEnforcer;
use Mlavrinenko\Paogen\Generator\Emit\SkippedComponent;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Tests\Integration\DanglingComponentReferenceTest;
use PHPUnit\Framework\TestCase;

/**
 * Unit coverage for {@see DanglingReferenceScanner} directly, isolated from
 * the full {@see Generator} pipeline — {@see DanglingComponentReferenceTest}
 * covers the end-to-end behaviour through `Profile::$skip` and the exception
 * message; this asserts the scan's own return shape.
 */
final class DanglingReferenceScannerTest extends TestCase
{
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/dangling-component-reference-3.0.yaml';

    public function testClosesOverASecondLevelComponentCascade(): void
    {
        $result = DanglingReferenceScanner::scan($this->openApi(), $this->gadgetUnrepresentable(), []);

        // Wrapper is not in the seed — it only becomes excluded because it
        // references Gadget — proving the fixed point runs at all.
        self::assertSame(['Gadget' => true, 'Wrapper' => true], $result['excluded']);
        self::assertCount(1, $result['components']);
        self::assertSame('Wrapper', $result['components'][0]->rawName);
        self::assertStringContainsString('references skipped component `Gadget`', $result['components'][0]->reason);
    }

    public function testFindsBothOperationsAgainstTheClosedSet(): void
    {
        $result = DanglingReferenceScanner::scan($this->openApi(), $this->gadgetUnrepresentable(), []);

        self::assertArrayHasKey('getGadget', $result['operations']);
        self::assertArrayHasKey('getWrapper', $result['operations']);
        self::assertArrayNotHasKey('ping', $result['operations']);
        self::assertStringContainsString('references skipped component `Gadget`', $result['operations']['getGadget']);
        self::assertStringContainsString('references skipped component `Wrapper`', $result['operations']['getWrapper']);
    }

    public function testAnOperationAlreadySkippedForAnotherReasonIsNotDoubleReported(): void
    {
        $result = DanglingReferenceScanner::scan(
            $this->openApi(),
            $this->gadgetUnrepresentable(),
            ['getGadget' => 'refused for an unrelated reason'],
        );

        self::assertArrayNotHasKey('getGadget', $result['operations']);
        self::assertArrayHasKey('getWrapper', $result['operations']);
    }

    public function testAnEmptySeedFindsNothing(): void
    {
        $result = DanglingReferenceScanner::scan($this->openApi(), [], []);

        self::assertSame([], $result['excluded']);
        self::assertSame([], $result['components']);
        self::assertSame([], $result['operations']);
    }

    private function openApi(): OpenApi
    {
        $openApi = Reader::readFromYamlFile(self::SCHEMA, OpenApi::class, false);
        self::assertInstanceOf(OpenApi::class, $openApi);

        return $openApi;
    }

    /**
     * @return list<SkippedComponent> just `Gadget`, standing in for what
     *                                {@see DiscriminatorEnforcer}
     *                                would report for the fixture's undiscriminated union
     */
    private function gadgetUnrepresentable(): array
    {
        return [new SkippedComponent('Gadget', 'undiscriminated union')];
    }
}
