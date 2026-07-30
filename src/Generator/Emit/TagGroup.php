<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;

use function strlen;

/**
 * One sub-client's worth of operations: the tag as the document wrote it, the
 * PHP name derived from it, and the operations that belong on it.
 *
 * @internal
 */
final readonly class TagGroup
{
    /**
     * @param string                                                $rawTag     as the document wrote it; empty for the root group
     * @param string                                                $phpName    the sub-client class name, without namespace
     * @param list<array{0:string,1:string,2:Operation,3:PathItem}> $operations method, path, operation, path item
     */
    public function __construct(
        public string $rawTag,
        public string $phpName,
        public array $operations,
    ) {}

    public function interfaceName(): string
    {
        return $this->phpName . 'Interface';
    }

    /**
     * The accessor the root client exposes for this group — `customers()` for a
     * `CustomersClient`.
     */
    public function accessor(): string
    {
        $stem = str_ends_with($this->phpName, 'Client')
            ? substr($this->phpName, 0, -strlen('Client'))
            : $this->phpName;

        return $stem === '' ? 'client' : lcfirst($stem);
    }

    public function isRoot(): bool
    {
        return $this->rawTag === '';
    }
}
