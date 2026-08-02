<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/DigitalOcean-public.v2.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\DigitalOcean',

    /*
     * clear-example-expected-failures: this profile does NOT clear the
     * `.expected-failure` marker. The four components with an undiscriminated
     * `config` property (`database_config`, `logsink_update`,
     * `autoscale_pool`, `autoscale_pool_create`) are deliberately left
     * unresolved — verified branch-by-branch against the vendored schema,
     * none shares a single field name across its branches, so no
     * `Profile::$discriminators` entry could be honest, and skipping the
     * whole component (the only granularity `DiscriminatorEnforcer` offers)
     * was tried and independently confirmed NOT to reach a passing tree
     * either — see `.expected-failure` for the full finding and why the
     * marker stays.
     *
     * What follows is real, verified progress on a separate, larger surface:
     * fifty operations this document could already not represent before
     * T-030 ever ran (an inline (non-$ref) JSON request body, or a
     * query/header parameter shape outside paogen's supported set). These
     * were silently dropped by the pre-`abort-on-unrepresentable-
     * constructs` generator (`examples/digitalocean/README.md`'s "Known
     * limitations" already named this gap under T-025/T-026); since that
     * task (and `default-deny-on-degradation`) unified every unrepresentable
     * construct into the same generator-time abort this profile already
     * refuses to weaken, they now block the run too and need the same
     * skip-list treatment `uploadFile` already gets in the petstore example.
     * Regenerated from `bin/paogen generate --dry-run`'s own diagnostic —
     * see `clear-example-expected-failures`'s Result section. Kept even
     * though the four discriminator components above still block the run,
     * because this part of the work is done and verified independently of
     * that blocker, and re-deriving it later would repeat real effort.
     */
    skip: [
        'addons_create' => 'application/json request body with an inline (non-$ref) schema',
        'apps_list_job_invocations' => 'parameter \'job_names\' (in: query, type: array) is outside paogen\'s supported parameter shapes',
        'volumeActions_post' => 'application/json request body with an inline (non-$ref) schema',
        'volumeActions_post_byId' => 'application/json request body with an inline (non-$ref) schema',
        'volumes_list' => 'parameter \'region\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'volumes_create' => 'application/json request body with an inline (non-$ref) schema',
        'volumes_delete_byName' => 'parameter \'region\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'volumeSnapshots_create' => 'application/json request body with an inline (non-$ref) schema',
        'certificates_create' => 'application/json request body with an inline (non-$ref) schema',
        'databases_create_cluster' => 'application/json request body with an inline (non-$ref) schema',
        'databases_update_cluster_metrics_credentials' => 'application/json request body with an inline (non-$ref) schema',
        'databases_create_logsink' => 'application/json request body with an inline (non-$ref) schema',
        'databases_create_replica' => 'application/json request body with an inline (non-$ref) schema',
        'databases_create_kafka_schema' => 'application/json request body with an inline (non-$ref) schema',
        'databases_create_kafka_topic' => 'application/json request body with an inline (non-$ref) schema',
        'databases_update_kafka_topic' => 'application/json request body with an inline (non-$ref) schema',
        'databases_add_user' => 'application/json request body with an inline (non-$ref) schema',
        'databases_update_user' => 'application/json request body with an inline (non-$ref) schema',
        'domains_create_record' => 'application/json request body with an inline (non-$ref) schema',
        'dropletActions_post_byTag' => 'application/json request body with an inline (non-$ref) schema',
        'dropletActions_post' => 'application/json request body with an inline (non-$ref) schema',
        'autoscalepools_delete_dangerous' => 'parameter \'X-Dangerous\' (in: header, type: boolean) is outside paogen\'s supported parameter shapes',
        'droplets_create' => 'application/json request body with an inline (non-$ref) schema',
        'droplets_destroy_withAssociatedResourcesDangerous' => 'parameter \'X-Dangerous\' (in: header, type: boolean) is outside paogen\'s supported parameter shapes',
        'firewalls_create' => 'application/json request body with an inline (non-$ref) schema',
        'firewalls_update' => 'application/json request body with an inline (non-$ref) schema',
        'firewalls_assign_droplets' => 'application/json request body with an inline (non-$ref) schema',
        'firewalls_delete_droplets' => 'application/json request body with an inline (non-$ref) schema',
        'firewalls_add_rules' => 'application/json request body with an inline (non-$ref) schema',
        'firewalls_delete_rules' => 'application/json request body with an inline (non-$ref) schema',
        'firewalls_add_tags' => 'application/json request body with an inline (non-$ref) schema',
        'firewalls_delete_tags' => 'application/json request body with an inline (non-$ref) schema',
        'floatingIPsAction_post' => 'application/json request body with an inline (non-$ref) schema',
        'imageActions_post' => 'application/json request body with an inline (non-$ref) schema',
        'kubernetes_recycle_node_pool' => 'application/json request body with an inline (non-$ref) schema',
        'kubernetes_upgrade_cluster' => 'application/json request body with an inline (non-$ref) schema',
        'loadBalancers_add_droplets' => 'application/json request body with an inline (non-$ref) schema',
        'loadBalancers_remove_droplets' => 'application/json request body with an inline (non-$ref) schema',
        'loadBalancers_add_forwardingRules' => 'application/json request body with an inline (non-$ref) schema',
        'loadBalancers_remove_forwardingRules' => 'application/json request body with an inline (non-$ref) schema',
        'monitoring_list_sinks' => 'parameter \'resource_id\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
        'monitoring_create_sink' => 'application/json request body with an inline (non-$ref) schema',
        'nfs_create_action' => 'application/json request body with an inline (non-$ref) schema',
        'projects_create' => 'application/json request body with an inline (non-$ref) schema',
        'projects_update_default' => 'application/json request body with an inline (non-$ref) schema',
        'projects_update' => 'application/json request body with an inline (non-$ref) schema',
        'reservedIPsActions_post' => 'application/json request body with an inline (non-$ref) schema',
        'reservedIPv6Actions_post' => 'application/json request body with an inline (non-$ref) schema',
        'vpcs_patch' => 'application/json request body with an inline (non-$ref) schema',
        'vpcPeerings_list' => 'parameter \'region\' (in: query, type: unspecified) is outside paogen\'s supported parameter shapes',
    ],
);
