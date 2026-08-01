#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: standard.with(
  title: "Analysis runs at maximum strictness with nothing suppressed",
  status: accepted(2026, 7, 29),
  contexts: (generation-context,),
  rule: [
    Static analysis runs at its strictest available setting over both
    #the(Generator) and the tree it emits, and the two tiers are held to
    different absolutes because they are read by different people.

    On the emitted tree the rule admits nothing: no baseline, no suppression
    annotation, no ignored-error pattern, no excluded path. #A(GeneratedFile)
    is analysed exactly as a consumer's own code would be, because that is the
    tier that matters. Consumers run their own analysis at whatever level they
    have chosen, and output that needs a baseline to pass has exported
    #the(Generator)'s unfinished work into their repository. A finding there is
    fixed at its source, never annotated away in what gets emitted.

    On #the(Generator)'s own analysis the default is the same as on the
    emitted tree: no baseline, nothing suppressed. An `ignoreErrors` entry is
    opt-in, never opt-out — relaxing the gate to fit existing code is
    backwards. Adding one requires fixing the underlying finding first, and
    only if that genuinely cannot happen yet, recording it as debt: the exact
    identifier and file, an inline comment naming what is not implemented or
    not visible to the tool and why, and what would remove the entry. The
    debt list is enumerated in the `structural:` slot below; its count must
    not grow without that comment sitting next to the new entry, and the
    expected direction is down, not flat. An exemption that stops naming a
    specific, checkable reason and starts working as a blanket policy —
    "tests are exempt", "generated fixtures are exempt" — is forbidden, and so
    is one that quietly keeps existing after the code it justified changes
    underneath it: an entry is re-checked whenever the file it names changes.
  ],
  structural: "enforced by phpstan-generated.neon, which analyses the emitted
    tree at max level with no baseline, no excludePaths and no ignoreErrors;
    and by phpstan.neon.dist, which analyses the generator at max level with
    five ignoreErrors entries recorded as debt, each verified to still be
    load-bearing (removing it alone reproduces a real finding): two, scoped
    by message to the exact property rather than the whole file, cover every
    generated *Steps.php class's constructor-injected \$test, which only
    speconaut-php-phpunit's stub bodies read (StepStub::stubBody() emits
    \$this->test->fail(...) for a spec step with no hand-written body yet) —
    structurally present whether or not any step in that class is currently
    unimplemented; three cover AdditionalProperties.php, Deprecated.php and
    Schema.php, whose properties attribute-and-phpdoc-driven-serialization
    commits the runtime to but which neither the generator emits nor the
    runtime reads yet, unlike the three wired members of the same attribute
    vocabulary (WireName, Format, Discriminator)",
)
