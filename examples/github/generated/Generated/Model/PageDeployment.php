<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PageDeployment
{
    /**
     * @param mixed $id
     */
    public function __construct(
        public $id,
        public string $page_url,
        public string $status_url,
        public ?string $preview_url = null,
    ) {
    }
}
