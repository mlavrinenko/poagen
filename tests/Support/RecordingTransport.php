<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Support;

use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;

/**
 * A transport that speaks no HTTP at all: it records what the generated
 * client asked for and answers from a value the test supplies.
 *
 * The whole substitution claim in one class — a consumer who wants their own
 * runtime implements one method, constructs the generated client with it, and
 * edits no generated file.
 */
final class RecordingTransport implements TransportInterface
{
    /** @var list<array{endpoint: Endpoint, expected: ResponseType<mixed>}> */
    public array $sent = [];

    /**
     * @param list<mixed> $answers returned in order, one per call
     */
    public function __construct(private array $answers = []) {}

    /**
     * @template T
     *
     * @param ResponseType<T> $expected
     *
     * @return T
     */
    public function send(Endpoint $endpoint, ResponseType $expected): mixed
    {
        $this->sent[] = ['endpoint' => $endpoint, 'expected' => $expected];

        /** @var T */
        return array_shift($this->answers);
    }

    public function lastEndpoint(): ?Endpoint
    {
        $last = $this->sent[count($this->sent) - 1] ?? null;

        return $last === null ? null : $last['endpoint'];
    }
}
