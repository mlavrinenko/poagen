<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum OrgsListWebhookDeliveriesStatus: string
{
    case Success = 'success';
    case Failure = 'failure';
}
