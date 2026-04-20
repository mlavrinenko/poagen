<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookLabelEditedChanges
{
    public function __construct(
        public ?WebhookLabelEditedChangesColor $color = null,
        public ?WebhookLabelEditedChangesDescription $description = null,
        public ?WebhookLabelEditedChangesName $name = null,
    ) {
    }
}
