<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrgRepoCustomPropertyValues
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\CustomPropertyValue> $properties
     */
    public function __construct(
        public array $properties,
        public string $repository_full_name,
        public int $repository_id,
        public string $repository_name,
    ) {
    }
}
