#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/generation.context.typ": *
#import "../domain/cli.context.typ": *
#import "../domain/guidance.context.typ": *

#show: standard.with(
  title: "A run that completes emitted everything it was asked for",
  status: accepted(2026, 7, 29),
  contexts: (generation-context, cli-context),
  requires-cases: (
    "unsupported-content-type-aborts-run",
    "explicit-skip-omits-without-stub",
  ),
  rule: [
    When #the(PaogenCli) exits successfully, every #an(Operation) and every
    payload shape in #the(Schema) is present in the emitted tree. There is no
    third outcome between success and failure — no partial client, no method
    that compiles and throws when called, no omission reported on the error
    stream while the exit status says the run worked.

    #The(Generator) may refuse. It may not shrink. A construct it cannot
    represent stops the run and is named, along with where it appeared and what
    would make it acceptable.

    The one permitted exception is an omission the consumer asked for by name in
    #a(Profile), recorded with a reason and scoped to specific operations or
    components rather than to a category. Even that must stay honest: when a
    named omission would now generate cleanly, the run fails until the consumer
    removes it. An opt-out that outlives its cause is the silent failure it was
    meant to replace.
  ],
)
