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

    On #the(Generator)'s own analysis an exemption is permitted only where the
    tool is provably blind — a property read solely through reflection, a
    pattern a third-party rule set cannot see through — and each one carries an
    inline comment naming the blind spot. An exemption for a real finding is
    forbidden. The distinction is not a convenience: the moment an exemption
    stops naming a tool limitation and starts naming a deadline, this rule has
    become decoration.
  ],
  structural: "enforced by phpstan-generated.neon, which analyses the emitted tree at max level with no baseline, no excludePaths and no ignoreErrors; and by phpstan.neon.dist, which analyses the generator at max level with seven documented tool-blind-spot exemptions and no baseline",
)
