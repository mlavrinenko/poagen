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
     * clear-example-expected-failures: this profile does NOT clear the
     * `.expected-failure` marker. Ten components carrying eleven
     * polymorphic properties this document leaves undiscriminated
     * (`attribute-and-phpdoc-driven-serialization` / T-030) are deliberately
     * left unresolved — each was checked
     * branch-by-branch against the vendored schema for a field name common
     * to every branch, and none has one, so no `Profile::$discriminators`
     * entry could be honest. Skipping the ten components (the only
     * granularity `DiscriminatorEnforcer` offers) was tried and
     * independently confirmed NOT to reach a passing tree either — it
     * leaves 231 dangling class references across this deeply
     * cross-referential document. See `.expected-failure` for the full
     * finding and why the marker stays.
     *
     * What follows is real, verified progress on a separate, larger
     * surface: forty-nine operations this document could already not
     * represent before T-030 ever ran (inline request bodies, unsupported
     * query-parameter shapes, non-JSON response content types, response
     * schemas of unrepresentable shape). `abort-on-unrepresentable-
     * constructs` and `default-deny-on-degradation` (both 2026-08-01)
     * unified every one of these into the same generator-time abort this
     * profile already refuses to weaken, so they need the same skip-list
     * treatment `uploadFile` already gets in the petstore example.
     * Regenerated from `bin/paogen generate --dry-run`'s own diagnostic.
     * Kept even though the ten discriminator components above still block
     * the run, because this part of the work is done and verified
     * independently of that blocker, and re-deriving it later would repeat
     * real effort.
     */
    skip: [
        'actions/review-custom-gates-for-run' => 'application/json request body with an inline (non-$ref) schema',
        'activity/list-stargazers-for-repo' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'activity/list-repos-starred-by-user' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'apps/create-from-manifest' => '201 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'campaigns/list-org-campaigns' => 'parameter \'state\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'code-scanning/list-alerts-for-org' => 'parameter \'tool_name\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'code-scanning/list-alerts-for-repo' => 'parameter \'tool_name\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'code-scanning/list-alert-instances' => 'parameter \'ref\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'code-scanning/list-recent-analyses' => 'parameter \'tool_name\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'codespaces/create-for-authenticated-user' => 'application/json request body with an inline (non-$ref) schema',
        'dependabot/list-alerts-for-enterprise' => 'parameter \'has\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'dependabot/list-alerts-for-org' => 'parameter \'has\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'dependabot/list-alerts-for-repo' => 'parameter \'has\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'gitignore/get-all-templates' => '200 response is a JSON array whose items are an inline (non-$ref) schema',
        'interactions/get-restrictions-for-org' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'interactions/get-restrictions-for-repo' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'interactions/get-restrictions-for-authenticated-user' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'issues/set-labels' => 'application/json request body with an inline (non-$ref) schema',
        'issues/add-labels' => 'application/json request body with an inline (non-$ref) schema',
        'licenses/get-for-repo' => 'parameter \'ref\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'markdown/render' => '200 response content type(s) \'text/html\'',
        'markdown/render-raw' => 'request body content type(s) \'text/plain, text/x-markdown\'',
        'meta/get-octocat' => '200 response content type(s) \'application/octocat-stream\'',
        'meta/get-all-versions' => '200 response is a JSON array whose items are an inline (non-$ref) schema',
        'meta/get-zen' => '200 response content type(s) \'text/plain\'',
        'orgs/enable-or-disable-security-product-on-all-org-repos' => 'application/json request body with an inline (non-$ref) schema',
        'projects/add-field-for-org' => 'application/json request body with an inline (non-$ref) schema',
        'projects/list-items-for-org' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/get-org-item' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/list-view-items-for-org' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/add-field-for-user' => 'application/json request body with an inline (non-$ref) schema',
        'projects/list-items-for-user' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/get-user-item' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'projects/list-view-items-for-user' => 'parameter \'fields\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'repos/get-all-status-check-contexts' => '200 response is a JSON array whose items are an inline (non-$ref) schema',
        'repos/set-status-check-contexts' => 'application/json request body with an inline (non-$ref) schema',
        'repos/add-status-check-contexts' => 'application/json request body with an inline (non-$ref) schema',
        'repos/remove-status-check-contexts' => 'application/json request body with an inline (non-$ref) schema',
        'repos/set-team-access-restrictions' => 'application/json request body with an inline (non-$ref) schema',
        'repos/add-team-access-restrictions' => 'application/json request body with an inline (non-$ref) schema',
        'repos/remove-team-access-restrictions' => 'application/json request body with an inline (non-$ref) schema',
        'repos/get-content' => 'application/json request body with an inline (non-$ref) schema',
        'repos/upload-release-asset' => 'application/octet-stream request body',
        'security-advisories/list-global-advisories' => 'parameter \'ecosystem\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'users/get-authenticated' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'users/add-email-for-authenticated-user' => 'application/json request body with an inline (non-$ref) schema',
        'users/delete-email-for-authenticated-user' => 'application/json request body with an inline (non-$ref) schema',
        'users/get-by-id' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
        'users/get-by-username' => '200 response has an application/json schema of type \'unspecified\', which paogen cannot represent as a method return type',
    ],
);
