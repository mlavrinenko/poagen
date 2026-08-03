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
     */
    skip: [
        'actions/review-custom-gates-for-run' => 'application/json request body with an inline (non-$ref) schema',
        'activity/list-stargazers-for-repo' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'activity/list-repos-starred-by-user' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'campaigns/list-org-campaigns' => 'parameter \'state\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'code-scanning/list-alerts-for-org' => 'parameter \'tool_name\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'code-scanning/list-alerts-for-repo' => 'parameter \'tool_name\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'code-scanning/list-alert-instances' => 'parameter \'ref\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'code-scanning/list-recent-analyses' => 'parameter \'tool_name\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'codespaces/create-for-authenticated-user' => 'application/json request body with an inline (non-$ref) schema',
        'dependabot/list-alerts-for-enterprise' => 'parameter \'has\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'dependabot/list-alerts-for-org' => 'parameter \'has\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'dependabot/list-alerts-for-repo' => 'parameter \'has\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'interactions/get-restrictions-for-org' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'interactions/get-restrictions-for-repo' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'interactions/get-restrictions-for-authenticated-user' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'issues/set-labels' => 'application/json request body with an inline (non-$ref) schema',
        'issues/add-labels' => 'application/json request body with an inline (non-$ref) schema',
        'licenses/get-for-repo' => 'parameter \'ref\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/add-field-for-org' => 'application/json request body with an inline (non-$ref) schema',
        'projects/list-items-for-org' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/get-org-item' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/list-view-items-for-org' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/add-field-for-user' => 'application/json request body with an inline (non-$ref) schema',
        'projects/list-items-for-user' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/get-user-item' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/list-view-items-for-user' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'repos/set-status-check-contexts' => 'application/json request body with an inline (non-$ref) schema',
        'repos/add-status-check-contexts' => 'application/json request body with an inline (non-$ref) schema',
        'repos/remove-status-check-contexts' => 'application/json request body with an inline (non-$ref) schema',
        'repos/set-team-access-restrictions' => 'application/json request body with an inline (non-$ref) schema',
        'repos/add-team-access-restrictions' => 'application/json request body with an inline (non-$ref) schema',
        'repos/remove-team-access-restrictions' => 'application/json request body with an inline (non-$ref) schema',
        'repos/get-content' => 'application/json request body with an inline (non-$ref) schema',
        'security-advisories/list-global-advisories' =>'parameter \'ecosystem\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'users/get-authenticated' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'users/add-email-for-authenticated-user' => 'application/json request body with an inline (non-$ref) schema',
        'users/delete-email-for-authenticated-user' => 'application/json request body with an inline (non-$ref) schema',
        'users/get-by-id' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'users/get-by-username' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
    ],
);
