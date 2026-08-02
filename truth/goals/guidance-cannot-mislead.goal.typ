#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "Guidance is checked against the document, so no configuration can quietly be wrong",
  status: active(2026, 8, 2),
  acid-test: [
    Take a working profile and break each entry in turn: name something the
    document does not contain, keep an entry whose cause the generator has
    since learned to handle, merge two shapes that are not the same shape,
    pin a branch that is not in the union, bind a format nothing declares.
    Every one of them fails the run and names the entry that is wrong. None
    of them is ignored, and none of them produces a client that generates
    successfully and behaves differently than the consumer intended.
  ],
)

Guidance exists because a real document is sometimes ambiguous and the
consumer knows something the schema does not say. That is also what makes
it dangerous: an entry the generator merely obeys is an assertion nobody
checked, and the consumer who wrote it is the last person who will ever
read it.

So every entry is a claim about the document, and every claim is verified
against the document before it is used. An entry that names something
absent is an error. An entry whose reason has expired is an error — the
skip list already works this way, and the rule is general rather than
special to skipping. An entry asserting that two shapes are the same is
checked to be true, and refused with the difference named when it is not.

The failure this prevents is not a crash. It is the client that generates
cleanly, passes every check, and is wrong in a way that only shows up in
the consumer's production data — two payload shapes merged into one class
that silently drops a field, or a union branch pinned to the wrong type.
Configuration is the one part of the pipeline where the generator's own
checks are the only thing standing between a typo and that outcome.

A consumer may still choose something the generator would not have chosen.
That is the point of guidance and it stays. What they may not do is choose
something the document contradicts, and be told nothing.
