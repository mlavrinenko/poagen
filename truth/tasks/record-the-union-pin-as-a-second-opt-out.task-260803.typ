#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "record the union pin as a second opt out",
  tags: ("truth", "decision"),
  priority: 6,
  difficulty: 3,
  status: accepted(
    2026,
    8,
    3,
  )[Owed since declare-an-undiscriminated-union-as-raw-data landed on 2026-08-03 and shipped a second opt-out surface without amending the decision that says there is only one. Filed as a task because work with no task behind it is what the trailer rule exists to prevent.],
)

== Summary

`skip-is-the-only-opt-out` says it in its title and again in its body: "There is
exactly one opt-out surface: `Profile::$skip` ... No second surface exists for
'emit it anyway, knowing it degrades.'"

`declare-an-undiscriminated-union-as-raw-data` shipped one on 2026-08-03.
`Profile::$unionPins` names a property whose union no rule can decide and picks
a branch for it. Two entries exist today, both in
`examples/digitalocean/paogen.php`: `database_config.config` pinned to
`postgres_advanced_config`, and `logsink_update.config` pinned to
`opensearch_logsink`.

It is an opt-out by that decision's own test, and the argument is the
implementing agent's: a pin is the one guidance key whose *absence* changes the
exit status. Drop `$unionPins` and the run fails. Drop `$unionTags`,
`$propertyRenames` or `$inlineModels` and the run still generates, with worse
names. That is the line between guidance and an opt-out, and `$unionPins` is on
the far side of it.

It is also the more dangerous of the two surfaces, which is why leaving the
decision unamended is worse than a documentation gap. A skip removes the thing,
so there is nothing left to be wrong. A pin leaves something that *is* wrong
and looks right: `database_config.config`'s seven engine branches accept each
other's payloads — that is why no rule could decide them — so a MySQL payload
read through the pinned property hydrates into `PostgresAdvancedConfig` with
every foreign field in the extras bag, at exit 0. `skip-is-the-only-opt-out`
forbids exactly this shape of thing under a different name: "a method
compiling clean at max strictness and failing only when called". The pin is the
first case where paogen ships that knowingly, and the decision should say so
rather than be silently contradicted by the code.

The mitigations are already built and should be recorded as the price of the
amendment, not re-litigated: every pin carries a written reason, every pin is
stale-checked exactly as a `$skip` entry is, and every pin is reported on every
run rather than only the run that added it.

== Acceptance criteria

- A decision artifact amends `skip-is-the-only-opt-out` — narrowly, naming
  `Profile::$unionPins` as the second and, as of this amendment, final opt-out
  surface. It supersedes or amends the existing decision by that decision's own
  convention rather than sitting beside it as a contradiction.
- It states the test that makes a pin an opt-out and `$unionTags` not one: a
  guidance key whose absence changes the exit status.
- It records that a pin can be wrong-looking-right where a skip cannot, names
  `database_config.config` as the live instance, and names the three
  mitigations that make it acceptable — a written reason, staleness checking,
  and reporting on every run.
- It says what would admit a third opt-out surface, so the next one is a
  decision rather than a precedent.
- `skip-is-the-only-opt-out`'s own text is corrected where it now reads false.
  Its title is the load-bearing claim and a reader who only reads titles must
  not come away wrong.
- `speconaut check truth/` is green and `just check` passes.

== Non-goals

- Changing what `$unionPins` does, or adding a third opt-out. This records what
  shipped.
- Re-opening `declare-an-undiscriminated-union-as-raw-data`'s three resolution
  layers or their order.
- Removing either live pin. Both are correct for the client that profile
  describes and each carries its reason.
- `webhooks-refuse-with-no-opt-out`, which is the opposite problem — a
  construct with no opt-out at all — and is decided separately.

== Files

- `truth/decisions/` (a new decision artifact, plus an edit to
  `skip-is-the-only-opt-out` itself)
