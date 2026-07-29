<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetListTagsResponseGroupsListItem
{
    public function __construct(
        public ?int $group_id = null,
        public ?string $group_name = null,
    ) {
    }
}
