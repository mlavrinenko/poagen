set dotenv-load := false

mod docs '.just/docs.just'

# Rector, and PHPStan when no `tmpDir` is configured, compile a DI container
# into $TMPDIR and key it by config hash — not by checkout. The default is a
# machine-wide /tmp path, so containers built by one worktree are reused by
# another, and a deleted worktree leaves absolute paths baked into a cache a
# later run still hits. The symptom is an opaque worker-spawn failure that
# reads like a tool regression: `Process "..." not found`, or a Phar path that
# does not exist. Scoping it per checkout makes the cache follow the tree that
# built it, and `just clean` can then actually clear it.
export TMPDIR := justfile_directory() / "build/cache/tmp"

# List available recipes
default:
    @just --list

# Ensure the per-checkout tool cache exists (see TMPDIR above)
[private]
tmpdir:
    @mkdir -p "{{ TMPDIR }}"

# Run all quality checks (lint + test + speconaut check-specs)
#
# The speconaut recipes below were out of this aggregate for months under a
# wrong diagnosis: an earlier version of this comment blamed `speconaut
# check` reading poagen's `.mindtape/config.toml` through a stale embedded
# mindtape parser that rejected keys `mt` itself writes. That was never the
# actual cause and is not preserved here because it is wrong — the real
# cause was upstream of any config: speconaut's own Cargo workspace did not
# resolve (its manifest pointed at `../mindtape/crates/swhid-mint`, a path
# dependency that no longer existed in the mindtape checkout), so it could
# not rebuild and the installed binary stayed frozen at a July build, long
# before any of these recipes could run against poagen's current tree or
# CLI. The toolchain was healed 2026-07-31: the workspace resolves, the
# installed binary is current, and `speconaut check truth/` runs clean — 4
# features, 0 warnings (down from 31, all `task lifecycle provenance`; see
# `declare-paogen-runs-no-sessions`).
#
# All three are in the gate now. `check-drift` and `check-generated-tests`
# needed `tests/generated/manifest.json`, which only a real `generate-tests`
# run produces — and that run appended ~200 `Implement:` stubs plus 149
# orphaned step methods, so neither recipe could pass until the step bodies
# caught up with the specs. They have: the 149 orphans were the stubs' old
# names, their bodies rehomed, and the generated suite went 77 tests to 93
# with no failures. The lockfile was refreshed the same day, first time
# since April — 88 scenarios, 565 traces.
#
# Runs `test-coverage`, not a bare `test` (coverage-floor-in-the-gate): the
# suite under coverage takes ~9s against ~6s bare, so running it once here
# with the floor enforced costs less than running it twice — once bare for
# `check`, once under coverage for a recipe nothing else called. `just
# test` stays the fast, uninstrumented path for local iteration.
check: tmpdir lint test-coverage check-specs check-drift check-generated-tests

# Full pre-commit gate
gate: check

# Run the full gate and record that it passed against this worktree, so the
# freshness predicate on `mt flip ... done` can assert it without re-running
# the gate inside the flip. Prefer this over a bare `just check` when you are
# about to close a task — a bare run proves the tree is good but records
# nothing, and the flip will refuse for want of evidence rather than merit.
gated-check: check
    scripts/gate-fresh record

# Run all linters in parallel
lint: tmpdir
    @echo -n 'cs-fixer phpstan phpstan-generated rector linecop jscpd jscpd-generated' | parallel --will-cite --halt now,fail=1 --delimiter=' ' just lint-{}

# Check code style (PER-CS 2.0 + PHP 8.4)
#
# Needs `tmpdir`: php-cs-fixer spawns its parallel workers through PHP's
# sys_get_temp_dir(), which is $TMPDIR (see the export at the top of this
# file) — a bare `just lint-cs-fixer` in a fresh checkout dies with
# "Failed creating temp file as sys_get_temp_dir=... is not writable"
# without this dependency, dry-run or not.
lint-cs-fixer: tmpdir
    php-cs-fixer fix --diff --verbose --dry-run

# Static analysis on src/
lint-phpstan: tmpdir
    phpstan analyse --memory-limit=512M

