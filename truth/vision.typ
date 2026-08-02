#import "@local/speconaut:0.1.0": *

#show: vision.with(
  title: "paogen",
  goals: (
    link("goals/never-edit-generated.goal.typ"),
    link("goals/user-code-guides-generation.goal.typ"),
    link("goals/strict-clean-output.goal.typ"),
    link("goals/typed-injectable-surface.goal.typ"),
    link("goals/fail-loud-never-silent.goal.typ"),
    link("goals/real-world-schemas.goal.typ"),
    link("goals/cheap-regeneration.goal.typ"),
    link("goals/declared-shapes-become-types.goal.typ"),
  ),
)

What it feels like to consume an HTTP API from a project that uses paogen.

== The promise

You point paogen at the schema your vendor publishes. You get a typed
client you never edit, that passes your strictest checks, and that you
extend from your own code rather than by patching theirs.

== Setup

Your vendor publishes a schema. You add paogen as a development
dependency and write one small file of guidance describing where the
schema lives, where the output goes, and what namespace it takes. You run
one command. A generated tree appears, and it compiles.

You have written no template. You have copied no example client. You have
not opened the generated tree.

== Making it pleasant

The default output is correct but literal — it speaks the vendor's
vocabulary, including their awkward names and their stringly-typed
fields. So you start guiding.

You rename the shapes whose published names read badly. You declare that
the field the vendor calls a string of digits is really your own
identifier type, and paogen threads that type through every operation
that touches it. You tell it which field discriminates a union the vendor
left ambiguous. Each of these is a few lines of your own declarative
code, sitting beside the schema path, and each one changes the generated
tree the next time you run the command.

None of it leaks to the people who consume your client. They see types.

== Going beyond generation

Some things are not the generator's job. Retries, token refresh, logging,
rate limiting — those belong to the transport, and you compose them
underneath the client using the standard HTTP abstraction it already
depends on.

Other things are convenience: a method that takes your domain object
instead of three parameters, a paginated iterator over an endpoint that
returns pages. Those live in your own class, which implements the same
interface the generator emits and delegates to the generated
implementation. Your code and the generated code meet at a declared
contract. When the schema changes, either your wrapper still satisfies
that contract or your build tells you it does not.

== When the schema changes

The vendor republishes. You run the same command. You read the diff.

The diff shows what changed upstream and nothing else: no reordering, no
formatting churn, no files left behind for operations that no longer
exist. If something upstream is now beyond what paogen can represent, the
run stops and names it, rather than quietly emitting a smaller client and
reporting success.

You commit the regenerated tree in one commit, and the review is about
the API change, not about the generator.

== What you have to trust

That the generated tree is exactly what the schema and your guidance
imply, and nothing else. Not a convention you remember. Not a protected
region you must not disturb. Not a note in a README asking the next
person to be careful.

Every mechanism in paogen exists to make that trust cheap: total
regeneration so nothing hand-written can survive in the output,
determinism so the diff means something, refusal so silence always means
success, and strict-clean output so your own checks — not paogen's
promises — are what tell you the client is sound.

== What is deliberately absent

No templates, and so no template language to learn and no user logic
smuggled into the output. No inheritance hooks or protected regions in
generated types. No partial generation that reports success. No baseline
or suppression file shipped to make the output pass your analysis.

== What this is judged against

The promise above is realised only through the goals linked from this
artifact. Each goal carries an acid test that can be run rather than
argued about. A goal no decision serves is unrealised; a decision serving
no goal is drift.
