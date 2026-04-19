<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsForkPrWorkflowsPrivateReposRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'run_workflows_from_fork_pull_requests' => ['run_workflows_from_fork_pull_requests', null],
        'require_approval_for_fork_pr_workflows' => ['require_approval_for_fork_pr_workflows', null],
        'send_secrets_and_variables' => ['send_secrets_and_variables', null],
        'send_write_tokens_to_workflows' => ['send_write_tokens_to_workflows', null],
    ];

    public function __construct(
        public bool $run_workflows_from_fork_pull_requests,
        public ?bool $require_approval_for_fork_pr_workflows = null,
        public ?bool $send_secrets_and_variables = null,
        public ?bool $send_write_tokens_to_workflows = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'run_workflows_from_fork_pull_requests' => $this->run_workflows_from_fork_pull_requests,
            'require_approval_for_fork_pr_workflows' => $this->require_approval_for_fork_pr_workflows,
            'send_secrets_and_variables' => $this->send_secrets_and_variables,
            'send_write_tokens_to_workflows' => $this->send_write_tokens_to_workflows,
        ];
    }
}
