<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/api.github.com.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\GitHub',
    // The GitHub REST schema declares ~918 components, 818 of which
    // use kebab-case names (`security-advisory-ecosystems`, etc.).
    // Enumerating every one here by hand is not a realistic user
    // experience, so this profile leaves `renames` empty and waits
    // for T-023's pluggable name-normalisation strategies.

    /*
     * declare-an-undiscriminated-union-as-raw-data: eleven property-level
     * unions across ten components used to block this document entirely, and
     * the `.expected-failure` marker that recorded them is gone. Eight of the
     * eleven now resolve with no guidance at all — paogen computes a
     * discriminating field from the branches themselves. That covers
     * `integration.owner`, `installation.account`,
     * `integration-installation-request.account`,
     * `nullable-integration.owner`, `copilot-seat-details.assigning_team` and
     * `secret-scanning-location.details`, plus `commit.author` and
     * `commit.committer`, whose `empty-object` branch is decided by the one
     * `additionalProperties: false` in this whole document: it accepts `{}`
     * and nothing else.
     *
     * The three below are the ones whose tag GitHub keeps on the enclosing
     * object rather than inside the value, which is exactly what
     * `$unionTags` is for. Every entry here is checked against the schema —
     * the component, the property, the tag field as a sibling, each branch as
     * a real branch of that union, and each tag value against the field's own
     * `enum` where it declares one.
     */
    unionTags: [
        /*
         * Sixteen branches on the sibling `event.type`. Nothing inside the
         * value could ever do this: `public-event` declares no properties at
         * all. `type` is required on `event` but declares no `enum`, so these
         * sixteen values are the one claim here the document cannot confirm
         * for us — they are GitHub's documented Events API type names, and a
         * value outside them raises at runtime rather than picking a branch.
         */
        'event.payload' => [
            'field' => 'type',
            'map' => [
                'CommitCommentEvent' => 'commit-comment-event',
                'CreateEvent' => 'create-event',
                'DeleteEvent' => 'delete-event',
                'DiscussionEvent' => 'discussion-event',
                'ForkEvent' => 'fork-event',
                'GollumEvent' => 'gollum-event',
                'IssueCommentEvent' => 'issue-comment-event',
                'IssuesEvent' => 'issues-event',
                'MemberEvent' => 'member-event',
                'PublicEvent' => 'public-event',
                'PullRequestEvent' => 'pull-request-event',
                'PullRequestReviewCommentEvent' => 'pull-request-review-comment-event',
                'PullRequestReviewEvent' => 'pull-request-review-event',
                'PushEvent' => 'push-event',
                'ReleaseEvent' => 'release-event',
                'WatchEvent' => 'watch-event',
            ],
        ],

        /*
         * `content_type` is required on the parent and enumerates exactly
         * these three values against exactly these three branches, so this
         * entry is fully checkable against the document. The structural rule
         * alone cannot do it: every field `projects-v2-draft-issue` requires
         * — id, node_id, title, user, created_at, updated_at — is also
         * declared by `issue`.
         */
        'projects-v2-item-simple.content' => [
            'field' => 'content_type',
            'map' => [
                'DraftIssue' => 'projects-v2-draft-issue',
                'Issue' => 'issue',
                'PullRequest' => 'pull-request-simple',
            ],
        ],

        /*
         * `source_type` enumerates three values against two branches, and
         * `Enterprise` is deliberately left unmapped: this document declares
         * no enterprise-level conditions component, so mapping it anywhere
         * would be inventing a claim the schema does not support. An
         * enterprise-sourced ruleset therefore raises rather than hydrating
         * as the wrong shape, and the run prints that third value on every
         * generation so the gap stays visible. Note `source_type` is not
         * required on the parent either, so a payload omitting it raises for
         * the same reason.
         */
        'repository-ruleset.conditions' => [
            'field' => 'source_type',
            'map' => [
                'Organization' => 'org-ruleset-conditions',
                'Repository' => 'repository-ruleset-conditions',
            ],
        ],
    ],

    /*
     * Thirty-nine operations this document could already not represent
     * before any of the union work: inline request bodies with no `allOf` to
     * merge, unsupported query-parameter shapes, and response schemas of
     * unrepresentable shape.
     *
     * It was forty-nine. `represent-non-json-request-and-response-bodies`
     * took six — five refused for their media type alone (`text/html`,
     * `text/plain` and `application/octocat-stream` responses, a
     * `text/plain, text/x-markdown` request body, an
     * `application/octet-stream` upload), and
     * `orgs/enable-or-disable-security-product-on-all-org-repos`, which had
     * gone stale on its own and generated cleanly already. Then
     * `a-response-of-scalars-has-no-return-shape` took three:
     * `gitignore/get-all-templates` and
     * `repos/get-all-status-check-contexts` return `items: {type: string}`,
     * `meta/get-all-versions` returns `{type: string, format: date}`, and
     * every list return shape resolved a model class and hydrated it, so an
     * array of scalars had no way to be said at all. `abort-on-unrepresentable-
     * constructs` and `default-deny-on-degradation` (both 2026-08-01)
     * unified every one of these into the same generator-time abort this
     * profile refuses to weaken, so they need the same skip-list treatment
     * `uploadFile` already gets in the petstore example. Regenerated from
     * `bin/paogen generate --dry-run`'s own diagnostic.
     *
     * `merge-allof-members-into-one-model` took the fortieth:
     * `apps/create-from-manifest`'s 201 response is `allOf: [$ref integration,
     * inline]` — two members, no collision, no `oneOf`/`anyOf` — and the merge
     * this task added resolves it to a synthesised `AppsCreateFromManifestResponse`
     * instead of refusing it as a response "of type 'unspecified'".
     *
     * `a-union-request-body-takes-a-union-parameter` took four more —
     * `actions/review-custom-gates-for-run` (an `anyOf` of two `$ref`s),
     * `codespaces/create-for-authenticated-user`, `projects/add-field-for-org`
     * and `projects/add-field-for-user` (each a `oneOf` of inline objects,
     * every branch synthesised into its own class) — and rewrote ten more in
     * place: the six `repos/*-status-check-contexts` /
     * `*-team-access-restrictions` operations, `issues/set-labels`,
     * `issues/add-labels`, and the two `users/*-email-for-authenticated-user`
     * ones all mix an object branch with a bare `array` or scalar branch
     * paogen cannot name a PHP class for, so they stay skipped — but for that
     * reason now, not the generic "inline schema" one every unresolved body
     * used to carry. Two operations this list never named —
     * `orgs/delete-attestations-bulk` and `users/delete-attestations-bulk` —
     * used to *silently widen* to `array $body`: `type: object` alongside a
     * two-branch `oneOf` read as an object with no declared properties, so
     * `RequestBodyAnalyzer` emitted a bare map and discarded the "either
     * subject_digests or attestation_ids" the document's prose already
     * promised. Both now emit the union instead.
     *
     * `support-the-parameter-shapes-real-documents-use` took the last
     * sixteen, all a query-parameter shape whose schema is a `$ref` or a
     * `oneOf`/`anyOf`: `state`, `tool_name` (three operations), `ref` (two),
     * `has` (three) and `ecosystem` resolve through a `$ref` the gate used
     * to refuse outright; `fields` (six) is a `oneOf` of a bare scalar and
     * an array of one, now the native union `string|array` plus a
     * `string|list<string>` annotation.
     *
     * `a-union-response-selects-its-branch` took eight more, every one of
     * them a response whose 200 is a `oneOf`/`anyOf` the analyser used to
     * see only as a schema "of type 'unspecified'". All eight resolve with
     * no profile guidance at all: `users/get-authenticated`,
     * `users/get-by-id` and `users/get-by-username` carry the document's
     * own `discriminator` — with an explicit `mapping` whose wire values
     * (`public`/`private`) are not either branch's class name, the one
     * reading no property-position union in this document has ever
     * exercised. `interactions/get-restrictions-for-*` anyOf a `$ref`
     * against an inline closed empty object, decided by the absence of
     * fields the same way `commit.author`'s `empty-object` branch already
     * is. `activity/list-stargazers-for-repo` and
     * `activity/list-repos-starred-by-user` anyOf two *array* shapes of
     * different `$ref` items — resolved as `list<SimpleUser|Stargazer>`
     * and `list<StarredRepository|Repository>` rather than as a union of
     * two list types, which cannot be written as a native PHP type at all.
     *
     * `a-media-type-with-no-schema-takes-a-raw-body` took the last one:
     * `repos/get-content`'s request body carries `examples` and no
     * `schema` key at all, which is not a schema paogen failed to
     * understand — the document declares nothing about the body's shape,
     * so it passes through untyped as `array<string, mixed>` rather than
     * refusing the operation.
     */
    skip: [
        // issues/set-labels and issues/add-labels: request body is a `oneOf`
        // whose branches mix an object with a bare `array` — `body` is
        // `array<string>` (a list of label names), which paogen cannot union
        // with a synthesised class. Branch 2 is named because it is the
        // first unnameable one found; issues/set-labels' 4th and 5th
        // branches (another array, then a scalar `string`) share the defect.
        'issues/set-labels' => 'request body branch 2 (oneOf/1) is a bare `array`, not a named class — paogen '
            . 'can only union branches it can express as a PHP class (a $ref to a component, or an inline object '
            . 'with declared properties); reduce this branch to one of those, or skip the operation',
        'issues/add-labels' => 'request body branch 2 (oneOf/1) is a bare `array`, not a named class — paogen '
            . 'can only union branches it can express as a PHP class (a $ref to a component, or an inline object '
            . 'with declared properties); reduce this branch to one of those, or skip the operation',
        // The six repos/*-status-check-contexts and *-team-access-restrictions
        // operations: request body is `oneOf: [inline object, {type: array,
        // items: string}]` (add/replace a list of contexts or team slugs by
        // name) — the same object-beside-a-bare-array defect as issues/*
        // above.
        'repos/set-status-check-contexts' => 'request body branch 2 (oneOf/1) is a bare `array`, not a named '
            . 'class — paogen can only union branches it can express as a PHP class (a $ref to a component, or an '
            . 'inline object with declared properties); reduce this branch to one of those, or skip the operation',
        'repos/add-status-check-contexts' => 'request body branch 2 (oneOf/1) is a bare `array`, not a named '
            . 'class — paogen can only union branches it can express as a PHP class (a $ref to a component, or an '
            . 'inline object with declared properties); reduce this branch to one of those, or skip the operation',
        'repos/remove-status-check-contexts' => 'request body branch 2 (oneOf/1) is a bare `array`, not a named '
            . 'class — paogen can only union branches it can express as a PHP class (a $ref to a component, or an '
            . 'inline object with declared properties); reduce this branch to one of those, or skip the operation',
        'repos/set-team-access-restrictions' => 'request body branch 2 (oneOf/1) is a bare `array`, not a named '
            . 'class — paogen can only union branches it can express as a PHP class (a $ref to a component, or an '
            . 'inline object with declared properties); reduce this branch to one of those, or skip the operation',
        'repos/add-team-access-restrictions' => 'request body branch 2 (oneOf/1) is a bare `array`, not a named '
            . 'class — paogen can only union branches it can express as a PHP class (a $ref to a component, or an '
            . 'inline object with declared properties); reduce this branch to one of those, or skip the operation',
        'repos/remove-team-access-restrictions' => 'request body branch 2 (oneOf/1) is a bare `array`, not a '
            . 'named class — paogen can only union branches it can express as a PHP class (a $ref to a component, '
            . 'or an inline object with declared properties); reduce this branch to one of those, or skip the operation',
        // users/add-email-for-authenticated-user and
        // users/delete-email-for-authenticated-user: request body is
        // `oneOf: [inline object, {type: array, items: string}, {type:
        // string}]` — three branches, and the first unnameable one is again
        // the bare array (the third, a bare `string`, has the same defect).
        'users/add-email-for-authenticated-user' => 'request body branch 2 (oneOf/1) is a bare `array`, not a '
            . 'named class — paogen can only union branches it can express as a PHP class (a $ref to a component, '
            . 'or an inline object with declared properties); reduce this branch to one of those, or skip the operation',
        'users/delete-email-for-authenticated-user' => 'request body branch 2 (oneOf/1) is a bare `array`, not a '
            . 'named class — paogen can only union branches it can express as a PHP class (a $ref to a component, '
            . 'or an inline object with declared properties); reduce this branch to one of those, or skip the operation',
    ],
);