# Static analysis on generated fixtures (consumer-view;
# `quality-gates-at-maximum-strictness`), plus a
# fan-out into every example's own check (examples-check-themselves).
#
# tests/fixtures/generated isn't owned by any example, so it is analysed
# directly, here, against phpstan-generated.neon exactly as before. Every
# examples/*/ directory now carries its own Justfile and its own
# phpstan.neon (which `includes:` this file, so it is held to the identical
# no-baseline / no-excludePaths / no-ignoreErrors max-level absolute), and
# decides its own path set — `generated/` when it exists, `src/` when it
# exists (that tier assignment for hand-written consumer code is explained
# in examples/<name>/Justfile, not here), skipped entirely when neither does
# (the .expected-failure examples). This recipe no longer assembles that
# path list itself: it just runs each example's own `check`, the same
# recipe you'd run by hand from inside that directory, so a regression in
# any example tree fails here exactly the way it fails standalone.
lint-phpstan-generated: tmpdir
    #!/usr/bin/env bash
    set -eo pipefail
    phpstan analyse -c phpstan-generated.neon --memory-limit=512M tests/fixtures/generated
    for dir in examples/*/; do
        name=$(basename "$dir")
        echo "== $name =="
        (cd "$dir" && just check)
    done

# Check for Rector refactoring opportunities
lint-rector: tmpdir
    rector --dry-run

# Per-language line-count limits on src/ (`quality-gates-at-maximum-strictness`)
lint-linecop:
    linecop

# Duplication gate on hand-written code (source tier; jscpd-as-a-real-gate)
#
# A file's preamble is repeated text that says nothing about duplicated
# logic: two files importing the same eight symbols are not two copies of
# an idea. So `.jscpd.json` drops `declare`, `namespace` and top-level
# `use` lines with an `ignorePattern` before detection, which lets
# `minTokens` sit at jscpd's default 50 and still report zero header
# matches in src/. Raising the threshold instead was the first attempt and
# the wrong one: 84 was needed to bury the noise, and it buried every
# genuine short clone with it.
#
# The pattern is anchored to column 0 (`(?m)^`), so a trait `use` inside a
# class body — which is real code — still counts. Only the preamble goes.
#
# `examples/*/src` is hand-written consumer code and belongs in THIS tier, not
# the generated one, even though lint-phpstan-generated puts it in that tier.
# The two recipes divide the tree for different reasons: phpstan asks "whose
# strictness standard applies", and consumer code answers "the consumer's".
# jscpd asks "what is this number measuring", and a duplication figure over
# output plus hand-written code measures neither.
#
# That same reading is why `.jscpd.json` carries an `ignore` for
# `tests/fixtures/generated/**` and `examples/*/generated/**`. This recipe
# scans `tests`, and the emitted golden trees live inside it, so until
# 2026-08-03 every golden tree was counted here as well as in the generated
# tier — the mirror image of the mistake the paragraph above describes, and
# invisible because nobody was looking for emitted output on this side.
# Committing the widened-shapes and open-shapes goldens moved this tier from
# 3.20% to 3.68% and turned it red against its 3.5% threshold, which is how
# the double-count was finally found.
#
# `--threshold` gates on jscpd's own "Total duplicated lines" percentage
# across every format it scans (json + php + yaml), the same figure the
# console table's **Total** row prints — not the per-format row. Verified by
# probing on 2026-08-03: 3.1 fails ("found too many duplicates (3.2%) over
# threshold (3.1%)") and 3.3 passes, against a tree whose php row alone read
# 3.42%.
#
# Do not add `--exit-code` alongside `--threshold`: jscpd's `--exit-code`
# fails on ANY clone found regardless of the threshold, so combining the two
# would fail today even though the measured figure is under the limit.
# `--threshold` alone already sets the exit code (0 under the limit, 1 over
# it). (If you do reach for `--exit-code` on its own elsewhere, always give it
# an explicit value — spelled bare it eats the next positional argument.)
#
# deduplicate-the-test-suite moved nine tests/Integration/ files onto
# tests/Support/GeneratedTreeSandbox.php's shared sandbox-dir, composer-loader,
# generator-construction and CLI-invocation helpers — repeated scaffolding
# that never carried the schema, the profile or the expectation a test
# actually asserted on, so pulling it out left every one of those visible at
# the call site. What remained (tests/generated/, a schema fixture, and a
# handful of same-shape assertions or test doubles that ARE a test's subject)
# was left alone on purpose.
#
# Measured 2026-08-05, hand-written code including `runtime/tests`: 2.96%
# duplicated lines, 138 clones over 364 files — historical now, folded into
# the "every figure before" paragraph below.
#
# `heal-the-duplication-gate-margins` found the ratchet nearly tripwired:
# measured 2026-08-09 at this task's base commit, 2.98% against this 3.0%
# threshold (157 clones, 422 files) — about 12 lines of slack, essentially
# none. The fix came from the tree, not the number: jscpd's own JSON
# reporter (`--reporters json`, read via `statistics.total.percentage`
# rather than eyeballed off the console table) named the largest single
# clone family as nine tests/Integration/ files carrying a byte-identical
# copy of a `plan(array $skip): GenerationPlan` /
# `refusalMessage(array $skip): string` / `clientSource(GenerationPlan
# $plan): string` / `modelSource(GenerationPlan $plan, string $className):
# string` quartet — the same "does this schema construct get accepted or
# refused" scaffolding `deduplicate-the-test-suite` already collapsed once
# for a different family, just not this one. Four new traits under
# tests/Support/ replaced the per-file copies: SkipPlanFixture (the
# `plan()` all nine shared, sandbox prefix now derived from the class name
# instead of a per-file literal), RefusalPlanFixture (composes it, adds
# `refusalMessage()` for the four files that also assert on a caught
# `UnrepresentableConstructsException`), and ApiClientSourceFixture /
# ModelSourceFixture for the smaller `clientSource()` / `modelSource()`
# families. Every call site still reads `$this->plan(...)`,
# `$this->refusalMessage(...)`, unchanged — what each test asserts did not
# move, only where the plumbing lives.
#
# Measured again the same day, after the traits: 2.63% duplicated lines,
# 142 clones over 426 files (the four new trait files count too) — about
# 196 lines of margin against this 3.0% threshold, up from about 12. What
# is left splits, by the same JSON report, into: hand-written source clones
# that are genuine duplicated logic, not scaffolding
# (`src/Generator/ProfileTargetValidator.php` against
# `src/Generator/SkipListValidator.php`, 28 lines, plus a long tail of
# smaller `Generator/Emit/*` pairs); fixture-schema YAML pairs that are
# deliberately-similar but distinct test documents, not preamble
# (`fixtures/schemas/nullable-idiom-3.0.yaml` against its `3.1` sibling, 28
# lines); and test-double pairs already ruled "left alone on purpose" two
# paragraphs up, because the shape IS what the test proves
# (`examples/petstore/src/CachingStoreClient.php` against
# `tests/generated/CachingStoreClient.php`, ~67 raw lines across three
# clone entries). None of that remainder is the repeated-text-saying-
# nothing the import-block `ignorePattern` above targets, so none of it
# gets one.
#
# The threshold stays 3.0. Shrinking the duplicated-line count and then
# re-tightening the threshold to hug the new figure would recreate the
# exact zero-slack tripwire this task exists to fix — a RATCHET only ever
# moves down, it is not a mandate to move down *immediately* every time
# real duplication falls.
#
# Re-measured 2026-08-09 after `opt-in-collapse-for-repeated-response-maps`
# added four files under src/ and three test files: 2.65% duplicated lines,
# 145 clones over 436 files — about 192 lines of margin, essentially the same
# as the 2.63%/142/426 above. The three clones the new files take part in are
# all the class-docblock-header family that ten other test pairs in this tree
# already form (`UuidFormatBindingTest` against `FormatBindingValidatorTest`,
# `SchemaWalkReferencedResponseTest` against `SchemaWalkTest`, and so on):
# accepted here on the same terms as those, not a new category. The threshold
# does not move.
#
# Every measured figure this comment carried before 2026-08-09 was stale,
# and each was true when written: 4.99%/90 and 5.09%/92 predate
# deduplicate-the-test-suite, a "5.5%" threshold outlived its own recipe
# (the argument had read 3.5 for two days), the 3.36%/76 recorded on
# 2026-08-01 measured 3.20%/92 on the tree that replaced it, and
# 2.96%/138/364 (above) predates this task's own trait extraction.
# Re-measure before you cite one.
#
# RATCHET: this number only ever moves DOWN. Never raise it to admit a clone.
lint-jscpd: tmpdir
    #!/usr/bin/env bash
    set -eo pipefail
    shopt -s nullglob
    paths=(src runtime/src runtime/tests tests examples/*/src)
    reportdir="$TMPDIR/jscpd-source"
    rm -rf "$reportdir"
    mkdir -p "$reportdir"
    status=0
    jscpd -c .jscpd.json --threshold 3.0 --reporters console,json --output "$reportdir" "${paths[@]}" || status=$?
    scripts/jscpd-margin "source tree" "$reportdir/jscpd-report.json" 3.0
    exit $status

