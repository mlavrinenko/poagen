#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "binary format advisory fires on a format that now drives behaviour",
  tags: ("generator", "dx"),
  priority: 2,
  difficulty: 2,
  status: proposed(2026, 8, 3),
)

== Summary

Generating petstore prints: format 'binary' is not one paogen recognises — 1 use(s) ... The property keeps its base type.

That was true until represent-non-json-request-and-response-bodies. It is not now: format binary is exactly what makes a request or response body binary, under whatever media type the vendor named, and it drives the StreamInterface parameter the octet-stream upload takes. The advisory tells a consumer their declaration was ignored while the generator is in fact acting on it.

UnrecognisedFormatReport is advisory, goes to stderr and never moves the exit status, so nothing is broken. It is a message that contradicts the behaviour beside it, which is the failure mode fail-loud-never-silent exists to prevent, pointed the other way: not silence where there should be noise, but noise saying the opposite of what happened.

== Acceptance criteria

- Generating petstore prints no unrecognised-format notice for binary.
- A format the generator genuinely does not act on still gets the notice, unchanged. Prove both in one run rather than by removing the check.
- The set of formats the advisory considers recognised is derived from what the generator actually consumes, not from a second list that can drift from it.

== Non-goals

- The advisory's channel or exit-status behaviour, which are correct.
- Adding support for any other format.

== Files

- src/Generator/Emit/FormatAdvisor.php
- src/Generator/Bindings.php
- tests/
