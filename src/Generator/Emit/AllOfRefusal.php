<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use RuntimeException;

/**
 * Internal control-flow signal for {@see AllOfMerger} — thrown the moment a
 * merge step finds a construct it cannot express, carrying the human-readable
 * reason, and caught once at {@see AllOfMerger::merge()}'s single entry point
 * to become an {@see AllOfMerge::refused()} result.
 *
 * Never crosses that boundary: nothing outside this package catches it, and
 * nothing outside `AllOfMerger` throws it.
 *
 * @internal
 */
final class AllOfRefusal extends RuntimeException {}
