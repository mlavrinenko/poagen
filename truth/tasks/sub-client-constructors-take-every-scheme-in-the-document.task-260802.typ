#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "sub client constructors take every scheme in the document",
  tags: ("generator", "security", "emitter"),
  priority: 5,
  difficulty: 6,
  status: done(
    2026,
    8,
    3,
  )[Landed as 4e9d286, merged 3dfd3aa and re-gated on the integrated HEAD. Scoping decided once in SecuritySchemeCatalog::constructorSchemesFor, built on the existing requirement resolution so the constructor and the request chain cannot disagree. property.onlyWritten 3 to 0; every committed tree but petstore byte-identical.],
)

== Summary

Unmasked, not introduced, by \`security-schemes-sharing-a-ctor-arg-collide\`.
\`ClientConstructor\` and \`SubClientEmitter\` wire every security scheme declared
anywhere in the document into every sub-client's constructor, uniformly,
regardless of whether that sub-client's own operations require it. A sub-client
whose operations all authenticate one way still takes a promoted property for
every other scheme in the document and never reads it.

This was invisible while DigitalOcean's two http bearer schemes collapsed onto
one \`bearerToken\` name, because the single shared property was read by
whichever sub-client did use it. Giving the two schemes distinct names made the
unused ones visible: generating the DigitalOcean shape now reports 50
\`property.onlyWritten\` findings from shipmonk's dead-code-detector, one per
sub-client that takes a credential it has no operation for.

The findings are correct. The emitted code really does carry a constructor
parameter nothing reads, on a caller-facing surface, and a consumer must supply
a credential for an audience that sub-client never talks to. That is the
opposite of what \`caller-surface-is-injectable\` is for: the injection point
should describe what the thing actually needs.

Scoping a sub-client's constructor to the schemes its own operations require is
a real design change, not a lint fix. It reaches the tagged sub-client split,
the root client's own construction of its children, and whatever a sub-client
does when an operation-level \`security\` requirement disagrees with the
document-level one. That is why it was left out of the task that surfaced it.

== Acceptance criteria

- A sub-client's constructor takes only the schemes its own operations require,
  resolving operation-level \`security\` against the document-level default the
  way the spec defines rather than by taking the union of both.
- Generating the DigitalOcean shape reports zero \`property.onlyWritten\`
  findings traceable to security schemes, proven by generating and running the
  generated tier's PHPStan config, not by reasoning.
- A document with exactly one scheme emits its sub-client constructors exactly
  as today, byte for byte.
- A fixture covers a document where two sub-clients require different schemes,
  so the guarantee does not depend on the DigitalOcean document.
- The root client still constructs every sub-client it owns, and a consumer
  building one directly gets a signature that names only what it needs.

== Non-goals

- Re-opening \`distinct-ctor-args-for-colliding-schemes\`. Distinct names are
  what made this visible and they stand.
- oauth2 or openIdConnect, which \`report-unsupported-security-schemes\` owns and
  which is blocked on an owner ruling.
- Changing how a scheme's credential reaches the wire once the sub-client has
  it. This is about which sub-clients are asked for it.

== Files

- \`src/Generator/Emit/ClientConstructor.php\`
- \`src/Generator/Emit/SubClientEmitter.php\`
- \`src/Generator/Emit/SecuritySchemeCatalog.php\`
- \`tests/fixtures/\`
