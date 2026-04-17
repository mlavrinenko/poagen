# Agent guide for paogen

## Workflow

- **Spec-first.** Use the `speconaut-workflow` skill before any change to
  `src/` or `truth/`. Specs live in `truth/specs/*.typ`; decisions in
  `truth/decisions/*.typ`. The `truth/` directory is the source of truth —
  if code and spec disagree, fix the spec first, then re-confirm.
- **Conventional commits**, English. No `Co-Authored-By` lines.

## Quality gates (`just check`)

- **PHPStan**: `level: max` with `phpstan-strict-rules`,
  `phpstan-deprecation-rules`, and bleeding-edge config — see ADR-004.
- **Linecop**: enforced on `src/**`. Exempt: `tests/fixtures/**`,
  `vendor/**`, `build/**`, `tests/generated/**`. Configured in
  `.linecop.yaml`.
- **php-cs-fixer + rector** must run cleanly.
- **speconaut**: `just check-specs` validates the truth tree;
  `just check-generated-tests` enforces no drift in generated PHPUnit
  stubs.

When the linter complains about formatting, run `just format` before
hand-editing.

## Generated-code policy

- The generator's output lives under directories named `Generated/`. They
  are **never hand-edited**.
- All user customisation lives in either:
  - the user's `paogen.php` `Profile` (project-level config), or
  - attributes on the user's own value objects (`#[BindsFormat(...)]`
    et al.).
- See ADRs 001–003 for the rationale.

## Where things live

| Topic | Location |
|---|---|
| Behaviour specs | `truth/specs/*.typ` |
| Architectural decisions | `truth/decisions/*.typ` |
| Domain entities | `truth/domain/*.typ` |
| Implementation tasks | `truth/tasks/*.typ` (when present) |
| Long-form notes | `docs/design/*.md` (limitations only — decisions belong in `truth/decisions/`) |
| Real-world OpenAPI fixtures | `tests/fixtures/schemas/` |
| Sample profiles | `tests/fixtures/profiles/` |
| Golden generated trees | `tests/fixtures/generated/<vendor>/` |

## Environment

- PHP 8.4 via devbox (`devbox shell`); see `devbox.json`.
- speconaut binary expected on `$PATH`. If your install rebuilds on every
  invocation, point at a prebuilt binary directly — see the project
  Justfile for how the recipes invoke it.
