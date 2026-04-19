<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookOrganizationMemberInvitedInvitation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'email' => ['email', null],
        'failed_at' => ['failed_at', ['datetime', null]],
        'failed_reason' => ['failed_reason', null],
        'id' => ['id', null],
        'invitation_teams_url' => ['invitation_teams_url', null],
        'inviter' => ['inviter', \Acme\GitHub\Generated\Model\WebhookOrganizationMemberInvitedInvitationInviter::class],
        'login' => ['login', null],
        'node_id' => ['node_id', null],
        'role' => ['role', null],
        'team_count' => ['team_count', null],
        'invitation_source' => ['invitation_source', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $email = null,
        public ?DateTimeImmutable $failed_at = null,
        public ?string $failed_reason = null,
        public float $id,
        public string $invitation_teams_url,
        public WebhookOrganizationMemberInvitedInvitationInviter $inviter,
        public ?string $login = null,
        public string $node_id,
        public string $role,
        public float $team_count,
        public ?string $invitation_source = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'email' => $this->email,
            'failed_at' => $this->failed_at?->format(\DateTimeInterface::RFC3339),
            'failed_reason' => $this->failed_reason,
            'id' => $this->id,
            'invitation_teams_url' => $this->invitation_teams_url,
            'inviter' => $this->inviter,
            'login' => $this->login,
            'node_id' => $this->node_id,
            'role' => $this->role,
            'team_count' => $this->team_count,
            'invitation_source' => $this->invitation_source,
        ];
    }
}
