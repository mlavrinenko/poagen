#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "Generated code is never edited",
  status: active(2026, 7, 29),
  acid-test: [
    Delete the entire generated tree, regenerate from the same schema and
    the same user code, and the result is byte-identical to what was
    deleted. The project still builds and its tests still pass. No
    reviewer ever has to ask whether a generated file was touched by hand.
  ],
)

The generated tree is a build output that happens to be committed. It
carries no hand-written line, no protected region, no merge marker, no
"edit below this point". Regeneration is a full replace, including the
removal of files whose source construct disappeared from the schema.

This is what makes an upstream schema update a routine act rather than a
migration. When the vendor publishes a new revision, the reader compares
two generated trees and reviews a diff that means something, because
nothing in it encodes a local decision.

The corollary is a hard constraint on the generator: every customisation
a user could reasonably want must be expressible somewhere other than the
generated output. A feature that can only be delivered by editing the
result is not a feature; it is a defect in the guidance surface.
