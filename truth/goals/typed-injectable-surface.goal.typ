#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "The generated client is a typed, injectable surface",
  status: active(2026, 7, 29),
  acid-test: [
    A consumer can register the generated client in a dependency-injection
    container, depend on it by interface from their own code, decorate it
    with their own implementation of that same interface, and substitute a
    test double for it — all without touching the generated tree and
    without reaching for reflection or runtime patching.
  ],
)

The generated client is not a facade to be reached for; it is a
collaborator to be injected. That means every dependency it needs arrives
through its constructor, it holds no global or static state, and it
publishes an interface rather than only a concrete class.

The interface is what makes the layered story work. A consumer who wants
retries, token refresh, richer return types, or a friendlier method name
writes their own type against the generated interface and wraps the
generated implementation. Their code and the generated code meet at a
declared contract, so regeneration cannot silently break the seam — it
either still satisfies the interface or it fails to compile.

Transport concerns are somebody else's interface. The client talks to a
standard HTTP abstraction, so authentication, logging, retry and rate
limiting are composed underneath it by the consumer, not generated into
it.
