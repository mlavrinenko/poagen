<?php

/**
 * Profile for the synthetic `format-binding` schema. Pins what a
 * `Profile::$formats` entry emits: one line binds `format: uuid` to a
 * binding this repository ships, and every site the document spends that
 * format on picks it up — a required property, an optional one, a list of
 * them, a second component, and a path parameter
 * (`built-in-uuid-and-binary-format-bindings`,
 * `codec-bindings-for-foreign-value-types`).
 *
 * `codec-bindings-for-foreign-value-types` re-expressed the bound uuid
 * property as a codec: `RamseyUuidCodec` converts on `UuidInterface`'s
 * behalf rather than wrapping it, so the emitted property is
 * `UuidInterface` itself — no `->value` hop.
 *
 * The golden tree exists for `lint-phpstan-generated`. A property typed as
 * `ramsey/uuid`'s own `UuidInterface`, converted by a registered codec, is a
 * shape only the consumer-view analysis can vouch for: the sandbox tests in
 * `tests/Integration/FormatBindingTest.php` assert what the emitted source
 * says and cannot answer whether it type-checks at max level in a
 * consumer's own tree.
 *
 * `avatar` (`format: binary`) and `contact` (`format: email`) are unbound on
 * purpose. `binary` on a plain property stays a bare string — the decision
 * is recorded in
 * `truth/decisions/binary-on-a-property-stays-advisory.decision-260809.typ`
 * — and `email` is here so the golden shows an unbound format sitting next
 * to a bound one rather than a tree where everything is bound.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;
use Poagen\Runtime\Format\RamseyUuidCodec;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture format-binding`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/format-binding-3.0.yaml',
    output: poagen_fixture_scratch_output('format-binding'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\FormatBinding',
    formats: ['uuid' => RamseyUuidCodec::class],
);
