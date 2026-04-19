<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CommunityProfileFiles implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'code_of_conduct' => ['code_of_conduct', \Acme\GitHub\Generated\Model\NullableCodeOfConductSimple::class],
        'code_of_conduct_file' => ['code_of_conduct_file', \Acme\GitHub\Generated\Model\NullableCommunityHealthFile::class],
        'contributing' => ['contributing', \Acme\GitHub\Generated\Model\NullableCommunityHealthFile::class],
        'issue_template' => ['issue_template', \Acme\GitHub\Generated\Model\NullableCommunityHealthFile::class],
        'license' => ['license', \Acme\GitHub\Generated\Model\NullableLicenseSimple::class],
        'pull_request_template' => [
            'pull_request_template',
            \Acme\GitHub\Generated\Model\NullableCommunityHealthFile::class,
        ],
        'readme' => ['readme', \Acme\GitHub\Generated\Model\NullableCommunityHealthFile::class],
    ];

    public function __construct(
        public NullableCodeOfConductSimple $code_of_conduct,
        public NullableCommunityHealthFile $code_of_conduct_file,
        public NullableCommunityHealthFile $contributing,
        public NullableCommunityHealthFile $issue_template,
        public NullableLicenseSimple $license,
        public NullableCommunityHealthFile $pull_request_template,
        public NullableCommunityHealthFile $readme,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'code_of_conduct' => $this->code_of_conduct,
            'code_of_conduct_file' => $this->code_of_conduct_file,
            'contributing' => $this->contributing,
            'issue_template' => $this->issue_template,
            'license' => $this->license,
            'pull_request_template' => $this->pull_request_template,
            'readme' => $this->readme,
        ];
    }
}
