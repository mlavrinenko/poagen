<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListWebhookDeliveriesStatus: string
{
    case Success = 'success';
    case Failure = 'failure';
}
