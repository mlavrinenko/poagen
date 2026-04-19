<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiChunkingAlgorithm: string
{
    case ChunkingAlgorithmUnknown = 'CHUNKING_ALGORITHM_UNKNOWN';
    case ChunkingAlgorithmSectionBased = 'CHUNKING_ALGORITHM_SECTION_BASED';
    case ChunkingAlgorithmHierarchical = 'CHUNKING_ALGORITHM_HIERARCHICAL';
    case ChunkingAlgorithmSemantic = 'CHUNKING_ALGORITHM_SEMANTIC';
    case ChunkingAlgorithmFixedLength = 'CHUNKING_ALGORITHM_FIXED_LENGTH';
}
