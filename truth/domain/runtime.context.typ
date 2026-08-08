#import "@local/speconaut:0.1.0": entity, bounded-context

#let runtime-context = bounded-context("runtime", layer: "technical")

// The hydration machinery the emitted Client carries at request time: wire
// payload in, typed Model out (`Hydrator`); typed Model in, wire payload out
// (`Marshaller`). model-generator.feature talks about both constantly, and
// about the doc-comment recovery path behind them, and until now nothing
// modelled either — steps borrowed `Client` instead, which does not own a
// PHP process's opcache setting or the `ReflectionMethod::getDocComment()`
// call Hydrator makes.
//
// A fifth bounded context rather than folding into `generation-context`:
// `generation-context`'s five entities finish their work once a run ends —
// nothing there executes again until the next `poagen generate`. Hydrator
// and Marshaller do the opposite: they ship inside the emitted Client and
// run on every request a consumer's own process makes, long after
// generation is over. That is a different lifecycle from anything
// `generation-context` owns — exactly the test `bounded-contexts.md` sets
// for when a new split is warranted.

// Propertyless on purpose: Hydrator is what it does — turn a wire payload
// into a typed Model, recovering a stripped doc comment along the way when
// it must — not what it holds. Nothing a scenario asserts about it is a
// stored field.
#let Hydrator = entity("Hydrator", props: ())

// Same shape as Hydrator, same reason: marshalling is the action (typed
// Model to wire payload), not a value.
#let Marshaller = entity("Marshaller", props: ())
