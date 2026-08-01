<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime;

use DateTimeImmutable;
use DateTimeInterface;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Animal;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Cat;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Contact;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Dog;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Email;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Order;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Pet;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Status;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Tag;
use PHPUnit\Framework\TestCase;

/**
 * Direct unit coverage for {@see Marshaller} and {@see Hydrator}, indep-
 * endent of the generator pipeline. ADR-010 in scope.
 */
final class MarshalRoundTripTest extends TestCase
{
    public function testWireNameRoundTrip(): void
    {
        $contact = new Contact(displayName: 'Ada', email: new Email('ada@example'));

        $array = new Marshaller()->marshal($contact);

        self::assertSame(
            ['display-name' => 'Ada', 'email' => 'ada@example'],
            $array,
        );

        $hydrated = new Hydrator()->hydrate(Contact::class, ['display-name' => 'Grace', 'email' => 'grace@example']);

        self::assertSame('Grace', $hydrated->displayName);
        self::assertInstanceOf(Email::class, $hydrated->email);
        self::assertSame('grace@example', $hydrated->email->value);
    }

    public function testDateTimeAndEnumRoundTrip(): void
    {
        $order = new Order(
            id: 7,
            petId: 42,
            shipDate: new DateTimeImmutable('2026-04-18T12:34:56+00:00'),
            status: Status::Placed,
        );

        $array = new Marshaller()->marshal($order);

        self::assertSame(7, $array['id']);
        self::assertSame(42, $array['pet_id']);
        self::assertSame('2026-04-18T12:34:56+00:00', $array['shipDate']);
        self::assertSame('placed', $array['status']);

        $hydrated = new Hydrator()->hydrate(Order::class, [
            'id' => 9,
            'pet_id' => 101,
            'shipDate' => '2026-05-01T10:20:30+02:00',
            'status' => 'approved',
        ]);

        self::assertSame(9, $hydrated->id);
        self::assertSame(101, $hydrated->petId);
        self::assertInstanceOf(DateTimeImmutable::class, $hydrated->shipDate);
        self::assertSame('2026-05-01T10:20:30+02:00', $hydrated->shipDate->format(DateTimeInterface::RFC3339));
        self::assertSame(Status::Approved, $hydrated->status);

        $delivered = new Hydrator()->hydrate(Order::class, ['status' => 'delivered']);
        self::assertSame(Status::Delivered, $delivered->status);
    }

    public function testListOfModelsRecurses(): void
    {
        $pet = new Pet(id: 1, name: 'Rex', tags: [new Tag(1, 'friendly'), new Tag(2, 'playful')]);
        $array = new Marshaller()->marshal($pet);

        self::assertSame(
            [['id' => 1, 'name' => 'friendly'], ['id' => 2, 'name' => 'playful']],
            $array['tags'],
        );

        $hydrated = new Hydrator()->hydrate(Pet::class, [
            'id' => 1,
            'name' => 'Rex',
            'photoUrls' => ['https://example/a.jpg', 'https://example/b.jpg'],
            'tags' => [['id' => 1, 'name' => 'friendly'], ['id' => 2, 'name' => 'playful']],
        ]);

        self::assertSame(1, $hydrated->id);
        self::assertSame('Rex', $hydrated->name);
        self::assertSame(['https://example/a.jpg', 'https://example/b.jpg'], $hydrated->photoUrls);
        self::assertNotNull($hydrated->tags);
        self::assertCount(2, $hydrated->tags);
        self::assertInstanceOf(Tag::class, $hydrated->tags[0]);
        self::assertSame(1, $hydrated->tags[0]->id);
        self::assertSame('playful', $hydrated->tags[1]->name);
    }

    public function testDiscriminatedUnionPicksTheCorrectBranch(): void
    {
        $hydrated = new Hydrator()->hydrate(Animal::class, [
            'creature' => ['petType' => 'Cat', 'bark' => 'arf', 'meow' => 'purr'],
        ]);

        self::assertInstanceOf(Cat::class, $hydrated->creature);
        // `petType` is the discriminator's wire field, and it maps onto the
        // branch's own property like any other — not consumed only for
        // branch selection.
        self::assertSame('Cat', $hydrated->creature->petType);
        self::assertSame('purr', $hydrated->creature->meow);

        $hydratedDog = new Hydrator()->hydrate(Animal::class, [
            'creature' => ['petType' => 'Dog', 'bark' => 'woof'],
        ]);
        self::assertInstanceOf(Dog::class, $hydratedDog->creature);
        self::assertSame('Dog', $hydratedDog->creature->petType);
        self::assertSame('woof', $hydratedDog->creature->bark);
    }

    public function testMissingWireKeyOmitsArgument(): void
    {
        $hydrated = new Hydrator()->hydrate(Order::class, ['id' => 5]);

        self::assertSame(5, $hydrated->id);
        self::assertNull($hydrated->petId);
        self::assertNull($hydrated->shipDate);
    }

    public function testScalarBindingValueObjectRoundTrip(): void
    {
        $contact = new Contact(displayName: 'Ada', email: Email::fromScalar('ada@example'));
        $encoded = (string) json_encode(new Marshaller()->marshal($contact));

        self::assertStringContainsString('"email":"ada@example"', $encoded);
        self::assertStringNotContainsString('"value"', $encoded);
    }
}