# Duplication gate on emitted output, ONE TREE AT A TIME (generated tier;
# generated-tier-duplication-ratchet-blocks-new-golden-trees)
#
# WHAT THE NUMBER MEANS: the highest duplication ratio any single emitted
# client reaches, measured inside that client alone. It is not a figure over
# the corpus of trees, and it does not move when a tree is added or removed.
#
# It used to be a corpus figure, and that is what made it unusable. Every
# emitted tree carries its own ApiException.php — 96 lines, 73 of them
# identical across trees, and deliberately so: the class is namespaced into
# the consumer's package and is "the type a caller catches for this API" (its
# own emitted docblock says so), which is exactly why it cannot be factored
# into runtime/. Four copies existed, so a corpus figure rose whenever a
# golden tree was added, for a reason no emitter change could ever fix. Two
# tasks paid for that: close-the-three-sites-that-widen-a-declared-shape and
# additional-properties-become-a-typed-bag both dropped their golden trees
# rather than touch this threshold, leaving the shapes they introduced with no
# generated-tier PHPStan analysis at all — the one tier held to no baseline,
# no excludePaths and no ignoreErrors. Committing both trees on 2026-08-03
# took the corpus figure from 16.02% to 17.68% against a 16.5% threshold.
#
# Per tree is not a loosening, it is a large tightening. The corpus figure was
# 16.02% under a 16.5% threshold. Measured the same day, the worst SINGLE tree
# is examples/kilbil/generated at 1.67% and every other tree reads 0.00%. The
# ~14 points that vanished were cross-tree artefacts: the four ApiException
# copies, plus examples/petstore/generated being the same document as
# tests/fixtures/generated/petstore emitted twice. Neither is duplicated logic
# inside one client, which is the only thing this tier was ever meant to catch
# — "the same 12-to-15 token-identical lines repeating across every operation
# in an emitted client".
#
# Consequence, stated here rather than discovered later: this tier no longer
# sees duplication BETWEEN trees. Deliberate. Two trees emitted from two
# documents share the generator's fixed scaffolding by construction, and no
# emitter change removes it.
#
# `.jscpd.generated.json` is a sibling of `.jscpd.json`, not a copy: it adds
# one `ignorePattern` entry that drops PHPDoc blocks, and the source tier
# deliberately does NOT get it. A duplicated docblock in hand-written code
# means someone copied a class, and a human can fix that. In emitted output
# the emitter writes the docblock from the document, two operations guarded by
# the same security scope must both say so, and PHP offers nowhere to factor a
# docblock to — so counting it measures the document, not the generator. Same
# reading that already drops the import block: repeated text that says nothing
# about duplicated logic. It costs the tier nothing real, measured: of
# kilbil's 16 intra-tree clones under the old config, 14 were the fixed
# sub-client interface docblock ("The contract for the `X` endpoints...")
# repeating once per sub-client. The 2 that survive are genuine code clones —
# Model/GoodsRequestItem vs Model/GoodsXmlRequestItem, and
# Model/ProcessSaleRequestGoodsDataItem vs
# Model/SearchClientRequestGoodsDataItem — two pairs of identically-shaped
# models the emitter really does write out twice.
#
# The emitted `// Generated by poagen` header needs no pattern of its own: it
# tokenises to 11 tokens, far under `minTokens: 50`, so it cannot form a clone
# by itself. Measured with a two-file probe, not assumed.
#
# Resolves its path set the way lint-phpstan-generated does: not every example
# has a generated/ directory (some are .expected-failure), so nullglob keeps a
# run with zero example trees from erroring on a literal unmatched glob. An
# empty tree list is a hard failure rather than a silent pass, for the reason
# phpstan-generated.neon spells out about analysing nothing.
#
# One threshold for every tree rather than a per-tree table: a table would
# need a new row for each new golden, which is precisely the friction this
# task removed. The single number is therefore a ceiling on the WORST tree,
# and it is set from the worst tree.
#
# Measured 2026-08-03, worst single tree (examples/kilbil/generated, 2209
# lines after the preamble and PHPDoc strips): 1.67% duplicated lines, 2
# clones, 37 lines. Every other tree — including both goldens added that day —
# measures 0.00%. 2.0% is set just above the worst: 44 lines at kilbil's size,
# so about 7 lines of slack, less than one `minTokens: 50` clone. Green today,
# minimal slack, no license to add more duplication. Historical: this 2.0%
# fallback and the mechanism it illustrates (worst tree sets the ceiling) are
# what the paragraphs below moved on from — see `4.41`, not `2.0`, for the
# fallback this recipe actually uses now.
#
# RATCHET: this number only ever moves DOWN as emitted duplication is
# collapsed further. It does not move when a golden tree is added — that is
# the whole point of measuring per tree — so "a new fixture pushed it up" is
# never an argument for raising it. Never raise it to accommodate a clone.
#
# It can move UP once more: a reviewed change to the emitter that alters WHAT
# it represents per operation, not how well it represents it, recorded in a
# decision artifact naming the change and carrying every tree's before and
# after number. `scripts/jscpd-generated-baselines`' own RATCHET paragraph and
# `envelope-remeasures-the-generated-duplication-floors.decision-260804.typ`
# carry the numbers this comment does not restate — this recipe's fallback
# went 2.0 to 4.41 there, covering `tests/fixtures/generated/petstore`, the
# worst fixture tree once the envelope changed what every tree represents.
#
# `retighten-the-generated-duplication-ceilings` re-measured 2026-08-08:
# `tests/fixtures/generated/petstore` is byte-for-byte unchanged since
# 08-04 (same 4 clones, same 35/795), so 4.41 is still the measured floor
# rounded up, not slack nobody re-checked. See
# `duplication-ceilings-follow-regeneration-not-collapse.decision-260808.typ`.
#
# `heal-the-duplication-gate-margins` found all four `examples/*/generated`
# rows sitting at, or a fraction of a line under, their ceiling — three pass
# only by equality (measured rounds to exactly the threshold) and the
# fourth, digitalocean, by about half a line. Re-measured 2026-08-09: every
# tree's clone count and duplicated-line count is unchanged or byte-identical
# to the 08-08 reading (kilbil and digitalocean's percentages drifted a
# hundredth from an unrelated regeneration growing the tree around the same
# clones — see `scripts/jscpd-generated-baselines`). This is not an
# unmeasured gap: the deferred per-class `StatusResponseMap` helper was
# re-checked against today's tree and still leaves a majority of every
# tree's client-to-client clones, and all of its model-to-model clones,
# cross-file and unreachable, and reaching the rest would repeat the
# structural-identity merge `name-inline-schemas-by-operation-and-status`
# already ruled out. The margin is deliberately zero, not an oversight —
# see `generated-tier-ceilings-cannot-fall-further.decision-260809.typ` for
# the full accounting, clone by clone.
#
# `opt-in-collapse-for-repeated-response-maps` built the one lever both of
# those decisions named and neither filed — `Profile::$responseMaps`, a
# consumer naming the operations whose response map is one shared
# declaration, emitted once onto `Generated\ResponseMaps`. Every row below
# is byte-identical after it, because no profile here declares a group; what
# the lever measures out at when one does (petstore 4.40 -> 0.00,
# digitalocean 10.92 -> 7.48, github 22.31 -> 19.66, kilbil unmoved) is in
# `a-shared-response-map-is-named-not-inferred.decision-260809.typ`, along
# with why deriving those groups from matching shapes is not poagen's to
# commit on a vendor's document. The tier also gains one fixture tree,
# `tests/fixtures/generated/shared-response-maps`, at 0.00% under the 4.41
# fallback below.
lint-jscpd-generated: tmpdir
    #!/usr/bin/env bash
    set -eo pipefail
    shopt -s nullglob
    trees=(tests/fixtures/generated/*/ examples/*/generated/)
    if [ ${#trees[@]} -eq 0 ]; then
        echo "lint-jscpd-generated: no emitted trees found — refusing a silent pass" >&2
        exit 1
    fi
    baselines=scripts/jscpd-generated-baselines
    status=0

    # A row naming a tree that no longer exists is a baseline outliving what
    # it gates — the shape of stale guidance this repo refuses everywhere
    # else, so it fails here too rather than sitting unread.
    while read -r tree_path _; do
        [ -d "$tree_path" ] || {
            echo "lint-jscpd-generated: $baselines names '$tree_path', which does not exist — delete the row or restore the tree" >&2
            status=1
        }
    done < <(grep -vE '^\s*(#|$)' "$baselines")

    for tree in "${trees[@]}"; do
        tree=${tree%/}
        # Fixture goldens are ours, small and hand-made: one uniform ceiling,
        # no row to add when a new one lands. Example trees are emitted from
        # real vendor documents whose scale differs by an order of magnitude,
        # so each carries its own measured ceiling. See the baselines file for
        # why that is a line about ownership rather than about size.
        threshold=$(awk -v t="$tree" '$1 == t { print $2; found = 1 } END { if (!found) print "" }' <(grep -vE '^\s*(#|$)' "$baselines"))

        if [ -z "$threshold" ]; then
            case "$tree" in
                examples/*/generated)
                    echo "lint-jscpd-generated: $tree has no row in $baselines — measure it and record a ceiling, do not let it pass unmeasured" >&2
                    status=1
                    continue
                    ;;
                *) threshold=4.41 ;;
            esac
        fi

        echo "== $tree (ceiling ${threshold}%) =="
        reportdir="$TMPDIR/jscpd-generated/$(echo "$tree" | tr '/' '_')"
        rm -rf "$reportdir"
        mkdir -p "$reportdir"
        jscpd -c .jscpd.generated.json --threshold "$threshold" --reporters console,json --output "$reportdir" "$tree" || status=1
        scripts/jscpd-margin "$tree" "$reportdir/jscpd-report.json" "$threshold"
    done
    exit $status

# Auto-fix code style
#
# Needs `tmpdir` for the same reason `lint-cs-fixer` does — see its comment.
# A fresh worktree that hasn't run `just check` yet dies with "Failed
# creating temp file as sys_get_temp_dir=... is not writable" otherwise.
format: tmpdir
    php-cs-fixer fix --diff --verbose

# Apply Rector refactorings
#
# Needs `tmpdir`: rector compiles its DI container into $TMPDIR (see the
# export at the top of this file and `lint-rector`'s identical dependency);
# without it a fresh worktree fails with `The path "..." is not a
# directory.`
format-rector: tmpdir
    rector

# Run tests
test: tmpdir
    phpunit

# Run tests with coverage and enforce the per-tier statement-coverage floor
# (coverage-floor-in-the-gate). Same `tmpdir` need as `test` — some
# integration tests (e.g. tests/Support/GeneratedTreeSandbox.php) write
# through sys_get_temp_dir().
#
# `-d pcov.directory=.` is not decoration. PCOV auto-detects `pcov.directory`
# from the working directory, and that auto-detection lands on `<repo>/src`
# — verified via `php -i | grep pcov.directory` under a bare `phpunit
# --coverage-clover ...` invocation from the repo root. `runtime/src/` sits
# outside that auto-detected root and is never instrumented, so an
# unconfigured run reports it at a flat 0.00%: an artifact of the wrong
# instrumentation root, not a fact about the runtime package's tests.
# Setting `pcov.directory` to the repo root explicitly (with `vendor` and
# `build` excluded, so vendored and generated code is never scanned) fixes
# it for every tier phpunit.xml.dist's `<source>` lists. `composer
# test:coverage` (which CI's coverage job runs) sets the same two flags for
# the same reason — this is not the only place PCOV could silently regress
# back to the broken default. It additionally runs under `env -u
# PHP_INI_SCAN_DIR`: in this devbox environment, composer's own binary
# leaks a stale `PHP_INI_SCAN_DIR` (pointing at an older, pcov-less
# `php-with-extensions` build) into every script it spawns, which silently
# drops pcov from the child `php` process even though `which php` still
# resolves to the correct, current build — verified via `php -d
# pcov.directory=. -m | grep pcov` under `composer test:coverage` with and
# without the `env -u`. This recipe invokes `php` directly, not through
# composer, so it never inherits that override and does not need the fix.
#
# Measured on 2026-08-01 with instrumentation fixed: src/ 87.50%,
# runtime/src/ 88.39%, combined 87.64% (statement coverage, clover). The
# same commit measured with the auto-detected (broken) directory: src/
# 87.46%, runtime/src/ 0.00%, combined 73.35% — the gap is entirely the
# instrumentation bug above, not a real difference in what either tier's
# tests exercise.
#
# SCOPE (coverage-floor-in-the-gate decision): src/ and runtime/src/ count.
# tests/fixtures/generated and examples/*/generated do not — emitted code is
# tool product already gated by the generated-tier PHPStan config, the
# byte-stability fixtures and `just check-examples`, and counting it would
# inflate the figure with code no human wrote. phpunit.xml.dist's <source>
# only lists src/ and runtime/src/, so emitted code never reaches the
# clover report to begin with; nothing here has to exclude it a second time.
#
# TWO FLOORS, NOT ONE: runtime/src/ ships as its own package
# (runtime-ships-as-a-separate-package), so it is measured and gated
# separately from src/ — a single blended number would let a regression in
# either tier hide behind the other's tests.
#
# RATCHET: these two floors only ever move UP, as real tests raise the
# measured figure. Lowering one to let a change land is not a fix, it is
# disabling the gate — write the missing test or take it to the owner
# instead. Conversely, never raise either number by writing a test that
# asserts nothing just to hit it (coverage-floor-in-the-gate's non-goal) —
# a floor met that way is worse than no floor.
test-coverage: tmpdir
    #!/usr/bin/env bash
    set -eo pipefail
    php -d pcov.directory=. -d 'pcov.exclude=~(vendor|build)~' vendor/bin/phpunit --coverage-html build/coverage --coverage-clover build/logs/clover.xml
    scripts/coverage-floor build/logs/clover.xml src=87.0 runtime/src=92.0

# Mutation testing (wire-mutation-testing) against src/ and runtime/src/
# together, via infection.json5. Deliberately NOT part of `just check` — see
# `truth/decisions/mutation-testing-stays-out-of-the-gate.decision-260802.typ`
# for the full measurement. Two full runs on 2026-08-02 took 7m14s and 7m22s
# wall-clock (19 threads on a 20-core box), 3049 mutants, MSI 87.77% then
# 87.47% (src/ ~88%, runtime/src/ ~85-87%; both drift a couple of points
# between runs — see the decision for why). Comfortably over the ~2 minute
# gate budget, so it runs on its own, on purpose, when someone asks for it.
#
# Same PCOV workaround `test-coverage` needs (see its comment above): the
# devbox-packaged composer leaks a stale `PHP_INI_SCAN_DIR` into script
# subprocesses and silently drops PCOV even though `which php` resolves
# correctly. This recipe invokes `php` and `vendor/bin/infection` directly,
# never through composer, so `env -u PHP_INI_SCAN_DIR` is enough — but the
# fix has to be threaded a second time via `--initial-tests-php-options`,
# because flags on infection's own PHP invocation do not propagate to the
# child PHP process infection spawns for its initial coverage-generating
# test run. `-d memory_limit=2G` is for infection's own process: the
# default 128M exhausts building the per-mutant test-runner command lines
# once past roughly 1500 of this run's 3049 mutants.
#
# Both recipes go through `scripts/mutation-run`, which refuses to start on a
# dirty tree. That guard predates fixtures-generate-to-a-scratch-tree, which
# closed the failure mode it was really about: the fixture profiles used to
# write their `output:` INTO the committed golden trees, so a mutant that
# changed emitted output rewrote the golden with the mutant's version and
# left it as a tracked modification — observed, not theorised, a single-file
# run against SecurityScheme.php left `$ApiKey` for `$apiKey` in the
# parameters fixture's ApiClient. Every profile under tests/fixtures/profiles/
# now defaults to a scratch directory instead (see
# tests/fixtures/profiles/scratch-output.php), so a test run — mutated
# generator or not — has no default path back into
# tests/fixtures/generated/. The dirty-tree check in scripts/mutation-run
# stays as a loud, fail-fast assertion of that guarantee; the script no
# longer silently restores on the way out, since a restore firing at all
# would mean the guarantee broke and deserves investigation, not a quiet
# `git checkout --`. The script's header carries the full account, including
# the untracked scratch directories a mutated CLI argument parser leaves at
# the repo root.
mutate: tmpdir
    scripts/mutation-run --threads=max

# Fast, changed-files-only mutation run for local iteration: mutates only
# lines added or modified relative to `main`. Explicit `--git-diff-base=main`
# rather than infection's own `git:default-base` guess, which resolves to
# `origin/master` here — wrong on both counts, since this repository has no
# `origin` remote configured and its trunk branch is `main`, not `master`.
#
# Timed on a single representative file (86 mutants, `src/Generator/Generator.php`)
# at ~20s wall-clock including the initial coverage run, comfortably inside
# the budget for routine use ahead of a full `just mutate`. Same PCOV
# workaround and same fixture guard as `mutate`, same reasons.
mutate-fast: tmpdir
    scripts/mutation-run --threads=max --git-diff-filter=AM --git-diff-base=main

# Prove a generated client installs and runs on poagen/client-runtime
# alone, with the generator absent (runtime-package-split). Builds a scratch
# composer project under build/ — not part of `just check`: that scratch
# project is a heavier, slower shape than anything else the offline gate
# does, which is a deliberate call this recipe's staying out does not
# revisit (keep-the-standalone-runtime-check-from-rotting-outside-the-gate).
# It no longer resolves anything from the network — see the script's own
# header for how and why that was re-examined and closed.
#
# This recipe's own staleness used to be patched around rather than cured:
# `tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php` pinned,
# offline and inside `just check`, the exact two API shapes this recipe's
# `run.php` depended on, as source text — brittle against a harmless
# rename or a formatting change, and a second copy of the same expectations
# to keep in step by hand. `generate-the-standalone-harness-consumer-
# instead-of-hand-writing-it` removed that pin: `run.php` now derives
# `ApiClient`'s constructor call from the installed generated tree by
# reflection instead of hard-coding it, so there is no longer a hand-copy
# to drift and nothing left for that test to usefully pin. See the script's
# own header and `truth/decisions/derive-the-standalone-consumer-instead-
# of-pinning-its-shape.decision-260808.typ`.
verify-runtime-standalone: tmpdir
    scripts/verify-runtime-standalone

# Regenerate one committed fixture golden tree on purpose
# (fixtures-generate-to-a-scratch-tree).
#
# tests/fixtures/profiles/*.php default `output:` to a scratch directory
# under $TMPDIR (see tests/fixtures/profiles/scratch-output.php) — a test
# run never writes into tests/fixtures/generated/<name> any more. This is
# the one supported way to update a golden on purpose: the CLI's own
# `--output` override (`GenerateCommand::withOutput()`, covered by
# `OutputOverrideCarriesEveryProfileFieldTest`) redirects that profile's
# write back onto its real tree. Review the diff before committing —
# `poagen generate --diff` first is not a bad habit.
#
# Usage: just regenerate-fixture parameters
regenerate-fixture name:
    php bin/poagen generate tests/fixtures/profiles/{{ name }}.php --output=tests/fixtures/generated/{{ name }}

# Install dependencies and local git hooks
install: install-hooks
    composer install

# Point git at .githooks/ so commit-msg enforces the task-trailer policy
# (require-a-task-trailer-on-every-commit). Idempotent — safe to re-run.
install-hooks:
    git config core.hooksPath .githooks
    @echo "git hooks installed: core.hooksPath -> .githooks"

# Update dependencies
update:
    composer update

# Verify every commit in a range carries a resolvable task reference
# (require-a-task-trailer-on-every-commit). Same rule the commit-msg hook
# enforces on new commits, run instead over existing history — for CI, or a
# human auditing a branch. Usage: `just check-commit-trailers origin/main..HEAD`.
check-commit-trailers range:
    .githooks/check-task-trailers --range '{{ range }}'

# Clean generated artifacts
clean:
    rm -rf build/cache build/coverage build/logs

# Check specs via speconaut
check-specs:
    speconaut check truth/

# Verify no spec/source drift (lockfile current with traces)
#
# `speconaut lock --check` is the purpose-built form: read-only, and it
# skips the session gate by design so it runs in CI. It replaced a pipeline
# that counted `content_mismatches` out of `speconaut status --format json`
# through php. That pipeline reported drift the recipe did not have —
# `status` exits 1 whenever it has anything to report at all, including
# ordinary debt like untraced features and process-only decisions, so under
# `pipefail` it failed before counting anything. Measured: exit 1 with
# `content_mismatches: 0`.
#
# Proven to detect real drift rather than merely exiting 0: editing one
# scenario's `#then` moves it to exit 1 and `content_mismatches: 1`, and
# reverting returns it to 0.
#
# Needs `tmpdir`: `lock` spawns the PHP adapter (speconaut-php-phpunit) to
# audit traces, and that subprocess dies (exit 255) when $TMPDIR points at a
# directory that doesn't exist yet — a bare `just check-drift` in a fresh
# worktree hits this without the dependency.
check-drift: tmpdir
    speconaut lock --check

# Generate/update PHPUnit test stubs from specs (dogfooding)
#
# `speconaut interop extract --format json | speconaut-phpunit ...` is
# gone: test generation is one subcommand now, and `--namespace` moved off
# the CLI entirely onto `.speconaut/config.toml`'s top-level `namespace`
# key (a PHP namespace is backslash-separated; a shell-quoted CLI flag
# can't carry that as safely as a TOML literal string can).
#
# Needs `tmpdir` for the same reason `check-drift` does (the PHP adapter)
# and because it shells out to `just format`, which needs it too — a bare
# `just generate-tests` in a fresh worktree fails with "sys_get_temp_dir is
# not writable" otherwise.
generate-tests: tmpdir
    speconaut generate-tests truth/ --adapter php-phpunit --output tests/generated
    just format

# Verify generated tests are up to date (CI-friendly drift check)
#
# `--check` alone; there is no `--strict`, and `--check` already fails on
# any warning, which is what `--strict` used to mean.
#
# This sat outside the gate while poagen's specs had outrun their step
# bodies: regenerating appended ~200 `Implement:` stubs and reported 149
# orphaned step methods, and either alone fails `--check`. Both are gone —
# the 149 orphans were the old names of the stubs, their bodies rehomed to
# the renamed steps.
check-generated-tests:
    speconaut generate-tests truth/ --adapter php-phpunit --output tests/generated --check

# Compare coverage-derived traces against declared scenarios
# (restore-coverage-derived-traceability).
#
# NOT in `just check` yet. `AuditTracesHandler` in the `php-phpunit` adapter
# hardcodes its PHPUnit `--filter` namespace to `Speconaut\Generated` and
# the RPC envelope carries no `namespace` field to override it with —
# unlike `generate-tests`, which already reads poagen's configured
# `namespace` above. Every one of poagen's 96 checked scenarios therefore
# fails identically with "phpunit exited with code 1" (verified by
# reproducing the collector's own PHPUnit invocation by hand against a
# class actually declaring `Poagen\Generator\Tests\Generated`: "No tests
# executed!", exit 1; the same invocation with the real namespace passes
# and reports real coverage). Filed upstream as
# `audit-traces-ignores-the-configured-namespace` in speconaut's own
# `truth/tasks/` — this recipe starts working the moment that lands, with
# no change needed here.
#
# Measured against a local, uncommitted workaround for the blocker above
# (reverted before commit — see `untraced-source-is-a-ratcheted-warning`):
# ~27s wall-clock for 96 scenarios, one PHPUnit boot per scenario. That is
# fast enough to join `just check` once the blocker clears; it is not
# joining today because it cannot pass today.
#
# Needs `tmpdir` for the same reason `check-drift` does: the PHP adapter
# spawns PHPUnit, which dies on a `$TMPDIR` that does not exist yet.
audit-traces: tmpdir
    speconaut audit-traces --adapter php-phpunit

# Run each examples/*/ profile through poagen; report pass / drift /
# expected-failure. Deliberately NOT wired into `just check` — broken
# examples are committed as targets for upcoming work (see T-024).
check-examples:
    #!/usr/bin/env bash
    set -uo pipefail
    fails=0
    stale=0
    for profile in examples/*/poagen.php; do
        dir=$(dirname "$profile")
        name=$(basename "$dir")
        if [[ -f "$dir/.expected-failure" ]]; then
            if php -d memory_limit=2G bin/poagen generate --dry-run "$profile" >/dev/null 2>&1; then
                echo "❌ $name: marked expected-failure but generator now succeeds"
                echo "   → delete $dir/.expected-failure and commit the generated/ tree"
                stale=$((stale + 1))
            else
                reason=$(head -n 1 "$dir/.expected-failure")
                echo "⚠️  $name: expected-failure — $reason"
                if [[ -d "$dir/generated" ]]; then
                    echo "❌ $name: expected-failure but generated/ is still committed"
                    echo "   → delete $dir/generated/ — it is stale output no current run reproduces"
                    stale=$((stale + 1))
                fi
            fi
        else
            if php -d memory_limit=4G bin/poagen generate --diff "$profile" > /tmp/poagen-examples-diff.$$ 2>&1; then
                echo "✅ $name: no drift"
            else
                echo "❌ $name: drift or error"
                cat /tmp/poagen-examples-diff.$$
                fails=$((fails + 1))
            fi
            rm -f /tmp/poagen-examples-diff.$$
        fi
    done
    if [[ $fails -gt 0 || $stale -gt 0 ]]; then
        echo ""
        echo "check-examples: $fails unexpected failure(s), $stale stale marker(s)"
        exit 1
    fi
    echo ""
    echo "check-examples: all examples in expected state"

# Gather the input for a decisions audit over a set of closed tasks.
#
# Deliberately NOT in `just check`, and not a gate of any kind: it reads,
# prints, and exits 0 whatever it finds. The human review gate this
# replaces died of being a queue nobody could service
# (review-gate-must-be-mechanical), so this one blocks nothing — it
# assembles what a reader needs and stops there.
#
# The brief is the input, not the audit. `truth/notes/decisions-audit-
# procedure.md` carries the rubric that turns one into the other, and
# `scripts/audit-decisions --help` points at it.
#
# The argument is an `mt` filter expression, so any view works:
# `just audit-decisions '@recent'`, or an explicit set. Note `mt`'s filter
# grammar has no field for the date a status was reached, so "everything
# closed on a given day" is not expressible as a filter — the 2026-08-01
# validation run derived its set from `mt ls @recent --format json` and
# passed it explicitly; the report records the command.
audit-decisions filter='@recent':
    scripts/audit-decisions '{{ filter }}'
