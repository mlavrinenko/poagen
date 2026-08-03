#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "binary format advisory fires on a format that now drives behaviour",
  tags: ("generator", "dx"),
  priority: 2,
  difficulty: 2,
  status: done(
    2026,
    8,
    4,
  )[Landed as 1cd0590, merged and re-gated on the integrated HEAD. The premise was re-established against the current base rather than taken from the task: isBinary now drives a StreamInterface parameter, and the advisory was still calling the format unrecognised on petstore's uploadImage and GitHub's upload-release-asset. Recognition is derived by calling BodyMediaType itself, not by re-checking the literal string, so there is no second list to drift. Bindings.php was in the Files list and correctly left untouched — binary drives a whole body's shape, not a scalar binding, and that list predates five generator tasks.],
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
