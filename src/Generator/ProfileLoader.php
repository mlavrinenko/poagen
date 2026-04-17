<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Exception\InvalidProfileException;

final class ProfileLoader
{
    public function load(string $path): Profile
    {
        if (!is_file($path)) {
            throw new InvalidProfileException("Profile file not found: {$path}");
        }

        $value = (static fn(): mixed => require $path)();

        if (!$value instanceof Profile) {
            $type = get_debug_type($value);

            throw new InvalidProfileException(
                "Profile file {$path} must return a " . Profile::class . " instance; got {$type}.",
            );
        }

        if (!is_file($value->schema)) {
            throw new InvalidProfileException(
                "Profile references missing schema: {$value->schema}",
            );
        }

        return $value;
    }
}
