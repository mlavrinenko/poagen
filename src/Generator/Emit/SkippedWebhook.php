<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Poagen\Generator\Generator\GenerationPlan;

/**
 * A top-level `webhooks:` entry the generator omitted because
 * `Profile::$skip` named it via {@see WebhookSkipKey}. Every webhook is
 * refused unconditionally — see {@see UnsupportedKeywordScanner} — so unlike
 * {@see SkippedOperation} and {@see SkippedComponent} there is no
 * unrepresentable-construct diagnostic to carry; `$reason` is the consumer's
 * own written justification, the same obligation every other `$skip` entry
 * carries.
 *
 * Drained from planning into {@see GenerationPlan}.
 */
final readonly class SkippedWebhook
{
    public function __construct(
        public string $name,
        public string $reason,
    ) {}
}
