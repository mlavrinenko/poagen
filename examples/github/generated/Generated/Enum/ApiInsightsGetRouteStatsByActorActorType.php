<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ApiInsightsGetRouteStatsByActorActorType: string
{
    case Installation = 'installation';
    case ClassicPat = 'classic_pat';
    case FineGrainedPat = 'fine_grained_pat';
    case OauthApp = 'oauth_app';
    case GithubAppUserToServer = 'github_app_user_to_server';
}
