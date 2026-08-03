#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *

#show: decision.with(
  title: "Profile::$unionPins is a second, bounded opt-out from default-deny",
  status: accepted(2026, 8, 3),
  contexts: (generation-context,),
  goals: (
    link("../goals/fail-loud-never-silent.goal.typ"),
    link("../goals/guidance-cannot-mislead.goal.typ"),
  ),
  standards: (link("../standards/silence-means-success.standard-260729.typ"),),
  relates-to: (link("skip-is-the-only-opt-out.decision-260801.typ"),),
)

== Context

`skip-is-the-only-opt-out` said, in its title and again in its body: "There
is exactly one opt-out surface: `Profile::$skip` ... No second surface
exists for 'emit it anyway, knowing it degrades.'" `declare-an-
undiscriminated-union-as-raw-data` shipped one on 2026-08-03.
`Profile::$unionPins` names a property whose union no rule can decide and
picks a branch for it, keyed the same way `$skip` is, carrying the same
written reason a `$skip` entry carries. Two entries exist today, both in
`examples/digitalocean/paogen.php`:

- `database_config.config` pinned to `postgres_advanced_config` — the
  document's seven engine-specific advanced-config branches declare no
  required field between them, and the enclosing object carries no sibling
  tag, so nothing in a payload could ever select one.
- `logsink_update.config` pinned to `opensearch_logsink` —
  `elasticsearch_logsink` and `opensearch_logsink` are identical field for
  field, so no payload distinguishes them either.

This decision amends `skip-is-the-only-opt-out` to say so: two opt-out
surfaces exist now, not one, and both are bounded the same way.

== Choice

=== The test that makes a pin an opt-out

Every other guidance key is checked and applied, but dropping its entry
still leaves a run that generates — with plainer names, a different inline
model boundary, a different tag assignment. `$unionPins` is not that.
Drop an entry a union still needs and the run that needed it fails:
nothing else the generator does can pick a branch among seven engine
configs with zero required fields between them and no sibling tag to read
instead. `$unionTags`, `$propertyRenames`, `$inlineModels` and every other
guidance key change what a successful run produces; `$unionPins` is the
one key whose *absence* changes the exit status. That is the same test
`skip-is-the-only-opt-out` already applies to `$skip` — a skip entry's
absence is what turns a construct the generator would otherwise refuse
into one it accepts — and `$unionPins` passes it by the identical
mechanism, on the far side of the line between guidance and an opt-out.

=== Why a pin is more dangerous than a skip, and what makes it acceptable anyway

A skip removes the thing entirely, so there is nothing left in the output
to be wrong. A pin does not: it leaves something in the output that *is*
wrong and *looks* right, at exit 0. `database_config.config` is the live
case — its seven engine branches accept each other's payloads, which is
why no rule could decide between them, so a MySQL payload read back
through the pinned property hydrates into `PostgresAdvancedConfig`, every
field the schema declared for MySQL landing in the extras bag, with no
error anywhere. `skip-is-the-only-opt-out` already named the shape this
project refuses: "a method compiling clean at max strictness and failing
only when called." A pinned union is not even that — it does not fail when
called, it answers wrong, silently, which is exactly the shape
`fail-loud-never-silent` and `guidance-cannot-mislead` both exist to close
off.

Three mitigations are what make shipping that anyway acceptable, and all
three are load-bearing rather than decorative:

- *A written reason.* Every pin carries one, the same obligation a `$skip`
  entry carries, checked the same way — an empty reason fails the run.
- *Staleness checking.* A pin on a union the generator can now decide on
  its own fails the run, naming the entry, exactly as a stale `$skip`
  entry does. An opt-out list nobody has to prune again is a second source
  of truth silently drifting from the schema — the same failure `$skip`
  exists to replace, one layer up — and `$unionPins` inherits the same
  check rather than a weaker one.
- *Reported on every run, not only the run that added it.* Every
  generation prints which property is pinned, to what branch, by what
  reason, and how many branches that discards — every run, not a one-time
  notice a consumer can go on to ignore. This is the mitigation a skip
  does not need and a pin cannot do without: nothing else stands between a
  consumer forgetting a pin exists and a payload silently landing in the
  wrong class.

None of the three make a pin *safe* the way an omission is safe. They make
it *accountable*: wrong when it is wrong, but never quietly wrong.

=== What would admit a third

No third opt-out surface exists, and none should exist without a decision
that supersedes or amends this one by name, the way this one amends
`skip-is-the-only-opt-out`. Landing one in code with no decision behind it
is exactly the precedent this project refuses to set by omission. A
candidate third surface would have to pass the same test `$unionPins`
passes — a guidance key whose absence changes the exit status, not merely
what the output looks like — and ship with all three mitigations above
already built: a written reason checked for presence, staleness checking
that fails the run the moment the construct it names stops being a
problem, and a notice printed on every run rather than only the one that
added it. A key that does not need all three is not an opt-out by this
decision's own test, and does not need this decision's process to add.

== Consequences

- `skip-is-the-only-opt-out` is corrected in the same commit: its title no
  longer claims `$skip` is the only opt-out, and the body no longer
  asserts that no second surface exists. What it says about `$skip`'s own
  shape — omit, never emit-degraded, checked for staleness, keyed to one
  operation or component at a time — is unchanged and still holds.
- The two live pins, `database_config.config` and `logsink_update.config`,
  are correct for the client `examples/digitalocean/paogen.php` describes
  and stay as they are; this records why they are acceptable, it does not
  reopen either.
- Any future construct that degrades knowingly rather than refusing or
  omitting needs its own decision passing the same test, not a third
  guidance key added beside `$unionPins` on the strength of this one.
