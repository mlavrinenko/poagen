<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime;

use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Inventory;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Labels;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Tag;
use PHPUnit\Framework\TestCase;

/**
 * declared-shapes-become-types: a schema declaring both `properties` and a
 * schema for its extra keys emits a class carrying both, and both survive the
 * wire.
 *
 * A declared property is found by its wire name; extra keys have none, so the
 * property carrying them is found by `#[AdditionalProperties]` instead. That
 * marker is the whole mechanism — without it, the generator would emit a typed
 * map nothing ever fills, which is a new dishonesty in place of the old one.
 */
final class AdditionalPropertiesRoundTripTest extends TestCase
{
    public function testExtraKeysLandInTheMapAndComeBackOutBesideTheDeclaredOnes(): void
    {
        $payload = ['primary' => 'front', 'left' => 'port', 'right' => 'starboard'];

        $labels = new Hydrator()->hydrate(Labels::class, $payload);

        self::assertSame('front', $labels->primary);
        self::assertSame(['left' => 'port', 'right' => 'starboard'], $labels->additionalProperties);

        // Beside, not nested: the extras were keys of the payload and that is
        // where they go back, in a stable order.
        self::assertSame($payload, new Marshaller()->marshal($labels));
    }

    public function testADeclaredPropertyKeepsItsOwnKey(): void
    {
        $labels = new Hydrator()->hydrate(Labels::class, ['primary' => 'front']);

        self::assertSame('front', $labels->primary);
        self::assertSame([], $labels->additionalProperties);
    }

    public function testAnAbsentDeclaredPropertyDoesNotPutItsKeyInTheMap(): void
    {
        $labels = new Hydrator()->hydrate(Labels::class, ['left' => 'port']);

        self::assertNull($labels->primary);
        self::assertSame(['left' => 'port'], $labels->additionalProperties);
    }

    public function testExtraValuesAreTypedByTheSchemaThatDeclaredThem(): void
    {
        $inventory = new Hydrator()->hydrate(Inventory::class, [
            'warehouse' => 'north',
            'spare' => ['id' => 7, 'name' => 'bolt'],
        ]);

        $spare = $inventory->additionalProperties['spare'] ?? null;

        self::assertSame('north', $inventory->warehouse);
        self::assertInstanceOf(Tag::class, $spare);
        self::assertSame(7, $spare->id);
        self::assertSame('bolt', $spare->name);
    }

    public function testTypedExtraValuesMarshalBackToTheirWireForm(): void
    {
        $inventory = new Inventory('north', ['spare' => new Tag(7, 'bolt')]);

        self::assertSame(
            ['warehouse' => 'north', 'spare' => ['id' => 7, 'name' => 'bolt']],
            new Marshaller()->marshal($inventory),
        );
    }

    public function testAnExtraKeyCannotOverwriteADeclaredWireName(): void
    {
        // Only reachable by constructing the model by hand — the hydrator never
        // puts a declared key in the map. The declared property still wins,
        // because a model that could be marshalled into a payload it cannot be
        // hydrated back from would not round-trip at all.
        $labels = new Labels('front', ['primary' => 'smuggled', 'left' => 'port']);

        self::assertSame(['primary' => 'front', 'left' => 'port'], new Marshaller()->marshal($labels));
    }
}
