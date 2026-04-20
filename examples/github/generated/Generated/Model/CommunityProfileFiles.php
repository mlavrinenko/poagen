<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CommunityProfileFiles
{
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
}
