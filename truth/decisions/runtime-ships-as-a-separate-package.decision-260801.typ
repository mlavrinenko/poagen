#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "The runtime ships as a package separate from the generator",
  status: accepted(2026, 8, 1),
  contexts: (generation-context,),
  goals: (link("../goals/typed-injectable-surface.goal.typ"),),
  standards: (
    link("../standards/caller-surface-is-injectable.standard-260729.typ"),
  ),
)

== Context

`operations-delegate-to-an-injected-transport` and the standard on an
injectable caller surface already established that #a(GeneratedFile) names
nothing but the runtime's contracts — a transport interface, a response
type, a marshaller. No emitted line names #the(Generator) itself, the parser
it reads a schema with, the library it prints code with, or the differ it
compares output with.

Despite that, all of it shipped as one installable package. A project that
merely runs a generated client took a production dependency on the whole
generator, and every one of its own dependencies came along uninvited —
none reachable from any emitted file, all resolved and installed on every
downstream deployment regardless. The setup story this project tells
elsewhere already describes adding #the(Generator) as a development
dependency; the single-package shape made that description false.

Options weighed:

- Leave it as one package and rely on consumers passing an install flag that
  excludes development dependencies. Rejected: a package named in a
  production `require` is a production dependency by definition — no install
  flag changes what the dependency graph says is needed to run.
- Split into two repositories, one per package. Rejected for this round: a
  second repository buys nothing yet that a second package inside one
  repository does not, and it adds a release-coordination cost — keeping two
  histories in lockstep — that only matters once either package is actually
  published, which is separately out of scope.
- Split into two packages inside the same repository, the generator
  depending on the runtime and not the reverse.

== Choice

The third. The runtime becomes its own installable package, requiring only
what marshalling and transport need at run time. The generator becomes a
second package in the same repository that depends on the runtime; the
runtime depends on neither the parser, the code-generation library, nor the
differ.

The dependency points one way on purpose. #The(Generator) already only ever
reads runtime types to know what to emit — it never needed to be read back.
Making that the package boundary as well as the code boundary means nothing
downstream of a generated client can end up depending on the generator by
accident: the two are wired together by one `require` in one direction, not
by sharing a namespace root that happens to also contain generator code.

== Consequences

- A production install of a project that only runs a generated client
  carries the runtime and nothing the generator needed to build it. Verified
  directly: a scratch project requiring the runtime package alone, with the
  generator absent from its installed dependencies entirely, loads a
  generated client and completes a real call through a stub transport.
- #The(Generator)'s own install now carries the runtime as a normal
  dependency, so nothing in its emitters or its tests duplicates a runtime
  type — there is exactly one definition of each, owned by the package that
  ships it to consumers.
- A consumer installs #the(Generator) only as a development dependency, and
  the setup story this project tells elsewhere is now true of the code
  rather than aspirational.
- The runtime keeps the namespace it already had. #A(GeneratedFile) imports
  from it exactly as before, and that import now resolves through exactly
  one package rather than an arbitrary one of two — no emitted file changed
  to make this true, because none ever named anything outside that
  namespace.
- Two packages in one repository still move in lockstep by construction:
  there is one history, one set of commits, one point where both change
  together. Publishing either one, and whatever version discipline that
  requires between them, is deferred rather than answered here.
