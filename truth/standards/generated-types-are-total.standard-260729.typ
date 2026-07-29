#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/guidance.context.typ": *
#import "../domain/generation.context.typ": *

#show: standard.with(
  title: "Generated types are complete as emitted",
  status: accepted(2026, 7, 29),
  contexts: (generation-context,),
  rule: [
    #A(GeneratedFile) is whole. It carries no protected region, no marked
    insertion point, no abstract member left for a consumer to fill, and no
    inheritance hook whose purpose is to let hand-written code alter emitted
    behaviour. Whatever #a(Model) or #a(Client) does is derivable from
    #the(Schema) and #the(Profile) alone.

    A consumer extends the output by composing with it from outside — writing
    a type that satisfies the same emitted contract and delegates — not by
    reaching into it. That restriction is what makes total regeneration safe:
    if nothing hand-written can live inside #a(GeneratedFile), then deleting
    the tree and rebuilding it loses nothing, and the consumer never has to
    remember which lines were theirs.
  ],
  structural: "enforced by absence: the emitters carry no protected-region, hook, or partial-file machinery for a consumer to reach",
)
