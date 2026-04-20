<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class IssueFieldValue
{
    /**
     * @param ?mixed $value
     */
    public function __construct(
        public string $data_type,
        public int $issue_field_id,
        public string $node_id,
        public $value = null,
        public ?IssueFieldValueSingle_select_option $single_select_option = null,
    ) {
    }
}
