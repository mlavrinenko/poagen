<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetListTagsResponseTagsListItem
{
    public function __construct(
        public ?int $group_id = null,
        public ?int $tag_id = null,
        public ?string $tag_name = null,
    ) {
    }
}
