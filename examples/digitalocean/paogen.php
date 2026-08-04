<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/DigitalOcean-public.v2.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\DigitalOcean',

    /*
     * declare-an-undiscriminated-union-as-raw-data: two of the four
     * components with an undiscriminated `config` property now resolve with
     * no guidance at all — `autoscale_pool.config` and
     * `autoscale_pool_create.config` pick between their static and dynamic
     * branches on `target_number_instances` against `min_instances`, which
     * paogen computes from the branches themselves.
     *
     * The two below are the only unions in either large vendor document that
     * no rule can decide, and the pins are the layer-three answer. A pin is
     * an opt-out in the sense `skip-is-the-only-opt-out` means — it is the
     * one guidance key whose absence changes the exit status — so each
     * carries a written reason, each is stale-checked (delete it the day the
     * vendor makes the union decidable, or the run fails), and each is
     * reported on EVERY run rather than only the one that added it. That
     * last part matters here more than anywhere: these branches accept each
     * other's payloads, which is why they were undecidable, so a pinned
     * property hydrates a discarded branch's payload into the pinned class
     * with no error at all. That is worse than a skip, not milder.
     */
    unionPins: [
        /*
         * Seven engine-specific advanced-config branches (mysql, postgres,
         * redis, valkey, mongo, kafka, opensearch) and not one required field
         * between them — 35, 56, 11, 13, 5, 40 and 41 properties declared,
         * zero required. The enclosing `database_config` carries no sibling
         * tag either: `config` is its only property. Nothing in the document
         * could ever select a branch, so this narrows to the engine this
         * client actually talks to.
         */
        'database_config.config' => [
            'branch' => 'postgres_advanced_config',
            'reason' => 'the seven engine configs declare no required field at all and the parent has no sibling '
                . 'tag, so no payload could name a branch; this client only manages PostgreSQL clusters. Reading '
                . 'the config of any other engine through this property yields a PostgresAdvancedConfig carrying '
                . 'that engine\'s fields in its extras, silently.',
        ],

        /*
         * `elasticsearch_logsink` and `opensearch_logsink` are identical
         * field for field — five properties each, both requiring exactly
         * `url` and `index_prefix`. `rsyslog_logsink` and `datadog_logsink`
         * are individually decidable, but a union is only decidable when
         * every branch is, so the whole property needs this.
         */
        'logsink_update.config' => [
            'branch' => 'opensearch_logsink',
            'reason' => 'elasticsearch_logsink and opensearch_logsink are identical field for field, so no payload '
                . 'distinguishes them, and logsink_update declares no sibling tag. This client sends OpenSearch '
                . 'sinks. An rsyslog or datadog sink read back through this property hydrates as an '
                . 'OpensearchLogsink rather than raising.',
        ],
    ],

    /*
     * Twenty operations this document could already not represent before any
     * of the union work (an inline (non-$ref) JSON request body with no
     * `allOf` to merge, or a query/header parameter shape outside paogen's
     * supported set). These were silently dropped by the pre-`abort-on-
     * unrepresentable-constructs` generator (`examples/digitalocean/README.md`'s
     * "Known limitations" already named this gap under T-025/T-026); since
     * that task (and `default-deny-on-degradation`) unified every
     * unrepresentable construct into the same generator-time abort this
     * profile refuses to weaken, they now block the run too and need the
     * same skip-list treatment `uploadFile` already gets in the petstore
     * example. Regenerated from `bin/paogen generate --dry-run`'s own
     * diagnostic.
     *
     * `merge-allof-members-into-one-model` removed eighteen entries this list
     * used to carry — every one of them was an `allOf` node (`allOf: [$ref]`
     * plus a sibling `required`, `allOf: [$ref, inline]`, `allOf: [$ref,
     * $ref]`, or a member whose own target nests `allOf` again), and the
     * merge this task added now resolves all eighteen instead of refusing
     * them. `uptime_create_check` is new here for the opposite reason: it
     * used to *silently widen* to `array $body` — `RequestBodyAnalyzer` read
     * its `type: object` and, finding no properties of its own, emitted a
     * bare map — and the merge that fixed the widening surfaced a genuine
     * vendor defect underneath it, which the entry below names.
     *
     * `a-union-request-body-takes-a-union-parameter` removed thirteen more:
     * every one of them was a request body whose whole schema is a `oneOf`
     * (`certificates_create`, `droplets_create`, `dropletActions_post_byTag`)
     * or `anyOf` (the rest) of `$ref` branches. Each now emits one method
     * parameter typed as the native PHP union across the branches — no
     * branch selection needed outgoing, since the caller already holds a
     * concrete instance of one of them.
     *
     * `support-the-parameter-shapes-real-documents-use` removed the last
     * seven: `region` (three operations) and `resource_id` resolve through
     * a `$ref` the parameter-shape gate used to refuse outright; `job_names`
     * is a query array whose items are a `$ref` to a scalar component,
     * emitted as `list<Schema>`; and the two `X-Dangerous` operations are
     * a required header, now a required method argument instead of a
     * refusal.
     *
     * `typed-error-responses` adds two more, both a `200` declared through
     * `components.responses` — a `$ref` the old picked-2xx-only reading
     * skipped past silently, treating the operation as if it had no 2xx at
     * all and emitting `void`. Resolving every `$ref`'d response properly
     * surfaces the vendor's real content type instead: a PDF stream and a
     * YAML document, neither of which paogen decodes.
     */
    skip: [
        // The vendor's own defect, not paogen's: `check_updatable` (this
        // operation's sole allOf member) declares `name`, `type`, `target`,
        // `regions`, `enabled` — never `method` — yet the request body's own
        // `required` list demands it. No member anywhere in the merge
        // declares it, so the honest answer is to stop and say so rather
        // than emit a model that promises a field no branch supplies.
        'uptime_create_check' => 'allOf requires \'method\' but no member declares it as a property — members '
            . 'searched: #/components/schemas/check_updatable',
        // typed-error-responses: 200 is `#/components/responses/invoice_pdf`,
        // `application/pdf` — paogen sends a binary request body as a PSR-7
        // stream but does not yet return one.
        'invoices_get_pdfByUUID' => "200 response (components/responses/invoice_pdf) content type "
            . "'application/pdf' declares a binary body paogen does not yet return",
        // typed-error-responses: 200 is `#/components/responses/kubeconfig`,
        // `application/yaml` — paogen decodes JSON responses and text over a
        // `type: string` schema, not YAML.
        'kubernetes_get_kubeconfig' => "200 response (components/responses/kubeconfig) content type "
            . "'application/yaml' is not one paogen decodes",
    ],
);
