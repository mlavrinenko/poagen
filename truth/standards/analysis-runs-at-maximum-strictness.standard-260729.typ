#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: standard.with(
  title: "Analysis runs at maximum strictness with nothing suppressed",
  status: accepted(2026, 7, 29),
  contexts: (generation-context,),
  rule: [
    Static analysis runs at its strictest available setting over both
    #the(Generator) and the tree it emits, with no baseline file, no
    suppression annotation, no ignored-error pattern, and no excluded path.
    #A(GeneratedFile) is analysed exactly as a consumer's own code would be.

    The output tier is the one that matters. Consumers run their own analysis
    at whatever level they have chosen, and a generated tree that needs a
    baseline to pass has exported #the(Generator)'s unfinished work into their
    repository. So the standard is not that we analyse the output; it is that
    the output needs no help to pass. A finding is fixed at its source in
    #the(Generator), never annotated away in what it emits.
  ],
  structural: "enforced by phpstan.neon and phpstan-generated.neon running at max level with no baseline and no ignored-error patterns, both wired into the check recipe",
)
