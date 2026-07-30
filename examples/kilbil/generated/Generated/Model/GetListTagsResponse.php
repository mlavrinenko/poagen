<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetListTagsResponse
{
    /**
     * @param ?list<GetListTagsResponseGroupsListItem> $groups_list
     * @param ?list<GetListTagsResponseTagsListItem> $tags_list
     */
    public function __construct(
        public int $result_code,
        public ?int $groupId = null,
        public ?array $groups_list = null,
        public ?array $tags_list = null,
    ) {
    }
}
