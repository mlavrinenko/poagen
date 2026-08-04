<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime;

use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\StatusResponseMap;
use PHPUnit\Framework\TestCase;

/**
 * typed-error-responses: OpenAPI's own status precedence, proved directly
 * against the runtime matcher rather than only through a generated client.
 *
 * No real document this project has vendored (petstore, github, digitalocean)
 * declares a range key — every one of them sticks to exact statuses and
 * `default`. This is the synthetic fixture the settled implementation plan
 * says the precedence rule needs, or it ships unproven.
 */
final class StatusResponseMapTest extends TestCase
{
    public function testAnExactStatusWinsOverARangeAndOverDefault(): void
    {
        $exact = ResponseType::string();
        $map = new StatusResponseMap(
            exact: [['404', $exact]],
            ranges: [['4XX', ResponseType::int()]],
            default: ResponseType::bool(),
        );

        self::assertSame($exact, $map->match(404));
    }

    public function testARangeWinsOverDefaultWhenNoExactStatusMatches(): void
    {
        $range = ResponseType::int();
        $map = new StatusResponseMap(
            exact: [['404', ResponseType::string()]],
            ranges: [['4XX', $range]],
            default: ResponseType::bool(),
        );

        self::assertSame($range, $map->match(429));
    }

    public function testDefaultAppliesOnlyWhenNeitherAnExactNorARangeMatches(): void
    {
        $default = ResponseType::bool();
        $map = new StatusResponseMap(
            exact: [['404', ResponseType::string()]],
            ranges: [['4XX', ResponseType::int()]],
            default: $default,
        );

        self::assertSame($default, $map->match(503));
    }

    public function testTheRangeKeyIsDerivedFromTheStatussLeadingDigit(): void
    {
        $client4xx = ResponseType::int();
        $server5xx = ResponseType::float();
        $map = new StatusResponseMap(ranges: [
            ['4XX', $client4xx],
            ['5XX', $server5xx],
        ]);

        self::assertSame($client4xx, $map->match(418));
        self::assertSame($server5xx, $map->match(503));
    }

    public function testAStatusMatchingNoExactNoRangeAndNoDefaultIsNull(): void
    {
        $map = new StatusResponseMap(exact: [['200', ResponseType::string()]]);

        self::assertNull($map->match(500));
    }

    public function testAnEmptyMapMatchesNothing(): void
    {
        self::assertNull(new StatusResponseMap()->match(200));
    }
}
