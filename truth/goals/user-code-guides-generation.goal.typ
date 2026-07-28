#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "User code guides generation and never ships to consumers",
  status: active(2026, 7, 29),
  acid-test: [
    Every knob that changes what is emitted lives in the user's own
    declarative code, read by the generator at generation time. Deleting
    that code and regenerating produces a client that still works and
    still compiles — only less pleasant. None of it appears in the
    published surface that a consumer of the generated client depends on.
  ],
)

There are two audiences and they must not be confused. The user of the
generator writes guidance: which names to prefer, which wire formats map
to which of their own types, which branch of a union a field selects.
The consumer of the generated client sees none of that; they see a typed
client and typed models.

Guidance is data, not template. It is read and interpreted, never
executed into the output as text. That distinction is what keeps
regeneration total and the output reviewable — a template language would
smuggle user logic into the generated tree and destroy the previous goal.

The default path takes no guidance at all. A schema alone produces a
correct client. Guidance only raises quality, and its absence is never an
error.
