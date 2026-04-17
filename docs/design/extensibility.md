# Generated-Client Extensibility

**Status:** draft — to be decided before implementing the generator  
**Date:** 2026-04-17

## Requirement

> The generated client should allow to modify itself outside of generated code
> points. All generated code can't (should not) be edited by hand, but all
> logic can be redefined (overridden) in some other way.

Translation: the user must be able to regenerate the client from an updated
OpenAPI schema without losing their customizations.

## Options

### 1. Abstract base + user subclass (partial-class pattern)

Generate `Generated/ApiClient.php` (always overwritten on regen). Generate
**once** (skip if exists) a `src/ApiClient.php extends Generated\ApiClient`.
Users override methods in the subclass.

**Pros:** trivially PHP-idiomatic; IDE-friendly; zero runtime cost.  
**Cons:** per-endpoint override only; no clean home for cross-cutting concerns
(auth, retries, logging) — they end up scattered across subclass methods.

### 2. PSR-15-style middleware pipeline

Generate `final` classes. The client holds a middleware stack applied to every
outbound request. Users inject middleware for auth, retries, logging,
correlation IDs, etc.

**Pros:** cross-cutting concerns live in one place; composable; PSR-aligned.  
**Cons:** worse for *per-endpoint* behavior change (you'd have to inspect the
request and branch, which is brittle).

### 3. Strategy injection (DI)

Auth, serializer, error mapper, URL builder are interfaces. Generator emits a
default implementation. Users bind their own via a simple container or
constructor injection.

**Pros:** clean separation per concern; easy to test; no inheritance.  
**Cons:** doesn't cover the "override just this one endpoint" case.

## Recommendation (pending confirmation)

**Combine 1 + 3.** Abstract base + user subclass handles per-endpoint
overrides; strategy interfaces handle cross-cutting concerns. Skip middleware
(option 2) unless a concrete need appears — it's the most complex of the three
and partially redundant with strategies.

Sketch:

```
Generated/
  ApiClient.php         (regenerated; final on the PHP level? no — must be extensible)
  Model/User.php        (regenerated)
  Contract/
    Authenticator.php   (interface, regenerated)
    Serializer.php      (interface, regenerated)
    ErrorMapper.php     (interface, regenerated)

src/
  ApiClient.php         (generated once; extends Generated\ApiClient)
  Auth/BearerAuth.php   (user-written; implements Generated\Contract\Authenticator)
```

Regeneration logic:

* Overwrite everything in `Generated/`.
* For files outside `Generated/`: skip if exists. Never overwrite.

This matches the "split-file pattern" that `speconaut-phpunit` uses for its
step files — proven approach in the same stack.

## Open Questions

* How do we mark "generated once, never overwrite" in a way that survives user
  edits but catches drift? (`@generated once` docblock tag? `.generated-once`
  marker file? inspect file for a magic header?)
* Do we want a `--force-regenerate` flag that overwrites the user subclass
  too? (I lean toward no: users can `git checkout -- src/ApiClient.php`.)
* Models: are they always fully regenerated, or can users decorate them via
  partial extension? (Probably fully regenerated; decorators live elsewhere.)
