#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Clear the expected-failure markers on the DigitalOcean and GitHub examples",
  tags: ("generator",),
  priority: 4,
  difficulty: 4,
  status: wip(2026, 8, 2)[milestone: trust the instruments, then use them],
)

== Summary

Both large example trees carry an expected-failure marker, left when property-level unions without a discriminator became a generation-time abort. The abort is correct and deliberate; the markers are the unpaid half of that change. While they stand, the two schemas that exercise the generator hardest are not actually exercised, and the release criteria that depend on them cannot be met.

== Acceptance criteria

- Both examples generate without a marker file.
- The discriminators they need are supplied from their profiles, which is the documented mechanism.
- Both trees pass the strict analysis configured for generated output.
- The check-examples recipe reports no stale markers.

== Non-goals

- Weakening the undiscriminated-union abort.
- Adding discriminator inference.

== Files

- \`examples/digitalocean/\`
- \`examples/github/\`
