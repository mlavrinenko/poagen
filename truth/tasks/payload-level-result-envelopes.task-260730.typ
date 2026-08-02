#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide how a client surfaces a failure the vendor reports inside a 200 body",
  tags: ("generator", "errors", "decision"),
  priority: 5,
  difficulty: 7,
  status: blocked(
    2026,
    8,
    2,
  )[Needs your ruling on scope: does the profile grow a way to declare a payload-level result envelope, or does this stay the consumer's business the way examples/kilbil already handles it by hand? The first adds a permanent public surface to the profile; the second leaves every kilbil caller one unchecked field away from a silent success. That trade is product direction and the repo cannot settle it. Pick one and the decision artifact plus any code follows.],
)

== Summary

The kilbil vendor signals failure in a \`result\_code\` property carried by a 200 response, not in the HTTP status. \`examples/kilbil/src/PhoneConfirmation.php:66\` encodes that by hand, one endpoint at a time:

\`\`\`php
return \$response->result\_code === '0';
\`\`\`

Every one of the 36 operations returns a \`result\_code\`, and \`ApiException\` only ever fires on the vendor's 403. So a caller who checks nothing gets a response object that looks successful and is not — the exact silent failure \`fail-loud-never-silent\` exists to prevent, arriving through a door the goal does not currently watch.

The envelope is not a kilbil quirk; payload-level status codes are common in older APIs. But OpenAPI does not mark which property is the status, and the meaning of its values is vendor knowledge paogen cannot derive. So the open question is whether this stays entirely the consumer's business — as \`PhoneConfirmation\` shows it can be — or whether the profile grows a way to declare the envelope and the generator does something with it.

This needs a decision artifact before code.

== Acceptance criteria

- A decision artifact under \`truth/decisions/\` records the choice, its options, and its consequences, citing at least one goal and one standard.
- The options considered include at minimum: leave it to consumer wrappers as today; declare the envelope in the profile and have the generator throw; declare it and have the generator expose a typed predicate without throwing.
- If the answer is "consumer's business", \`examples/kilbil/README.md\` says so where a reader meets \`result\_code\`, and the decision explains why a generator answer would be worse.
- If the answer changes the emitter, \`guidance-is-data-not-code\` is honoured — the envelope is declared as data, never as a callback.

== Non-goals

- \`typed-error-responses\`, which asks whether declared error schemas become typed exception classes. That is about responses OpenAPI marks as errors; this is about responses it marks as successes.
- Retry, backoff, or any transport concern.

== Files

- \`truth/decisions/\`
- \`truth/tasks/\`
