#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a binary response decision claims a stream the generator still refuses",
  tags: ("generator", "truth"),
  priority: 4,
  difficulty: 2,
  status: proposed(2026, 8, 4),
)

== Summary

The decision artifact a-binary-body-is-a-psr-7-stream says StreamInterface carries a binary request body and a binary response body alike. Only the request side landed. ResponseAnalyzer still refuses a 2xx whose schema declares format binary, with its own comment saying the refusal stands until the return contract can name a stream. So the decision states as settled a behaviour the code does not have, and a reader trusting it would expect a stream where the run aborts.

== Acceptance criteria

- The decision artifact says what is true on the tree: the request side carries a stream, the response side is still refused, and what would have to change for the response side to follow.
- Whichever way it is reconciled, the artifact and ResponseAnalyzer agree, checked by reading both.
- If the response side is meant to stay refused for now, the artifact names the task or condition that would lift it.

== Non-goals

- Implementing binary response bodies. This is about the artifact telling the truth, not about widening what the generator accepts.

== Files

- truth/decisions/a-binary-body-is-a-psr-7-stream.decision-260803.typ
- src/Generator/Emit/ResponseAnalyzer.php
