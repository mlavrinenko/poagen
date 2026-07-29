# paogen examples

Each sub-directory here is scaffolded like a standalone consumer
project — its own `composer.json`, `README.md`, `paogen.php`,
vendored schema, and (when generation succeeds) committed `generated/`
output. Everything a user would have after dropping paogen into their
own repo, minus `vendor/`.

```
examples/
├── petstore/          ✅ passes — small textbook schema
├── digitalocean/      ⚠️  expected-failure (T-030) — no generated/ tree
└── github/            ⚠️  expected-failure (T-030) — no generated/ tree
```

## Running an example

Each directory is self-contained. To work with the Petstore one:

```bash
cd examples/petstore
composer install
composer generate
```

`composer install` picks paogen up via a `path` composer repository
pointing at `../..`, so you always get the current working copy — no
Packagist round-trip. `composer generate` is a one-line alias for
`paogen generate paogen.php`.

## The three examples

- **`petstore/`** — the canonical Swagger Petstore 3.0 schema. A
  known-good end-to-end generation path: models, enums, an inline
  synthesised class, a small `ApiClient`, a `jsonSerialize` round-trip.
- **`digitalocean/`** — the DigitalOcean public API 3.0.0 bundle
  (2.7 MB, 722 components). `.expected-failure`: a ref-only `oneOf`
  without `discriminator` trips ADR-010's generator-time error
  ([T-030](../truth/tasks/030-undiscriminated-oneof-generator-time-error.task-260420.typ)).
  No `generated/` tree is committed for it — see "`just check-examples`"
  below.
- **`github/`** — the GitHub REST API 3.0.3 bundle (8.8 MB, ~918
  components, ~1000 endpoints). Same `.expected-failure` reason
  (T-030), same absence of a `generated/` tree.

## `just check-examples`

Run from the repo root:

```bash
just check-examples
```

The recipe walks every `examples/*/paogen.php`, invokes the
generator, and summarises:

- Directory without `.expected-failure` → generation must succeed
  with no drift vs the committed `generated/` tree.
- Directory with `.expected-failure` → generation is *expected* to
  fail, and the directory carries no `generated/` tree — the marker
  and a committed tree can't both be true. An unexpected success is
  flagged so the marker doesn't go stale; an `.expected-failure`
  directory that still has a `generated/` tree is flagged the same
  way, naming the example.

`check-examples` is deliberately **not** part of `just check`. Broken
examples are committed on purpose — they are the dashboard for what
we want the generator to handle next. Unrelated changes must not be
blocked on them.

## Adding a new example

1. Create `examples/<vendor>/` with: `composer.json`, `README.md`,
   `paogen.php`, `schemas/<vendor>-<version>.yaml`.
2. Run `composer install` once to prove the `path` repo resolves,
   then add the sub-directory's `composer.lock` / `vendor/` to the
   sub-directory's `.gitignore`.
3. Run `paogen generate paogen.php`. If it succeeds, commit the
   `generated/` tree. If it fails with a spec-level gap, add a
   `.expected-failure` file explaining which task tracks the fix.
4. Confirm `just check-examples` exits zero.
5. Add one line to the table at the top of this file.
