<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppComponentInstanceBase
{
    /**
     * @param ?mixed $instance_size_slug
     */
    public function __construct(
        public ?AppComponentInstanceBaseAutoscaling $autoscaling = null,
        public ?int $instance_count = null,
        public $instance_size_slug = null,
    ) {
    }
}
