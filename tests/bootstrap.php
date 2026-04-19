<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// Upstream `cebe/php-openapi` still declares implicit-nullable parameters
// (e.g. `function resolveReferences(ReferenceContext $context = null)`) which
// PHP 8.4 deprecates. Until we replace the parser — see the pre-release
// review, P2 #15 — suppress those notices so PHPUnit's stderr isn't
// dominated by upstream noise. The notices are still surfaced to downstream
// users of `cebe/php-openapi`; we only quiet them for our own test runs.
error_reporting(error_reporting() & ~\E_DEPRECATED & ~\E_USER_DEPRECATED);
