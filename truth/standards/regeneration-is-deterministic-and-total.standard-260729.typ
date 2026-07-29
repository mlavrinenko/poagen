#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/guidance.context.typ": *
#import "../domain/generation.context.typ": *

#show: standard.with(
  title: "Identical inputs produce identical bytes, and the output holds nothing stale",
  status: accepted(2026, 7, 29),
  contexts: (generation-context,),
  rule: [
    Running #the(Generator) twice over #the([same], Schema) and
    #the([same], Profile) produces byte-identical output. Emission order derives from
    #the(Schema), never from directory iteration, hash iteration, or anything
    else that varies between machines or between runs.

    Regeneration is also total. When #an(Operation) or a payload shape
    disappears upstream, #the([corresponding], GeneratedFile) disappears in the
    same run rather than lingering. A stale emitted file compiles, passes
    analysis, and describes an endpoint that no longer exists — the most
    expensive kind of wrong, because nothing surfaces it.

    Both halves serve the same reader. A regeneration diff has to mean something:
    if it churns, nobody reads it, and a review that should have been about an
    API change becomes a review about the generator.
  ],
  structural: "enforced by the byte-stability integration test and the stale-file pruning pass over the output directory",
)
