<?php

/**
 * Profile for the abort-on-unrepresentable-constructs fixture.
 *
 * Accepts both of that document's deliberate problems by name — the
 * `multipart/form-data` body on `createWidget` and the undiscriminated
 * `Gadget.owner` union — so a scenario about *skipping* can generate
 * successfully. A scenario about *refusing* rebuilds this with `skip: []`.
 *
 * `createWidget` replaced petstore's `uploadFile` as the operation-generator
 * spec's worked example of an unrepresentable request body in
 * represent-non-json-request-and-response-bodies: octet-stream stopped being
 * unrepresentable, and multipart — explicitly out of that task's scope — is
 * the construct that still is.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: no golden tree of its own, so it writes to scratch
// like every other fixture profile here.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/unrepresentable-3.0.yaml',
    output: poagen_fixture_scratch_output('unrepresentable'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\Unrepresentable',
    skip: [
        'createWidget' => 'multipart/form-data request body — every part carries its own content type',
        'Gadget' => 'oneOf without a discriminator, and no field is common to every branch',
    ],
);
