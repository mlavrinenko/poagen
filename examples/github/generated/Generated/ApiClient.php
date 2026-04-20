<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated;

use Acme\GitHub\Generated\Enum\ActionsGetActionsCacheListDirection;
use Acme\GitHub\Generated\Enum\ActionsGetActionsCacheListSort;
use Acme\GitHub\Generated\Enum\ActionsListJobsForWorkflowRunFilter;
use Acme\GitHub\Generated\Enum\ActionsListWorkflowRunArtifactsDirection;
use Acme\GitHub\Generated\Enum\ActionsListWorkflowRunsForRepoStatus;
use Acme\GitHub\Generated\Enum\ActionsListWorkflowRunsStatus;
use Acme\GitHub\Generated\Enum\ActivityListReposStarredByAuthenticatedUserDirection;
use Acme\GitHub\Generated\Enum\ActivityListReposStarredByAuthenticatedUserSort;
use Acme\GitHub\Generated\Enum\ActivityListReposStarredByUserDirection;
use Acme\GitHub\Generated\Enum\ActivityListReposStarredByUserSort;
use Acme\GitHub\Generated\Enum\ApiInsightsGetRouteStatsByActorActorType;
use Acme\GitHub\Generated\Enum\ApiInsightsGetRouteStatsByActorDirection;
use Acme\GitHub\Generated\Enum\ApiInsightsGetSubjectStatsDirection;
use Acme\GitHub\Generated\Enum\ApiInsightsGetSummaryStatsByActorActorType;
use Acme\GitHub\Generated\Enum\ApiInsightsGetTimeStatsByActorActorType;
use Acme\GitHub\Generated\Enum\ApiInsightsGetUserStatsDirection;
use Acme\GitHub\Generated\Enum\AppsListAccountsForPlanDirection;
use Acme\GitHub\Generated\Enum\AppsListAccountsForPlanSort;
use Acme\GitHub\Generated\Enum\AppsListAccountsForPlanStubbedDirection;
use Acme\GitHub\Generated\Enum\AppsListAccountsForPlanStubbedSort;
use Acme\GitHub\Generated\Enum\AppsListWebhookDeliveriesStatus;
use Acme\GitHub\Generated\Enum\BillingGetAllBudgetsOrgScope;
use Acme\GitHub\Generated\Enum\ChecksListForRefFilter;
use Acme\GitHub\Generated\Enum\ChecksListForRefStatus;
use Acme\GitHub\Generated\Enum\ChecksListForSuiteFilter;
use Acme\GitHub\Generated\Enum\ChecksListForSuiteStatus;
use Acme\GitHub\Generated\Enum\CodeSecurityGetConfigurationsForOrgTargetType;
use Acme\GitHub\Generated\Enum\IssuesListCommentsForRepoDirection;
use Acme\GitHub\Generated\Enum\IssuesListCommentsForRepoSort;
use Acme\GitHub\Generated\Enum\IssuesListDirection;
use Acme\GitHub\Generated\Enum\IssuesListFilter;
use Acme\GitHub\Generated\Enum\IssuesListForAuthenticatedUserDirection;
use Acme\GitHub\Generated\Enum\IssuesListForAuthenticatedUserFilter;
use Acme\GitHub\Generated\Enum\IssuesListForAuthenticatedUserSort;
use Acme\GitHub\Generated\Enum\IssuesListForAuthenticatedUserState;
use Acme\GitHub\Generated\Enum\IssuesListForOrgDirection;
use Acme\GitHub\Generated\Enum\IssuesListForOrgFilter;
use Acme\GitHub\Generated\Enum\IssuesListForOrgSort;
use Acme\GitHub\Generated\Enum\IssuesListForOrgState;
use Acme\GitHub\Generated\Enum\IssuesListForRepoDirection;
use Acme\GitHub\Generated\Enum\IssuesListForRepoSort;
use Acme\GitHub\Generated\Enum\IssuesListForRepoState;
use Acme\GitHub\Generated\Enum\IssuesListMilestonesDirection;
use Acme\GitHub\Generated\Enum\IssuesListMilestonesSort;
use Acme\GitHub\Generated\Enum\IssuesListMilestonesState;
use Acme\GitHub\Generated\Enum\IssuesListSort;
use Acme\GitHub\Generated\Enum\IssuesListState;
use Acme\GitHub\Generated\Enum\OrgsListMembersFilter;
use Acme\GitHub\Generated\Enum\OrgsListMembersRole;
use Acme\GitHub\Generated\Enum\OrgsListMembershipsForAuthenticatedUserState;
use Acme\GitHub\Generated\Enum\OrgsListOutsideCollaboratorsFilter;
use Acme\GitHub\Generated\Enum\OrgsListPatGrantRequestsDirection;
use Acme\GitHub\Generated\Enum\OrgsListPatGrantRequestsSort;
use Acme\GitHub\Generated\Enum\OrgsListPatGrantsDirection;
use Acme\GitHub\Generated\Enum\OrgsListPatGrantsSort;
use Acme\GitHub\Generated\Enum\OrgsListPendingInvitationsInvitationSource;
use Acme\GitHub\Generated\Enum\OrgsListPendingInvitationsRole;
use Acme\GitHub\Generated\Enum\OrgsListWebhookDeliveriesStatus;
use Acme\GitHub\Generated\Enum\PackagesDeletePackageForAuthenticatedUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesDeletePackageForOrgPackageType;
use Acme\GitHub\Generated\Enum\PackagesDeletePackageForUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesDeletePackageVersionForAuthenticatedUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesDeletePackageVersionForOrgPackageType;
use Acme\GitHub\Generated\Enum\PackagesDeletePackageVersionForUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetAllPackageVersionsForPackageOwnedByAuthenticatedUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetAllPackageVersionsForPackageOwnedByAuthenticatedUserState;
use Acme\GitHub\Generated\Enum\PackagesGetAllPackageVersionsForPackageOwnedByOrgPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetAllPackageVersionsForPackageOwnedByOrgState;
use Acme\GitHub\Generated\Enum\PackagesGetAllPackageVersionsForPackageOwnedByUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetPackageForAuthenticatedUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetPackageForOrganizationPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetPackageForUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetPackageVersionForAuthenticatedUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetPackageVersionForOrganizationPackageType;
use Acme\GitHub\Generated\Enum\PackagesGetPackageVersionForUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesListPackagesForAuthenticatedUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesListPackagesForAuthenticatedUserVisibility;
use Acme\GitHub\Generated\Enum\PackagesListPackagesForOrganizationPackageType;
use Acme\GitHub\Generated\Enum\PackagesListPackagesForOrganizationVisibility;
use Acme\GitHub\Generated\Enum\PackagesListPackagesForUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesListPackagesForUserVisibility;
use Acme\GitHub\Generated\Enum\PackagesRestorePackageForAuthenticatedUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesRestorePackageForOrgPackageType;
use Acme\GitHub\Generated\Enum\PackagesRestorePackageForUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesRestorePackageVersionForAuthenticatedUserPackageType;
use Acme\GitHub\Generated\Enum\PackagesRestorePackageVersionForOrgPackageType;
use Acme\GitHub\Generated\Enum\PackagesRestorePackageVersionForUserPackageType;
use Acme\GitHub\Generated\Enum\PullsListDirection;
use Acme\GitHub\Generated\Enum\PullsListReviewCommentsDirection;
use Acme\GitHub\Generated\Enum\PullsListReviewCommentsForRepoDirection;
use Acme\GitHub\Generated\Enum\PullsListReviewCommentsForRepoSort;
use Acme\GitHub\Generated\Enum\PullsListReviewCommentsSort;
use Acme\GitHub\Generated\Enum\PullsListSort;
use Acme\GitHub\Generated\Enum\PullsListState;
use Acme\GitHub\Generated\Enum\ReactionsListForCommitCommentContent;
use Acme\GitHub\Generated\Enum\ReactionsListForIssueCommentContent;
use Acme\GitHub\Generated\Enum\ReactionsListForIssueContent;
use Acme\GitHub\Generated\Enum\ReactionsListForPullRequestReviewCommentContent;
use Acme\GitHub\Generated\Enum\ReactionsListForReleaseContent;
use Acme\GitHub\Generated\Enum\ReposGetClonesPer;
use Acme\GitHub\Generated\Enum\ReposGetOrgRuleSuitesRuleSuiteResult;
use Acme\GitHub\Generated\Enum\ReposGetOrgRuleSuitesTimePeriod;
use Acme\GitHub\Generated\Enum\ReposGetRepoRuleSuitesRuleSuiteResult;
use Acme\GitHub\Generated\Enum\ReposGetRepoRuleSuitesTimePeriod;
use Acme\GitHub\Generated\Enum\ReposGetViewsPer;
use Acme\GitHub\Generated\Enum\ReposListActivitiesActivityType;
use Acme\GitHub\Generated\Enum\ReposListActivitiesDirection;
use Acme\GitHub\Generated\Enum\ReposListActivitiesTimePeriod;
use Acme\GitHub\Generated\Enum\ReposListCollaboratorsAffiliation;
use Acme\GitHub\Generated\Enum\ReposListCollaboratorsPermission;
use Acme\GitHub\Generated\Enum\ReposListForAuthenticatedUserDirection;
use Acme\GitHub\Generated\Enum\ReposListForAuthenticatedUserSort;
use Acme\GitHub\Generated\Enum\ReposListForAuthenticatedUserType;
use Acme\GitHub\Generated\Enum\ReposListForAuthenticatedUserVisibility;
use Acme\GitHub\Generated\Enum\ReposListForOrgDirection;
use Acme\GitHub\Generated\Enum\ReposListForOrgSort;
use Acme\GitHub\Generated\Enum\ReposListForOrgType;
use Acme\GitHub\Generated\Enum\ReposListForUserDirection;
use Acme\GitHub\Generated\Enum\ReposListForUserSort;
use Acme\GitHub\Generated\Enum\ReposListForUserType;
use Acme\GitHub\Generated\Enum\ReposListForksSort;
use Acme\GitHub\Generated\Enum\ReposListWebhookDeliveriesStatus;
use Acme\GitHub\Generated\Enum\SearchCodeOrder;
use Acme\GitHub\Generated\Enum\SearchCodeSort;
use Acme\GitHub\Generated\Enum\SearchCommitsOrder;
use Acme\GitHub\Generated\Enum\SearchCommitsSort;
use Acme\GitHub\Generated\Enum\SearchIssuesAndPullRequestsOrder;
use Acme\GitHub\Generated\Enum\SearchIssuesAndPullRequestsSearchType;
use Acme\GitHub\Generated\Enum\SearchIssuesAndPullRequestsSort;
use Acme\GitHub\Generated\Enum\SearchLabelsOrder;
use Acme\GitHub\Generated\Enum\SearchLabelsSort;
use Acme\GitHub\Generated\Enum\SearchReposOrder;
use Acme\GitHub\Generated\Enum\SearchReposSort;
use Acme\GitHub\Generated\Enum\SearchUsersOrder;
use Acme\GitHub\Generated\Enum\SearchUsersSort;
use Acme\GitHub\Generated\Enum\SecretScanningListAlertsForOrgDirection;
use Acme\GitHub\Generated\Enum\SecretScanningListAlertsForOrgSort;
use Acme\GitHub\Generated\Enum\SecretScanningListAlertsForOrgState;
use Acme\GitHub\Generated\Enum\SecretScanningListAlertsForRepoDirection;
use Acme\GitHub\Generated\Enum\SecretScanningListAlertsForRepoSort;
use Acme\GitHub\Generated\Enum\SecretScanningListAlertsForRepoState;
use Acme\GitHub\Generated\Enum\SecurityAdvisoriesListOrgRepositoryAdvisoriesDirection;
use Acme\GitHub\Generated\Enum\SecurityAdvisoriesListOrgRepositoryAdvisoriesSort;
use Acme\GitHub\Generated\Enum\SecurityAdvisoriesListOrgRepositoryAdvisoriesState;
use Acme\GitHub\Generated\Enum\SecurityAdvisoriesListRepositoryAdvisoriesDirection;
use Acme\GitHub\Generated\Enum\SecurityAdvisoriesListRepositoryAdvisoriesSort;
use Acme\GitHub\Generated\Enum\SecurityAdvisoriesListRepositoryAdvisoriesState;
use Acme\GitHub\Generated\Enum\TeamsListMembersInOrgRole;
use Acme\GitHub\Generated\Enum\TeamsListMembersLegacyRole;
use Acme\GitHub\Generated\Enum\TeamsListTeamType;
use Acme\GitHub\Generated\Enum\UsersGetContextForUserSubjectType;
use Acme\GitHub\Generated\Model\ActionsArtifactAndLogRetention;
use Acme\GitHub\Generated\Model\ActionsArtifactAndLogRetentionResponse;
use Acme\GitHub\Generated\Model\ActionsCacheList;
use Acme\GitHub\Generated\Model\ActionsCacheRetentionLimitForEnterprise;
use Acme\GitHub\Generated\Model\ActionsCacheRetentionLimitForOrganization;
use Acme\GitHub\Generated\Model\ActionsCacheRetentionLimitForRepository;
use Acme\GitHub\Generated\Model\ActionsCacheStorageLimitForEnterprise;
use Acme\GitHub\Generated\Model\ActionsCacheStorageLimitForOrganization;
use Acme\GitHub\Generated\Model\ActionsCacheStorageLimitForRepository;
use Acme\GitHub\Generated\Model\ActionsCacheUsageByRepository;
use Acme\GitHub\Generated\Model\ActionsCacheUsageOrgEnterprise;
use Acme\GitHub\Generated\Model\ActionsForkPrContributorApproval;
use Acme\GitHub\Generated\Model\ActionsForkPrWorkflowsPrivateRepos;
use Acme\GitHub\Generated\Model\ActionsForkPrWorkflowsPrivateReposRequest;
use Acme\GitHub\Generated\Model\ActionsGetDefaultWorkflowPermissions;
use Acme\GitHub\Generated\Model\ActionsHostedRunner;
use Acme\GitHub\Generated\Model\ActionsHostedRunnerCustomImage;
use Acme\GitHub\Generated\Model\ActionsHostedRunnerCustomImageVersion;
use Acme\GitHub\Generated\Model\ActionsHostedRunnerLimits;
use Acme\GitHub\Generated\Model\ActionsOrganizationPermissions;
use Acme\GitHub\Generated\Model\ActionsPublicKey;
use Acme\GitHub\Generated\Model\ActionsRepositoryPermissions;
use Acme\GitHub\Generated\Model\ActionsSecret;
use Acme\GitHub\Generated\Model\ActionsSetDefaultWorkflowPermissions;
use Acme\GitHub\Generated\Model\ActionsVariable;
use Acme\GitHub\Generated\Model\ActionsWorkflowAccessToRepository;
use Acme\GitHub\Generated\Model\Activity;
use Acme\GitHub\Generated\Model\AlertNumber;
use Acme\GitHub\Generated\Model\ApiInsightsRouteStats;
use Acme\GitHub\Generated\Model\ApiInsightsSubjectStats;
use Acme\GitHub\Generated\Model\ApiInsightsSummaryStats;
use Acme\GitHub\Generated\Model\ApiInsightsTimeStats;
use Acme\GitHub\Generated\Model\ApiInsightsUserStats;
use Acme\GitHub\Generated\Model\ApiOverview;
use Acme\GitHub\Generated\Model\Artifact;
use Acme\GitHub\Generated\Model\AuthenticationToken;
use Acme\GitHub\Generated\Model\Autolink;
use Acme\GitHub\Generated\Model\BaseGist;
use Acme\GitHub\Generated\Model\Blob;
use Acme\GitHub\Generated\Model\BranchProtection;
use Acme\GitHub\Generated\Model\BranchRestrictionPolicy;
use Acme\GitHub\Generated\Model\BranchShort;
use Acme\GitHub\Generated\Model\BranchWithProtection;
use Acme\GitHub\Generated\Model\CampaignSummary;
use Acme\GitHub\Generated\Model\CheckAnnotation;
use Acme\GitHub\Generated\Model\CheckAutomatedSecurityFixes;
use Acme\GitHub\Generated\Model\CheckImmutableReleases;
use Acme\GitHub\Generated\Model\CheckRun;
use Acme\GitHub\Generated\Model\CheckSuite;
use Acme\GitHub\Generated\Model\Classroom;
use Acme\GitHub\Generated\Model\ClassroomAcceptedAssignment;
use Acme\GitHub\Generated\Model\ClassroomAssignment;
use Acme\GitHub\Generated\Model\ClassroomAssignmentGrade;
use Acme\GitHub\Generated\Model\CloneTraffic;
use Acme\GitHub\Generated\Model\CodeFrequencyStat;
use Acme\GitHub\Generated\Model\CodeOfConduct;
use Acme\GitHub\Generated\Model\CodeScanningAlert;
use Acme\GitHub\Generated\Model\CodeScanningAnalysis;
use Acme\GitHub\Generated\Model\CodeScanningAnalysisDeletion;
use Acme\GitHub\Generated\Model\CodeScanningAutofix;
use Acme\GitHub\Generated\Model\CodeScanningAutofixCommits;
use Acme\GitHub\Generated\Model\CodeScanningAutofixCommitsResponse;
use Acme\GitHub\Generated\Model\CodeScanningCodeqlDatabase;
use Acme\GitHub\Generated\Model\CodeScanningDefaultSetup;
use Acme\GitHub\Generated\Model\CodeScanningDefaultSetupUpdate;
use Acme\GitHub\Generated\Model\CodeScanningSarifsStatus;
use Acme\GitHub\Generated\Model\CodeScanningVariantAnalysis;
use Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisRepoTask;
use Acme\GitHub\Generated\Model\CodeSecurityConfiguration;
use Acme\GitHub\Generated\Model\CodeSecurityConfigurationForRepository;
use Acme\GitHub\Generated\Model\CodeSecurityConfigurationRepositories;
use Acme\GitHub\Generated\Model\CodeSecurityDefaultConfigurations;
use Acme\GitHub\Generated\Model\CodeownersErrors;
use Acme\GitHub\Generated\Model\Codespace;
use Acme\GitHub\Generated\Model\CodespaceExportDetails;
use Acme\GitHub\Generated\Model\CodespacesOrgSecret;
use Acme\GitHub\Generated\Model\CodespacesPermissionsCheckForDevcontainer;
use Acme\GitHub\Generated\Model\CodespacesPublicKey;
use Acme\GitHub\Generated\Model\CodespacesSecret;
use Acme\GitHub\Generated\Model\CodespacesUserPublicKey;
use Acme\GitHub\Generated\Model\Collaborator;
use Acme\GitHub\Generated\Model\CombinedCommitStatus;
use Acme\GitHub\Generated\Model\Commit;
use Acme\GitHub\Generated\Model\CommitActivity;
use Acme\GitHub\Generated\Model\CommitComment;
use Acme\GitHub\Generated\Model\CommitComparison;
use Acme\GitHub\Generated\Model\CommunityProfile;
use Acme\GitHub\Generated\Model\ContentFile;
use Acme\GitHub\Generated\Model\ContentTraffic;
use Acme\GitHub\Generated\Model\Contributor;
use Acme\GitHub\Generated\Model\ContributorActivity;
use Acme\GitHub\Generated\Model\CopilotOrganizationContentExclusionDetails;
use Acme\GitHub\Generated\Model\CopilotOrganizationDetails;
use Acme\GitHub\Generated\Model\CopilotSeatDetails;
use Acme\GitHub\Generated\Model\CopilotUsageMetrics1DayReport;
use Acme\GitHub\Generated\Model\CopilotUsageMetrics28DayReport;
use Acme\GitHub\Generated\Model\CopilotUsageMetricsDay;
use Acme\GitHub\Generated\Model\CustomProperty;
use Acme\GitHub\Generated\Model\CustomPropertySetPayload;
use Acme\GitHub\Generated\Model\CustomPropertyValue;
use Acme\GitHub\Generated\Model\DependabotAlert;
use Acme\GitHub\Generated\Model\DependabotPublicKey;
use Acme\GitHub\Generated\Model\DependabotRepositoryAccessDetails;
use Acme\GitHub\Generated\Model\DependabotSecret;
use Acme\GitHub\Generated\Model\DependencyGraphDiff;
use Acme\GitHub\Generated\Model\DependencyGraphSpdxSbom;
use Acme\GitHub\Generated\Model\DeployKey;
use Acme\GitHub\Generated\Model\Deployment;
use Acme\GitHub\Generated\Model\DeploymentBranchPolicy;
use Acme\GitHub\Generated\Model\DeploymentBranchPolicyNamePattern;
use Acme\GitHub\Generated\Model\DeploymentBranchPolicyNamePatternWithType;
use Acme\GitHub\Generated\Model\DeploymentProtectionRule;
use Acme\GitHub\Generated\Model\DeploymentStatus;
use Acme\GitHub\Generated\Model\DiffEntry;
use Acme\GitHub\Generated\Model\Email;
use Acme\GitHub\Generated\Model\EmptyObject;
use Acme\GitHub\Generated\Model\EnterpriseTeam;
use Acme\GitHub\Generated\Model\Environment;
use Acme\GitHub\Generated\Model\EnvironmentApprovals;
use Acme\GitHub\Generated\Model\Event;
use Acme\GitHub\Generated\Model\Feed;
use Acme\GitHub\Generated\Model\FullRepository;
use Acme\GitHub\Generated\Model\GistComment;
use Acme\GitHub\Generated\Model\GistCommit;
use Acme\GitHub\Generated\Model\GistSimple;
use Acme\GitHub\Generated\Model\GitCommit;
use Acme\GitHub\Generated\Model\GitRef;
use Acme\GitHub\Generated\Model\GitTag;
use Acme\GitHub\Generated\Model\GitTree;
use Acme\GitHub\Generated\Model\GitignoreTemplate;
use Acme\GitHub\Generated\Model\GlobalAdvisory;
use Acme\GitHub\Generated\Model\GpgKey;
use Acme\GitHub\Generated\Model\Hook;
use Acme\GitHub\Generated\Model\HookDelivery;
use Acme\GitHub\Generated\Model\HookDeliveryItem;
use Acme\GitHub\Generated\Model\Hovercard;
use Acme\GitHub\Generated\Model\ImmutableReleasesOrganizationSettings;
use Acme\GitHub\Generated\Model\Import;
use Acme\GitHub\Generated\Model\Installation;
use Acme\GitHub\Generated\Model\Integration;
use Acme\GitHub\Generated\Model\IntegrationInstallationRequest;
use Acme\GitHub\Generated\Model\InteractionLimit;
use Acme\GitHub\Generated\Model\InteractionLimitResponse;
use Acme\GitHub\Generated\Model\Issue;
use Acme\GitHub\Generated\Model\IssueComment;
use Acme\GitHub\Generated\Model\IssueEvent;
use Acme\GitHub\Generated\Model\IssueEventForIssue;
use Acme\GitHub\Generated\Model\IssueField;
use Acme\GitHub\Generated\Model\IssueFieldValue;
use Acme\GitHub\Generated\Model\IssueType;
use Acme\GitHub\Generated\Model\Job;
use Acme\GitHub\Generated\Model\Key;
use Acme\GitHub\Generated\Model\KeySimple;
use Acme\GitHub\Generated\Model\Label;
use Acme\GitHub\Generated\Model\Language;
use Acme\GitHub\Generated\Model\License;
use Acme\GitHub\Generated\Model\LicenseSimple;
use Acme\GitHub\Generated\Model\MarketplaceListingPlan;
use Acme\GitHub\Generated\Model\MarketplacePurchase;
use Acme\GitHub\Generated\Model\Migration;
use Acme\GitHub\Generated\Model\Milestone;
use Acme\GitHub\Generated\Model\MinimalRepository;
use Acme\GitHub\Generated\Model\NetworkConfiguration;
use Acme\GitHub\Generated\Model\NetworkSettings;
use Acme\GitHub\Generated\Model\OidcCustomPropertyInclusion;
use Acme\GitHub\Generated\Model\OidcCustomPropertyInclusionInput;
use Acme\GitHub\Generated\Model\OidcCustomSub;
use Acme\GitHub\Generated\Model\OidcCustomSubRepo;
use Acme\GitHub\Generated\Model\OrgHook;
use Acme\GitHub\Generated\Model\OrgMembership;
use Acme\GitHub\Generated\Model\OrgPrivateRegistryConfiguration;
use Acme\GitHub\Generated\Model\OrgRepoCustomPropertyValues;
use Acme\GitHub\Generated\Model\OrganizationActionsSecret;
use Acme\GitHub\Generated\Model\OrganizationActionsVariable;
use Acme\GitHub\Generated\Model\OrganizationCreateIssueField;
use Acme\GitHub\Generated\Model\OrganizationCreateIssueType;
use Acme\GitHub\Generated\Model\OrganizationDependabotSecret;
use Acme\GitHub\Generated\Model\OrganizationFull;
use Acme\GitHub\Generated\Model\OrganizationInvitation;
use Acme\GitHub\Generated\Model\OrganizationProgrammaticAccessGrant;
use Acme\GitHub\Generated\Model\OrganizationProgrammaticAccessGrantRequest;
use Acme\GitHub\Generated\Model\OrganizationRole;
use Acme\GitHub\Generated\Model\OrganizationSecretScanningAlert;
use Acme\GitHub\Generated\Model\OrganizationSimple;
use Acme\GitHub\Generated\Model\OrganizationUpdateIssueField;
use Acme\GitHub\Generated\Model\OrganizationUpdateIssueType;
use Acme\GitHub\Generated\Model\Package;
use Acme\GitHub\Generated\Model\PackageVersion;
use Acme\GitHub\Generated\Model\Page;
use Acme\GitHub\Generated\Model\PageBuild;
use Acme\GitHub\Generated\Model\PageBuildStatus;
use Acme\GitHub\Generated\Model\PagesDeploymentStatus;
use Acme\GitHub\Generated\Model\PagesHealthCheck;
use Acme\GitHub\Generated\Model\ParticipationStats;
use Acme\GitHub\Generated\Model\PendingDeployment;
use Acme\GitHub\Generated\Model\PorterAuthor;
use Acme\GitHub\Generated\Model\PorterLargeFile;
use Acme\GitHub\Generated\Model\PrivateVulnerabilityReportCreate;
use Acme\GitHub\Generated\Model\ProjectsV2;
use Acme\GitHub\Generated\Model\ProjectsV2Field;
use Acme\GitHub\Generated\Model\ProtectedBranchAdminEnforced;
use Acme\GitHub\Generated\Model\ProtectedBranchPullRequestReview;
use Acme\GitHub\Generated\Model\PullRequest;
use Acme\GitHub\Generated\Model\PullRequestReview;
use Acme\GitHub\Generated\Model\PullRequestReviewComment;
use Acme\GitHub\Generated\Model\PullRequestReviewRequest;
use Acme\GitHub\Generated\Model\PullRequestSimple;
use Acme\GitHub\Generated\Model\RateLimitOverview;
use Acme\GitHub\Generated\Model\Reaction;
use Acme\GitHub\Generated\Model\ReferrerTraffic;
use Acme\GitHub\Generated\Model\Release;
use Acme\GitHub\Generated\Model\ReleaseAsset;
use Acme\GitHub\Generated\Model\RepoCodespacesSecret;
use Acme\GitHub\Generated\Model\Repository;
use Acme\GitHub\Generated\Model\RepositoryAdvisory;
use Acme\GitHub\Generated\Model\RepositoryAdvisoryCreate;
use Acme\GitHub\Generated\Model\RepositoryAdvisoryUpdate;
use Acme\GitHub\Generated\Model\RepositoryCollaboratorPermission;
use Acme\GitHub\Generated\Model\RepositoryInvitation;
use Acme\GitHub\Generated\Model\RepositoryRuleDetailed;
use Acme\GitHub\Generated\Model\RepositoryRuleset;
use Acme\GitHub\Generated\Model\RepositorySubscription;
use Acme\GitHub\Generated\Model\ReviewComment;
use Acme\GitHub\Generated\Model\Root;
use Acme\GitHub\Generated\Model\RuleSuite;
use Acme\GitHub\Generated\Model\RuleSuites;
use Acme\GitHub\Generated\Model\RulesetVersion;
use Acme\GitHub\Generated\Model\RulesetVersionWithState;
use Acme\GitHub\Generated\Model\Runner;
use Acme\GitHub\Generated\Model\RunnerApplication;
use Acme\GitHub\Generated\Model\RunnerGroupsOrg;
use Acme\GitHub\Generated\Model\SecretScanningAlert;
use Acme\GitHub\Generated\Model\SecretScanningLocation;
use Acme\GitHub\Generated\Model\SecretScanningPatternConfiguration;
use Acme\GitHub\Generated\Model\SecretScanningScanHistory;
use Acme\GitHub\Generated\Model\SelectedActions;
use Acme\GitHub\Generated\Model\SelfHostedRunnersSettings;
use Acme\GitHub\Generated\Model\ShortBranch;
use Acme\GitHub\Generated\Model\SimpleClassroom;
use Acme\GitHub\Generated\Model\SimpleClassroomAssignment;
use Acme\GitHub\Generated\Model\SimpleUser;
use Acme\GitHub\Generated\Model\Snapshot;
use Acme\GitHub\Generated\Model\SocialAccount;
use Acme\GitHub\Generated\Model\SshSigningKey;
use Acme\GitHub\Generated\Model\Status;
use Acme\GitHub\Generated\Model\StatusCheckPolicy;
use Acme\GitHub\Generated\Model\Tag;
use Acme\GitHub\Generated\Model\Team;
use Acme\GitHub\Generated\Model\TeamFull;
use Acme\GitHub\Generated\Model\TeamMembership;
use Acme\GitHub\Generated\Model\TeamRepository;
use Acme\GitHub\Generated\Model\TeamRoleAssignment;
use Acme\GitHub\Generated\Model\TeamSimple;
use Acme\GitHub\Generated\Model\Thread;
use Acme\GitHub\Generated\Model\ThreadSubscription;
use Acme\GitHub\Generated\Model\TimelineIssueEvents;
use Acme\GitHub\Generated\Model\Topic;
use Acme\GitHub\Generated\Model\UserMarketplacePurchase;
use Acme\GitHub\Generated\Model\UserRoleAssignment;
use Acme\GitHub\Generated\Model\ViewTraffic;
use Acme\GitHub\Generated\Model\WebhookConfig;
use Acme\GitHub\Generated\Model\Workflow;
use Acme\GitHub\Generated\Model\WorkflowRun;
use Acme\GitHub\Generated\Model\WorkflowRunUsage;
use Acme\GitHub\Generated\Model\WorkflowUsage;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class ApiClient
{
    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private string $baseUri,
        private Hydrator $hydrator = new Hydrator(),
        private Marshaller $marshaller = new Marshaller(),
    ) {
    }

    public function metaRoot(): Root
    {
        $path = '/';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Root::class, $data);
    }

    public function securityAdvisoriesGetGlobalAdvisory(string $ghsa_id): GlobalAdvisory
    {
        $path = '/advisories/{ghsa_id}';
        $path = \str_replace('{ghsa_id}', $ghsa_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GlobalAdvisory::class, $data);
    }

    public function appsGetAuthenticated(): Integration
    {
        $path = '/app';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Integration::class, $data);
    }

    public function appsCreateFromManifest(string $code): void
    {
        $path = '/app-manifests/{code}/conversions';
        $path = \str_replace('{code}', $code, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsGetWebhookConfigForApp(): WebhookConfig
    {
        $path = '/app/hook/config';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(WebhookConfig::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\HookDeliveryItem>
     */
    public function appsListWebhookDeliveries(
        ?int $per_page = null,
        ?string $cursor = null,
        ?AppsListWebhookDeliveriesStatus $status = null,
    ): array {
        $path = '/app/hook/deliveries';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($cursor !== null) {
            $query[] = 'cursor=' . \urlencode($cursor);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): HookDeliveryItem => $this->hydrator->hydrate(HookDeliveryItem::class, (array) $item),
            $data,
        ));
    }

    public function appsGetWebhookDelivery(int $delivery_id): HookDelivery
    {
        $path = '/app/hook/deliveries/{delivery_id}';
        $path = \str_replace('{delivery_id}', (string) $delivery_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(HookDelivery::class, $data);
    }

    public function appsRedeliverWebhookDelivery(int $delivery_id): void
    {
        $path = '/app/hook/deliveries/{delivery_id}/attempts';
        $path = \str_replace('{delivery_id}', (string) $delivery_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\IntegrationInstallationRequest>
     */
    public function appsListInstallationRequestsForAuthenticatedApp(?int $per_page = null, ?int $page = null): array
    {
        $path = '/app/installation-requests';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): IntegrationInstallationRequest => $this->hydrator->hydrate(IntegrationInstallationRequest::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Installation>
     */
    public function appsListInstallations(
        ?int $per_page = null,
        ?int $page = null,
        ?\DateTimeImmutable $since = null,
        ?string $outdated = null,
    ): array {
        $path = '/app/installations';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($outdated !== null) {
            $query[] = 'outdated=' . \urlencode($outdated);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Installation => $this->hydrator->hydrate(Installation::class, (array) $item),
            $data,
        ));
    }

    public function appsGetInstallation(int $installation_id): Installation
    {
        $path = '/app/installations/{installation_id}';
        $path = \str_replace('{installation_id}', (string) $installation_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Installation::class, $data);
    }

    public function appsDeleteInstallation(int $installation_id): void
    {
        $path = '/app/installations/{installation_id}';
        $path = \str_replace('{installation_id}', (string) $installation_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsSuspendInstallation(int $installation_id): void
    {
        $path = '/app/installations/{installation_id}/suspended';
        $path = \str_replace('{installation_id}', (string) $installation_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsUnsuspendInstallation(int $installation_id): void
    {
        $path = '/app/installations/{installation_id}/suspended';
        $path = \str_replace('{installation_id}', (string) $installation_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsGetBySlug(string $app_slug): Integration
    {
        $path = '/apps/{app_slug}';
        $path = \str_replace('{app_slug}', $app_slug, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Integration::class, $data);
    }

    public function classroomGetAnAssignment(int $assignment_id): ClassroomAssignment
    {
        $path = '/assignments/{assignment_id}';
        $path = \str_replace('{assignment_id}', (string) $assignment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ClassroomAssignment::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ClassroomAcceptedAssignment>
     */
    public function classroomListAcceptedAssignmentsForAnAssignment(
        int $assignment_id,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/assignments/{assignment_id}/accepted_assignments';
        $path = \str_replace('{assignment_id}', (string) $assignment_id, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ClassroomAcceptedAssignment => $this->hydrator->hydrate(ClassroomAcceptedAssignment::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ClassroomAssignmentGrade>
     */
    public function classroomGetAssignmentGrades(int $assignment_id): array
    {
        $path = '/assignments/{assignment_id}/grades';
        $path = \str_replace('{assignment_id}', (string) $assignment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ClassroomAssignmentGrade => $this->hydrator->hydrate(ClassroomAssignmentGrade::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleClassroom>
     */
    public function classroomListClassrooms(?int $page = null, ?int $per_page = null): array
    {
        $path = '/classrooms';
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleClassroom => $this->hydrator->hydrate(SimpleClassroom::class, (array) $item),
            $data,
        ));
    }

    public function classroomGetAClassroom(int $classroom_id): Classroom
    {
        $path = '/classrooms/{classroom_id}';
        $path = \str_replace('{classroom_id}', (string) $classroom_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Classroom::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleClassroomAssignment>
     */
    public function classroomListAssignmentsForAClassroom(
        int $classroom_id,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/classrooms/{classroom_id}/assignments';
        $path = \str_replace('{classroom_id}', (string) $classroom_id, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleClassroomAssignment => $this->hydrator->hydrate(SimpleClassroomAssignment::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CodeOfConduct>
     */
    public function codesOfConductGetAllCodesOfConduct(): array
    {
        $path = '/codes_of_conduct';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CodeOfConduct => $this->hydrator->hydrate(CodeOfConduct::class, (array) $item),
            $data,
        ));
    }

    public function codesOfConductGetConductCode(string $key): CodeOfConduct
    {
        $path = '/codes_of_conduct/{key}';
        $path = \str_replace('{key}', $key, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeOfConduct::class, $data);
    }

    /**
     * @return array<string, string>
     */
    public function emojisGet(): array
    {
        $path = '/emojis';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var array<string, string> $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return $data;
    }

    public function actionsGetActionsCacheRetentionLimitForEnterprise(
        string $enterprise,
    ): ActionsCacheRetentionLimitForEnterprise {
        $path = '/enterprises/{enterprise}/actions/cache/retention-limit';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheRetentionLimitForEnterprise::class, $data);
    }

    public function actionsSetActionsCacheRetentionLimitForEnterprise(
        string $enterprise,
        ActionsCacheRetentionLimitForEnterprise $body,
    ): void {
        $path = '/enterprises/{enterprise}/actions/cache/retention-limit';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetActionsCacheStorageLimitForEnterprise(
        string $enterprise,
    ): ActionsCacheStorageLimitForEnterprise {
        $path = '/enterprises/{enterprise}/actions/cache/storage-limit';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheStorageLimitForEnterprise::class, $data);
    }

    public function actionsSetActionsCacheStorageLimitForEnterprise(
        string $enterprise,
        ActionsCacheStorageLimitForEnterprise $body,
    ): void {
        $path = '/enterprises/{enterprise}/actions/cache/storage-limit';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OidcCustomPropertyInclusion>
     */
    public function oidcListOidcCustomPropertyInclusionsForEnterprise(string $enterprise): array
    {
        $path = '/enterprises/{enterprise}/actions/oidc/customization/properties/repo';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OidcCustomPropertyInclusion => $this->hydrator->hydrate(OidcCustomPropertyInclusion::class, (array) $item),
            $data,
        ));
    }

    public function oidcCreateOidcCustomPropertyInclusionForEnterprise(
        string $enterprise,
        OidcCustomPropertyInclusionInput $body,
    ): OidcCustomPropertyInclusion {
        $path = '/enterprises/{enterprise}/actions/oidc/customization/properties/repo';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OidcCustomPropertyInclusion::class, $data);
    }

    public function oidcDeleteOidcCustomPropertyInclusionForEnterprise(
        string $enterprise,
        string $custom_property_name,
    ): void {
        $path = '/enterprises/{enterprise}/actions/oidc/customization/properties/repo/{custom_property_name}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{custom_property_name}', $custom_property_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CodeSecurityConfiguration>
     */
    public function codeSecurityGetConfigurationsForEnterprise(
        string $enterprise,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
    ): array {
        $path = '/enterprises/{enterprise}/code-security/configurations';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CodeSecurityConfiguration => $this->hydrator->hydrate(CodeSecurityConfiguration::class, (array) $item),
            $data,
        ));
    }

    public function codeSecurityGetDefaultConfigurationsForEnterprise(
        string $enterprise,
    ): CodeSecurityDefaultConfigurations {
        $path = '/enterprises/{enterprise}/code-security/configurations/defaults';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeSecurityDefaultConfigurations::class, $data);
    }

    public function codeSecurityGetSingleConfigurationForEnterprise(
        string $enterprise,
        int $configuration_id,
    ): CodeSecurityConfiguration {
        $path = '/enterprises/{enterprise}/code-security/configurations/{configuration_id}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{configuration_id}', (string) $configuration_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeSecurityConfiguration::class, $data);
    }

    public function codeSecurityDeleteConfigurationForEnterprise(string $enterprise, int $configuration_id): void
    {
        $path = '/enterprises/{enterprise}/code-security/configurations/{configuration_id}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{configuration_id}', (string) $configuration_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CodeSecurityConfigurationRepositories>
     */
    public function codeSecurityGetRepositoriesForEnterpriseConfiguration(
        string $enterprise,
        int $configuration_id,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $status = null,
    ): array {
        $path = '/enterprises/{enterprise}/code-security/configurations/{configuration_id}/repositories';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{configuration_id}', (string) $configuration_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CodeSecurityConfigurationRepositories => $this->hydrator->hydrate(CodeSecurityConfigurationRepositories::class, (array) $item),
            $data,
        ));
    }

    public function copilotCopilotEnterpriseOneDayUsageMetrics(
        string $enterprise,
        \DateTimeImmutable $day,
    ): CopilotUsageMetrics1DayReport {
        $path = '/enterprises/{enterprise}/copilot/metrics/reports/enterprise-1-day';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $query = [];
        $query[] = 'day=' . \urlencode($day->format('Y-m-d'));
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotUsageMetrics1DayReport::class, $data);
    }

    public function copilotCopilotEnterpriseUsageMetrics(string $enterprise): CopilotUsageMetrics28DayReport
    {
        $path = '/enterprises/{enterprise}/copilot/metrics/reports/enterprise-28-day/latest';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotUsageMetrics28DayReport::class, $data);
    }

    public function copilotCopilotUsersOneDayUsageMetrics(
        string $enterprise,
        \DateTimeImmutable $day,
    ): CopilotUsageMetrics1DayReport {
        $path = '/enterprises/{enterprise}/copilot/metrics/reports/users-1-day';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $query = [];
        $query[] = 'day=' . \urlencode($day->format('Y-m-d'));
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotUsageMetrics1DayReport::class, $data);
    }

    public function copilotCopilotUsersUsageMetrics(string $enterprise): CopilotUsageMetrics28DayReport
    {
        $path = '/enterprises/{enterprise}/copilot/metrics/reports/users-28-day/latest';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotUsageMetrics28DayReport::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\EnterpriseTeam>
     */
    public function enterpriseTeamsList(string $enterprise, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/enterprises/{enterprise}/teams';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): EnterpriseTeam => $this->hydrator->hydrate(EnterpriseTeam::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function enterpriseTeamMembershipsList(
        string $enterprise,
        string $enterpriseTeam,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/enterprises/{enterprise}/teams/{enterprise-team}/memberships';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{enterprise-team}', $enterpriseTeam, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function enterpriseTeamMembershipsGet(
        string $enterprise,
        string $enterpriseTeam,
        string $username,
    ): SimpleUser {
        $path = '/enterprises/{enterprise}/teams/{enterprise-team}/memberships/{username}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{enterprise-team}', $enterpriseTeam, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SimpleUser::class, $data);
    }

    public function enterpriseTeamMembershipsAdd(
        string $enterprise,
        string $enterpriseTeam,
        string $username,
    ): SimpleUser {
        $path = '/enterprises/{enterprise}/teams/{enterprise-team}/memberships/{username}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{enterprise-team}', $enterpriseTeam, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SimpleUser::class, $data);
    }

    public function enterpriseTeamMembershipsRemove(
        string $enterprise,
        string $enterpriseTeam,
        string $username,
    ): void {
        $path = '/enterprises/{enterprise}/teams/{enterprise-team}/memberships/{username}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{enterprise-team}', $enterpriseTeam, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationSimple>
     */
    public function enterpriseTeamOrganizationsGetAssignments(
        string $enterprise,
        string $enterpriseTeam,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/enterprises/{enterprise}/teams/{enterprise-team}/organizations';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{enterprise-team}', $enterpriseTeam, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationSimple => $this->hydrator->hydrate(OrganizationSimple::class, (array) $item),
            $data,
        ));
    }

    public function enterpriseTeamOrganizationsGetAssignment(
        string $enterprise,
        string $enterpriseTeam,
        string $org,
    ): OrganizationSimple {
        $path = '/enterprises/{enterprise}/teams/{enterprise-team}/organizations/{org}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{enterprise-team}', $enterpriseTeam, $path);
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrganizationSimple::class, $data);
    }

    public function enterpriseTeamOrganizationsAdd(
        string $enterprise,
        string $enterpriseTeam,
        string $org,
    ): OrganizationSimple {
        $path = '/enterprises/{enterprise}/teams/{enterprise-team}/organizations/{org}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{enterprise-team}', $enterpriseTeam, $path);
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrganizationSimple::class, $data);
    }

    public function enterpriseTeamOrganizationsDelete(string $enterprise, string $enterpriseTeam, string $org): void
    {
        $path = '/enterprises/{enterprise}/teams/{enterprise-team}/organizations/{org}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{enterprise-team}', $enterpriseTeam, $path);
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function enterpriseTeamsGet(string $enterprise, string $team_slug): EnterpriseTeam
    {
        $path = '/enterprises/{enterprise}/teams/{team_slug}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(EnterpriseTeam::class, $data);
    }

    public function enterpriseTeamsDelete(string $enterprise, string $team_slug): void
    {
        $path = '/enterprises/{enterprise}/teams/{team_slug}';
        $path = \str_replace('{enterprise}', $enterprise, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListPublicEvents(?int $per_page = null, ?int $page = null): array
    {
        $path = '/events';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    public function activityGetFeeds(): Feed
    {
        $path = '/feeds';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Feed::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\BaseGist>
     */
    public function gistsList(?\DateTimeImmutable $since = null, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/gists';
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): BaseGist => $this->hydrator->hydrate(BaseGist::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\BaseGist>
     */
    public function gistsListPublic(
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/gists/public';
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): BaseGist => $this->hydrator->hydrate(BaseGist::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\BaseGist>
     */
    public function gistsListStarred(
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/gists/starred';
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): BaseGist => $this->hydrator->hydrate(BaseGist::class, (array) $item),
            $data,
        ));
    }

    public function gistsGet(string $gist_id): GistSimple
    {
        $path = '/gists/{gist_id}';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GistSimple::class, $data);
    }

    public function gistsDelete(string $gist_id): void
    {
        $path = '/gists/{gist_id}';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\GistComment>
     */
    public function gistsListComments(string $gist_id, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/gists/{gist_id}/comments';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): GistComment => $this->hydrator->hydrate(GistComment::class, (array) $item),
            $data,
        ));
    }

    public function gistsGetComment(string $gist_id, int $comment_id): GistComment
    {
        $path = '/gists/{gist_id}/comments/{comment_id}';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GistComment::class, $data);
    }

    public function gistsDeleteComment(string $gist_id, int $comment_id): void
    {
        $path = '/gists/{gist_id}/comments/{comment_id}';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\GistCommit>
     */
    public function gistsListCommits(string $gist_id, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/gists/{gist_id}/commits';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): GistCommit => $this->hydrator->hydrate(GistCommit::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\GistSimple>
     */
    public function gistsListForks(string $gist_id, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/gists/{gist_id}/forks';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): GistSimple => $this->hydrator->hydrate(GistSimple::class, (array) $item),
            $data,
        ));
    }

    public function gistsFork(string $gist_id): BaseGist
    {
        $path = '/gists/{gist_id}/forks';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(BaseGist::class, $data);
    }

    public function gistsCheckIsStarred(string $gist_id): void
    {
        $path = '/gists/{gist_id}/star';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function gistsStar(string $gist_id): void
    {
        $path = '/gists/{gist_id}/star';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function gistsUnstar(string $gist_id): void
    {
        $path = '/gists/{gist_id}/star';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function gistsGetRevision(string $gist_id, string $sha): GistSimple
    {
        $path = '/gists/{gist_id}/{sha}';
        $path = \str_replace('{gist_id}', $gist_id, $path);
        $path = \str_replace('{sha}', $sha, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GistSimple::class, $data);
    }

    public function gitignoreGetAllTemplates(): void
    {
        $path = '/gitignore/templates';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function gitignoreGetTemplate(string $name): GitignoreTemplate
    {
        $path = '/gitignore/templates/{name}';
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GitignoreTemplate::class, $data);
    }

    public function appsListReposAccessibleToInstallation(?int $per_page = null, ?int $page = null): void
    {
        $path = '/installation/repositories';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsRevokeInstallationAccessToken(): void
    {
        $path = '/installation/token';
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Issue>
     */
    public function issuesList(
        ?IssuesListFilter $filter = null,
        ?IssuesListState $state = null,
        ?string $labels = null,
        ?IssuesListSort $sort = null,
        ?IssuesListDirection $direction = null,
        ?\DateTimeImmutable $since = null,
        ?bool $collab = null,
        ?bool $orgs = null,
        ?bool $owned = null,
        ?bool $pulls = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/issues';
        $query = [];
        if ($filter !== null) {
            $query[] = 'filter=' . \urlencode($filter->value);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($labels !== null) {
            $query[] = 'labels=' . \urlencode($labels);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($collab !== null) {
            $query[] = 'collab=' . \urlencode((string) $collab);
        }
        if ($orgs !== null) {
            $query[] = 'orgs=' . \urlencode((string) $orgs);
        }
        if ($owned !== null) {
            $query[] = 'owned=' . \urlencode((string) $owned);
        }
        if ($pulls !== null) {
            $query[] = 'pulls=' . \urlencode((string) $pulls);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Issue => $this->hydrator->hydrate(Issue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\LicenseSimple>
     */
    public function licensesGetAllCommonlyUsed(
        ?bool $featured = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/licenses';
        $query = [];
        if ($featured !== null) {
            $query[] = 'featured=' . \urlencode((string) $featured);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): LicenseSimple => $this->hydrator->hydrate(LicenseSimple::class, (array) $item),
            $data,
        ));
    }

    public function licensesGet(string $license): License
    {
        $path = '/licenses/{license}';
        $path = \str_replace('{license}', $license, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(License::class, $data);
    }

    public function appsGetSubscriptionPlanForAccount(int $account_id): MarketplacePurchase
    {
        $path = '/marketplace_listing/accounts/{account_id}';
        $path = \str_replace('{account_id}', (string) $account_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(MarketplacePurchase::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MarketplaceListingPlan>
     */
    public function appsListPlans(?int $per_page = null, ?int $page = null): array
    {
        $path = '/marketplace_listing/plans';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MarketplaceListingPlan => $this->hydrator->hydrate(MarketplaceListingPlan::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MarketplacePurchase>
     */
    public function appsListAccountsForPlan(
        int $plan_id,
        ?AppsListAccountsForPlanSort $sort = null,
        ?AppsListAccountsForPlanDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/marketplace_listing/plans/{plan_id}/accounts';
        $path = \str_replace('{plan_id}', (string) $plan_id, $path);
        $query = [];
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MarketplacePurchase => $this->hydrator->hydrate(MarketplacePurchase::class, (array) $item),
            $data,
        ));
    }

    public function appsGetSubscriptionPlanForAccountStubbed(int $account_id): MarketplacePurchase
    {
        $path = '/marketplace_listing/stubbed/accounts/{account_id}';
        $path = \str_replace('{account_id}', (string) $account_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(MarketplacePurchase::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MarketplaceListingPlan>
     */
    public function appsListPlansStubbed(?int $per_page = null, ?int $page = null): array
    {
        $path = '/marketplace_listing/stubbed/plans';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MarketplaceListingPlan => $this->hydrator->hydrate(MarketplaceListingPlan::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MarketplacePurchase>
     */
    public function appsListAccountsForPlanStubbed(
        int $plan_id,
        ?AppsListAccountsForPlanStubbedSort $sort = null,
        ?AppsListAccountsForPlanStubbedDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/marketplace_listing/stubbed/plans/{plan_id}/accounts';
        $path = \str_replace('{plan_id}', (string) $plan_id, $path);
        $query = [];
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MarketplacePurchase => $this->hydrator->hydrate(MarketplacePurchase::class, (array) $item),
            $data,
        ));
    }

    public function metaGet(): ApiOverview
    {
        $path = '/meta';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiOverview::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListPublicEventsForRepoNetwork(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/networks/{owner}/{repo}/events';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Thread>
     */
    public function activityListNotificationsForAuthenticatedUser(
        ?bool $all = null,
        ?bool $participating = null,
        ?\DateTimeImmutable $since = null,
        ?\DateTimeImmutable $before = null,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/notifications';
        $query = [];
        if ($all !== null) {
            $query[] = 'all=' . \urlencode((string) $all);
        }
        if ($participating !== null) {
            $query[] = 'participating=' . \urlencode((string) $participating);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before->format(\DateTimeInterface::RFC3339));
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Thread => $this->hydrator->hydrate(Thread::class, (array) $item),
            $data,
        ));
    }

    public function activityGetThread(int $thread_id): Thread
    {
        $path = '/notifications/threads/{thread_id}';
        $path = \str_replace('{thread_id}', (string) $thread_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Thread::class, $data);
    }

    public function activityMarkThreadAsDone(int $thread_id): void
    {
        $path = '/notifications/threads/{thread_id}';
        $path = \str_replace('{thread_id}', (string) $thread_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function activityMarkThreadAsRead(int $thread_id): void
    {
        $path = '/notifications/threads/{thread_id}';
        $path = \str_replace('{thread_id}', (string) $thread_id, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function activityGetThreadSubscriptionForAuthenticatedUser(int $thread_id): ThreadSubscription
    {
        $path = '/notifications/threads/{thread_id}/subscription';
        $path = \str_replace('{thread_id}', (string) $thread_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ThreadSubscription::class, $data);
    }

    public function activityDeleteThreadSubscription(int $thread_id): void
    {
        $path = '/notifications/threads/{thread_id}/subscription';
        $path = \str_replace('{thread_id}', (string) $thread_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function metaGetOctocat(?string $s = null): void
    {
        $path = '/octocat';
        $query = [];
        if ($s !== null) {
            $query[] = 's=' . \urlencode($s);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationSimple>
     */
    public function orgsList(?int $since = null, ?int $per_page = null): array
    {
        $path = '/organizations';
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode((string) $since);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationSimple => $this->hydrator->hydrate(OrganizationSimple::class, (array) $item),
            $data,
        ));
    }

    public function actionsGetActionsCacheRetentionLimitForOrganization(
        string $org,
    ): ActionsCacheRetentionLimitForOrganization {
        $path = '/organizations/{org}/actions/cache/retention-limit';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheRetentionLimitForOrganization::class, $data);
    }

    public function actionsSetActionsCacheRetentionLimitForOrganization(
        string $org,
        ActionsCacheRetentionLimitForOrganization $body,
    ): void {
        $path = '/organizations/{org}/actions/cache/retention-limit';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetActionsCacheStorageLimitForOrganization(
        string $org,
    ): ActionsCacheStorageLimitForOrganization {
        $path = '/organizations/{org}/actions/cache/storage-limit';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheStorageLimitForOrganization::class, $data);
    }

    public function actionsSetActionsCacheStorageLimitForOrganization(
        string $org,
        ActionsCacheStorageLimitForOrganization $body,
    ): void {
        $path = '/organizations/{org}/actions/cache/storage-limit';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingGetAllBudgetsOrg(
        string $org,
        ?int $page = null,
        ?int $per_page = null,
        ?BillingGetAllBudgetsOrgScope $scope = null,
    ): void {
        $path = '/organizations/{org}/settings/billing/budgets';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($scope !== null) {
            $query[] = 'scope=' . \urlencode($scope->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingGetBudgetOrg(string $org, string $budget_id): void
    {
        $path = '/organizations/{org}/settings/billing/budgets/{budget_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{budget_id}', $budget_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingDeleteBudgetOrg(string $org, string $budget_id): void
    {
        $path = '/organizations/{org}/settings/billing/budgets/{budget_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{budget_id}', $budget_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingGetGithubBillingPremiumRequestUsageReportOrg(
        string $org,
        ?int $year = null,
        ?int $month = null,
        ?int $day = null,
        ?string $user = null,
        ?string $model = null,
        ?string $product = null,
    ): void {
        $path = '/organizations/{org}/settings/billing/premium_request/usage';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($year !== null) {
            $query[] = 'year=' . \urlencode((string) $year);
        }
        if ($month !== null) {
            $query[] = 'month=' . \urlencode((string) $month);
        }
        if ($day !== null) {
            $query[] = 'day=' . \urlencode((string) $day);
        }
        if ($user !== null) {
            $query[] = 'user=' . \urlencode($user);
        }
        if ($model !== null) {
            $query[] = 'model=' . \urlencode($model);
        }
        if ($product !== null) {
            $query[] = 'product=' . \urlencode($product);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingGetGithubBillingUsageReportOrg(
        string $org,
        ?int $year = null,
        ?int $month = null,
        ?int $day = null,
    ): void {
        $path = '/organizations/{org}/settings/billing/usage';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($year !== null) {
            $query[] = 'year=' . \urlencode((string) $year);
        }
        if ($month !== null) {
            $query[] = 'month=' . \urlencode((string) $month);
        }
        if ($day !== null) {
            $query[] = 'day=' . \urlencode((string) $day);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingGetGithubBillingUsageSummaryReportOrg(
        string $org,
        ?int $year = null,
        ?int $month = null,
        ?int $day = null,
        ?string $repository = null,
        ?string $product = null,
        ?string $sku = null,
    ): void {
        $path = '/organizations/{org}/settings/billing/usage/summary';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($year !== null) {
            $query[] = 'year=' . \urlencode((string) $year);
        }
        if ($month !== null) {
            $query[] = 'month=' . \urlencode((string) $month);
        }
        if ($day !== null) {
            $query[] = 'day=' . \urlencode((string) $day);
        }
        if ($repository !== null) {
            $query[] = 'repository=' . \urlencode($repository);
        }
        if ($product !== null) {
            $query[] = 'product=' . \urlencode($product);
        }
        if ($sku !== null) {
            $query[] = 'sku=' . \urlencode($sku);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsGet(string $org): OrganizationFull
    {
        $path = '/orgs/{org}';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrganizationFull::class, $data);
    }

    public function orgsDelete(string $org): void
    {
        $path = '/orgs/{org}';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetActionsCacheUsageForOrg(string $org): ActionsCacheUsageOrgEnterprise
    {
        $path = '/orgs/{org}/actions/cache/usage';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheUsageOrgEnterprise::class, $data);
    }

    public function actionsGetActionsCacheUsageByRepoForOrg(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/actions/cache/usage-by-repository';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListHostedRunnersForOrg(string $org, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/orgs/{org}/actions/hosted-runners';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListCustomImagesForOrg(string $org): void
    {
        $path = '/orgs/{org}/actions/hosted-runners/images/custom';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetCustomImageForOrg(string $org, int $image_definition_id): ActionsHostedRunnerCustomImage
    {
        $path = '/orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{image_definition_id}', (string) $image_definition_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsHostedRunnerCustomImage::class, $data);
    }

    public function actionsDeleteCustomImageFromOrg(string $org, int $image_definition_id): void
    {
        $path = '/orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{image_definition_id}', (string) $image_definition_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListCustomImageVersionsForOrg(int $image_definition_id, string $org): void
    {
        $path = '/orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}/versions';
        $path = \str_replace('{image_definition_id}', (string) $image_definition_id, $path);
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetCustomImageVersionForOrg(
        string $org,
        int $image_definition_id,
        string $version,
    ): ActionsHostedRunnerCustomImageVersion {
        $path = '/orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}/versions/{version}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{image_definition_id}', (string) $image_definition_id, $path);
        $path = \str_replace('{version}', $version, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsHostedRunnerCustomImageVersion::class, $data);
    }

    public function actionsDeleteCustomImageVersionFromOrg(
        string $org,
        int $image_definition_id,
        string $version,
    ): void {
        $path = '/orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}/versions/{version}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{image_definition_id}', (string) $image_definition_id, $path);
        $path = \str_replace('{version}', $version, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetHostedRunnersGithubOwnedImagesForOrg(string $org): void
    {
        $path = '/orgs/{org}/actions/hosted-runners/images/github-owned';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetHostedRunnersPartnerImagesForOrg(string $org): void
    {
        $path = '/orgs/{org}/actions/hosted-runners/images/partner';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetHostedRunnersLimitsForOrg(string $org): ActionsHostedRunnerLimits
    {
        $path = '/orgs/{org}/actions/hosted-runners/limits';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsHostedRunnerLimits::class, $data);
    }

    public function actionsGetHostedRunnersMachineSpecsForOrg(string $org): void
    {
        $path = '/orgs/{org}/actions/hosted-runners/machine-sizes';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetHostedRunnersPlatformsForOrg(string $org): void
    {
        $path = '/orgs/{org}/actions/hosted-runners/platforms';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetHostedRunnerForOrg(string $org, int $hosted_runner_id): ActionsHostedRunner
    {
        $path = '/orgs/{org}/actions/hosted-runners/{hosted_runner_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hosted_runner_id}', (string) $hosted_runner_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsHostedRunner::class, $data);
    }

    public function actionsDeleteHostedRunnerForOrg(string $org, int $hosted_runner_id): ActionsHostedRunner
    {
        $path = '/orgs/{org}/actions/hosted-runners/{hosted_runner_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hosted_runner_id}', (string) $hosted_runner_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsHostedRunner::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OidcCustomPropertyInclusion>
     */
    public function oidcListOidcCustomPropertyInclusionsForOrg(string $org): array
    {
        $path = '/orgs/{org}/actions/oidc/customization/properties/repo';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OidcCustomPropertyInclusion => $this->hydrator->hydrate(OidcCustomPropertyInclusion::class, (array) $item),
            $data,
        ));
    }

    public function oidcCreateOidcCustomPropertyInclusionForOrg(
        string $org,
        OidcCustomPropertyInclusionInput $body,
    ): OidcCustomPropertyInclusion {
        $path = '/orgs/{org}/actions/oidc/customization/properties/repo';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OidcCustomPropertyInclusion::class, $data);
    }

    public function oidcDeleteOidcCustomPropertyInclusionForOrg(string $org, string $custom_property_name): void
    {
        $path = '/orgs/{org}/actions/oidc/customization/properties/repo/{custom_property_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{custom_property_name}', $custom_property_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function oidcGetOidcCustomSubTemplateForOrg(string $org): OidcCustomSub
    {
        $path = '/orgs/{org}/actions/oidc/customization/sub';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OidcCustomSub::class, $data);
    }

    public function actionsGetGithubActionsPermissionsOrganization(string $org): ActionsOrganizationPermissions
    {
        $path = '/orgs/{org}/actions/permissions';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsOrganizationPermissions::class, $data);
    }

    public function actionsGetArtifactAndLogRetentionSettingsOrganization(
        string $org,
    ): ActionsArtifactAndLogRetentionResponse {
        $path = '/orgs/{org}/actions/permissions/artifact-and-log-retention';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsArtifactAndLogRetentionResponse::class, $data);
    }

    public function actionsSetArtifactAndLogRetentionSettingsOrganization(
        string $org,
        ActionsArtifactAndLogRetention $body,
    ): void {
        $path = '/orgs/{org}/actions/permissions/artifact-and-log-retention';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetForkPrContributorApprovalPermissionsOrganization(
        string $org,
    ): ActionsForkPrContributorApproval {
        $path = '/orgs/{org}/actions/permissions/fork-pr-contributor-approval';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsForkPrContributorApproval::class, $data);
    }

    public function actionsSetForkPrContributorApprovalPermissionsOrganization(
        string $org,
        ActionsForkPrContributorApproval $body,
    ): void {
        $path = '/orgs/{org}/actions/permissions/fork-pr-contributor-approval';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetPrivateRepoForkPrWorkflowsSettingsOrganization(
        string $org,
    ): ActionsForkPrWorkflowsPrivateRepos {
        $path = '/orgs/{org}/actions/permissions/fork-pr-workflows-private-repos';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsForkPrWorkflowsPrivateRepos::class, $data);
    }

    public function actionsSetPrivateRepoForkPrWorkflowsSettingsOrganization(
        string $org,
        ActionsForkPrWorkflowsPrivateReposRequest $body,
    ): void {
        $path = '/orgs/{org}/actions/permissions/fork-pr-workflows-private-repos';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListSelectedRepositoriesEnabledGithubActionsOrganization(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/actions/permissions/repositories';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsEnableSelectedRepositoryGithubActionsOrganization(string $org, int $repository_id): void
    {
        $path = '/orgs/{org}/actions/permissions/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsDisableSelectedRepositoryGithubActionsOrganization(string $org, int $repository_id): void
    {
        $path = '/orgs/{org}/actions/permissions/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetAllowedActionsOrganization(string $org): SelectedActions
    {
        $path = '/orgs/{org}/actions/permissions/selected-actions';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SelectedActions::class, $data);
    }

    public function actionsSetAllowedActionsOrganization(string $org, SelectedActions $body): void
    {
        $path = '/orgs/{org}/actions/permissions/selected-actions';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetSelfHostedRunnersPermissionsOrganization(string $org): SelfHostedRunnersSettings
    {
        $path = '/orgs/{org}/actions/permissions/self-hosted-runners';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SelfHostedRunnersSettings::class, $data);
    }

    public function actionsListSelectedRepositoriesSelfHostedRunnersOrganization(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/actions/permissions/self-hosted-runners/repositories';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsEnableSelectedRepositorySelfHostedRunnersOrganization(
        string $org,
        int $repository_id,
    ): void {
        $path = '/orgs/{org}/actions/permissions/self-hosted-runners/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsDisableSelectedRepositorySelfHostedRunnersOrganization(
        string $org,
        int $repository_id,
    ): void {
        $path = '/orgs/{org}/actions/permissions/self-hosted-runners/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetGithubActionsDefaultWorkflowPermissionsOrganization(
        string $org,
    ): ActionsGetDefaultWorkflowPermissions {
        $path = '/orgs/{org}/actions/permissions/workflow';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsGetDefaultWorkflowPermissions::class, $data);
    }

    public function actionsSetGithubActionsDefaultWorkflowPermissionsOrganization(
        string $org,
        ActionsSetDefaultWorkflowPermissions $body,
    ): void {
        $path = '/orgs/{org}/actions/permissions/workflow';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListSelfHostedRunnerGroupsForOrg(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
        ?string $visible_to_repository = null,
    ): void {
        $path = '/orgs/{org}/actions/runner-groups';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($visible_to_repository !== null) {
            $query[] = 'visible_to_repository=' . \urlencode($visible_to_repository);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetSelfHostedRunnerGroupForOrg(string $org, int $runner_group_id): RunnerGroupsOrg
    {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RunnerGroupsOrg::class, $data);
    }

    public function actionsDeleteSelfHostedRunnerGroupFromOrg(string $org, int $runner_group_id): void
    {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListGithubHostedRunnersInGroupForOrg(
        string $org,
        int $runner_group_id,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}/hosted-runners';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListRepoAccessToSelfHostedRunnerGroupInOrg(
        string $org,
        int $runner_group_id,
        ?int $page = null,
        ?int $per_page = null,
    ): void {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsAddRepoAccessToSelfHostedRunnerGroupInOrg(
        string $org,
        int $runner_group_id,
        int $repository_id,
    ): void {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsRemoveRepoAccessToSelfHostedRunnerGroupInOrg(
        string $org,
        int $runner_group_id,
        int $repository_id,
    ): void {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListSelfHostedRunnersInGroupForOrg(
        string $org,
        int $runner_group_id,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}/runners';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsAddSelfHostedRunnerToGroupForOrg(string $org, int $runner_group_id, int $runner_id): void
    {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}/runners/{runner_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsRemoveSelfHostedRunnerFromGroupForOrg(
        string $org,
        int $runner_group_id,
        int $runner_id,
    ): void {
        $path = '/orgs/{org}/actions/runner-groups/{runner_group_id}/runners/{runner_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_group_id}', (string) $runner_group_id, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListSelfHostedRunnersForOrg(
        string $org,
        ?string $name = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/actions/runners';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RunnerApplication>
     */
    public function actionsListRunnerApplicationsForOrg(string $org): array
    {
        $path = '/orgs/{org}/actions/runners/downloads';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RunnerApplication => $this->hydrator->hydrate(RunnerApplication::class, (array) $item),
            $data,
        ));
    }

    public function actionsCreateRegistrationTokenForOrg(string $org): AuthenticationToken
    {
        $path = '/orgs/{org}/actions/runners/registration-token';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(AuthenticationToken::class, $data);
    }

    public function actionsCreateRemoveTokenForOrg(string $org): AuthenticationToken
    {
        $path = '/orgs/{org}/actions/runners/remove-token';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(AuthenticationToken::class, $data);
    }

    public function actionsGetSelfHostedRunnerForOrg(string $org, int $runner_id): Runner
    {
        $path = '/orgs/{org}/actions/runners/{runner_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Runner::class, $data);
    }

    public function actionsDeleteSelfHostedRunnerFromOrg(string $org, int $runner_id): void
    {
        $path = '/orgs/{org}/actions/runners/{runner_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListLabelsForSelfHostedRunnerForOrg(string $org, int $runner_id): void
    {
        $path = '/orgs/{org}/actions/runners/{runner_id}/labels';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsRemoveAllCustomLabelsFromSelfHostedRunnerForOrg(string $org, int $runner_id): void
    {
        $path = '/orgs/{org}/actions/runners/{runner_id}/labels';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsRemoveCustomLabelFromSelfHostedRunnerForOrg(
        string $org,
        int $runner_id,
        string $name,
    ): void {
        $path = '/orgs/{org}/actions/runners/{runner_id}/labels/{name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListOrgSecrets(string $org, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/orgs/{org}/actions/secrets';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetOrgPublicKey(string $org): ActionsPublicKey
    {
        $path = '/orgs/{org}/actions/secrets/public-key';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsPublicKey::class, $data);
    }

    public function actionsGetOrgSecret(string $org, string $secret_name): OrganizationActionsSecret
    {
        $path = '/orgs/{org}/actions/secrets/{secret_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrganizationActionsSecret::class, $data);
    }

    public function actionsDeleteOrgSecret(string $org, string $secret_name): void
    {
        $path = '/orgs/{org}/actions/secrets/{secret_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListSelectedReposForOrgSecret(
        string $org,
        string $secret_name,
        ?int $page = null,
        ?int $per_page = null,
    ): void {
        $path = '/orgs/{org}/actions/secrets/{secret_name}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsAddSelectedRepoToOrgSecret(string $org, string $secret_name, int $repository_id): void
    {
        $path = '/orgs/{org}/actions/secrets/{secret_name}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsRemoveSelectedRepoFromOrgSecret(string $org, string $secret_name, int $repository_id): void
    {
        $path = '/orgs/{org}/actions/secrets/{secret_name}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListOrgVariables(string $org, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/orgs/{org}/actions/variables';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetOrgVariable(string $org, string $name): OrganizationActionsVariable
    {
        $path = '/orgs/{org}/actions/variables/{name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrganizationActionsVariable::class, $data);
    }

    public function actionsDeleteOrgVariable(string $org, string $name): void
    {
        $path = '/orgs/{org}/actions/variables/{name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListSelectedReposForOrgVariable(
        string $org,
        string $name,
        ?int $page = null,
        ?int $per_page = null,
    ): void {
        $path = '/orgs/{org}/actions/variables/{name}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{name}', $name, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsAddSelectedRepoToOrgVariable(string $org, string $name, int $repository_id): void
    {
        $path = '/orgs/{org}/actions/variables/{name}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{name}', $name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsRemoveSelectedRepoFromOrgVariable(string $org, string $name, int $repository_id): void
    {
        $path = '/orgs/{org}/actions/variables/{name}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{name}', $name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsListArtifactDeploymentRecords(string $org, string $subject_digest): void
    {
        $path = '/orgs/{org}/artifacts/{subject_digest}/metadata/deployment-records';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{subject_digest}', $subject_digest, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsListArtifactStorageRecords(string $org, string $subject_digest): void
    {
        $path = '/orgs/{org}/artifacts/{subject_digest}/metadata/storage-records';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{subject_digest}', $subject_digest, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsDeleteAttestationsBySubjectDigest(string $org, string $subject_digest): void
    {
        $path = '/orgs/{org}/attestations/digest/{subject_digest}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{subject_digest}', $subject_digest, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsListAttestationRepositories(
        string $org,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $predicate_type = null,
    ): void {
        $path = '/orgs/{org}/attestations/repositories';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($predicate_type !== null) {
            $query[] = 'predicate_type=' . \urlencode($predicate_type);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsDeleteAttestationsById(string $org, int $attestation_id): void
    {
        $path = '/orgs/{org}/attestations/{attestation_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{attestation_id}', (string) $attestation_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsListAttestations(
        string $org,
        string $subject_digest,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $predicate_type = null,
    ): void {
        $path = '/orgs/{org}/attestations/{subject_digest}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{subject_digest}', $subject_digest, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($predicate_type !== null) {
            $query[] = 'predicate_type=' . \urlencode($predicate_type);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function orgsListBlockedUsers(string $org, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/orgs/{org}/blocks';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function orgsCheckBlockedUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/blocks/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsBlockUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/blocks/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsUnblockUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/blocks/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function campaignsGetCampaignSummary(string $org, int $campaign_number): CampaignSummary
    {
        $path = '/orgs/{org}/campaigns/{campaign_number}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{campaign_number}', (string) $campaign_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CampaignSummary::class, $data);
    }

    public function campaignsDeleteCampaign(string $org, int $campaign_number): void
    {
        $path = '/orgs/{org}/campaigns/{campaign_number}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{campaign_number}', (string) $campaign_number, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CodeSecurityConfiguration>
     */
    public function codeSecurityGetConfigurationsForOrg(
        string $org,
        ?CodeSecurityGetConfigurationsForOrgTargetType $target_type = null,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
    ): array {
        $path = '/orgs/{org}/code-security/configurations';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($target_type !== null) {
            $query[] = 'target_type=' . \urlencode($target_type->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CodeSecurityConfiguration => $this->hydrator->hydrate(CodeSecurityConfiguration::class, (array) $item),
            $data,
        ));
    }

    public function codeSecurityGetDefaultConfigurations(string $org): CodeSecurityDefaultConfigurations
    {
        $path = '/orgs/{org}/code-security/configurations/defaults';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeSecurityDefaultConfigurations::class, $data);
    }

    public function codeSecurityGetConfiguration(string $org, int $configuration_id): CodeSecurityConfiguration
    {
        $path = '/orgs/{org}/code-security/configurations/{configuration_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{configuration_id}', (string) $configuration_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeSecurityConfiguration::class, $data);
    }

    public function codeSecurityDeleteConfiguration(string $org, int $configuration_id): void
    {
        $path = '/orgs/{org}/code-security/configurations/{configuration_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{configuration_id}', (string) $configuration_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CodeSecurityConfigurationRepositories>
     */
    public function codeSecurityGetRepositoriesForConfiguration(
        string $org,
        int $configuration_id,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $status = null,
    ): array {
        $path = '/orgs/{org}/code-security/configurations/{configuration_id}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{configuration_id}', (string) $configuration_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CodeSecurityConfigurationRepositories => $this->hydrator->hydrate(CodeSecurityConfigurationRepositories::class, (array) $item),
            $data,
        ));
    }

    public function codespacesListInOrganization(string $org, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/orgs/{org}/codespaces';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesListOrgSecrets(string $org, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/orgs/{org}/codespaces/secrets';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesGetOrgPublicKey(string $org): CodespacesPublicKey
    {
        $path = '/orgs/{org}/codespaces/secrets/public-key';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodespacesPublicKey::class, $data);
    }

    public function codespacesGetOrgSecret(string $org, string $secret_name): CodespacesOrgSecret
    {
        $path = '/orgs/{org}/codespaces/secrets/{secret_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodespacesOrgSecret::class, $data);
    }

    public function codespacesDeleteOrgSecret(string $org, string $secret_name): void
    {
        $path = '/orgs/{org}/codespaces/secrets/{secret_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesListSelectedReposForOrgSecret(
        string $org,
        string $secret_name,
        ?int $page = null,
        ?int $per_page = null,
    ): void {
        $path = '/orgs/{org}/codespaces/secrets/{secret_name}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesAddSelectedRepoToOrgSecret(string $org, string $secret_name, int $repository_id): void
    {
        $path = '/orgs/{org}/codespaces/secrets/{secret_name}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesRemoveSelectedRepoFromOrgSecret(
        string $org,
        string $secret_name,
        int $repository_id,
    ): void {
        $path = '/orgs/{org}/codespaces/secrets/{secret_name}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function copilotGetCopilotOrganizationDetails(string $org): CopilotOrganizationDetails
    {
        $path = '/orgs/{org}/copilot/billing';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotOrganizationDetails::class, $data);
    }

    public function copilotListCopilotSeats(string $org, ?int $page = null, ?int $per_page = null): void
    {
        $path = '/orgs/{org}/copilot/billing/seats';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function copilotGetCopilotCodingAgentPermissionsOrganization(string $org): void
    {
        $path = '/orgs/{org}/copilot/coding-agent/permissions';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function copilotListCopilotCodingAgentSelectedRepositoriesForOrganization(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/copilot/coding-agent/permissions/repositories';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function copilotEnableCopilotCodingAgentForRepositoryInOrganization(string $org, int $repository_id): void
    {
        $path = '/orgs/{org}/copilot/coding-agent/permissions/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function copilotDisableCopilotCodingAgentForRepositoryInOrganization(string $org, int $repository_id): void
    {
        $path = '/orgs/{org}/copilot/coding-agent/permissions/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function copilotCopilotContentExclusionForOrganization(
        string $org,
    ): CopilotOrganizationContentExclusionDetails {
        $path = '/orgs/{org}/copilot/content_exclusion';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotOrganizationContentExclusionDetails::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CopilotUsageMetricsDay>
     */
    public function copilotCopilotMetricsForOrganization(
        string $org,
        ?string $since = null,
        ?string $until = null,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/orgs/{org}/copilot/metrics';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since);
        }
        if ($until !== null) {
            $query[] = 'until=' . \urlencode($until);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CopilotUsageMetricsDay => $this->hydrator->hydrate(CopilotUsageMetricsDay::class, (array) $item),
            $data,
        ));
    }

    public function copilotCopilotOrganizationOneDayUsageMetrics(
        string $org,
        \DateTimeImmutable $day,
    ): CopilotUsageMetrics1DayReport {
        $path = '/orgs/{org}/copilot/metrics/reports/organization-1-day';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        $query[] = 'day=' . \urlencode($day->format('Y-m-d'));
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotUsageMetrics1DayReport::class, $data);
    }

    public function copilotCopilotOrganizationUsageMetrics(string $org): CopilotUsageMetrics28DayReport
    {
        $path = '/orgs/{org}/copilot/metrics/reports/organization-28-day/latest';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotUsageMetrics28DayReport::class, $data);
    }

    public function copilotCopilotOrganizationUsersOneDayUsageMetrics(
        string $org,
        \DateTimeImmutable $day,
    ): CopilotUsageMetrics1DayReport {
        $path = '/orgs/{org}/copilot/metrics/reports/users-1-day';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        $query[] = 'day=' . \urlencode($day->format('Y-m-d'));
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotUsageMetrics1DayReport::class, $data);
    }

    public function copilotCopilotOrganizationUsersUsageMetrics(string $org): CopilotUsageMetrics28DayReport
    {
        $path = '/orgs/{org}/copilot/metrics/reports/users-28-day/latest';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotUsageMetrics28DayReport::class, $data);
    }

    public function dependabotRepositoryAccessForOrg(
        string $org,
        ?int $page = null,
        ?int $per_page = null,
    ): DependabotRepositoryAccessDetails {
        $path = '/orgs/{org}/dependabot/repository-access';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DependabotRepositoryAccessDetails::class, $data);
    }

    public function dependabotListOrgSecrets(string $org, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/orgs/{org}/dependabot/secrets';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dependabotGetOrgPublicKey(string $org): DependabotPublicKey
    {
        $path = '/orgs/{org}/dependabot/secrets/public-key';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DependabotPublicKey::class, $data);
    }

    public function dependabotGetOrgSecret(string $org, string $secret_name): OrganizationDependabotSecret
    {
        $path = '/orgs/{org}/dependabot/secrets/{secret_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrganizationDependabotSecret::class, $data);
    }

    public function dependabotDeleteOrgSecret(string $org, string $secret_name): void
    {
        $path = '/orgs/{org}/dependabot/secrets/{secret_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dependabotListSelectedReposForOrgSecret(
        string $org,
        string $secret_name,
        ?int $page = null,
        ?int $per_page = null,
    ): void {
        $path = '/orgs/{org}/dependabot/secrets/{secret_name}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dependabotAddSelectedRepoToOrgSecret(string $org, string $secret_name, int $repository_id): void
    {
        $path = '/orgs/{org}/dependabot/secrets/{secret_name}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dependabotRemoveSelectedRepoFromOrgSecret(
        string $org,
        string $secret_name,
        int $repository_id,
    ): void {
        $path = '/orgs/{org}/dependabot/secrets/{secret_name}/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Package>
     */
    public function packagesListDockerMigrationConflictingPackagesForOrganization(string $org): array
    {
        $path = '/orgs/{org}/docker/conflicts';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Package => $this->hydrator->hydrate(Package::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListPublicOrgEvents(string $org, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/orgs/{org}/events';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationInvitation>
     */
    public function orgsListFailedInvitations(string $org, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/orgs/{org}/failed_invitations';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationInvitation => $this->hydrator->hydrate(OrganizationInvitation::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrgHook>
     */
    public function orgsListWebhooks(string $org, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/orgs/{org}/hooks';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrgHook => $this->hydrator->hydrate(OrgHook::class, (array) $item),
            $data,
        ));
    }

    public function orgsGetWebhook(string $org, int $hook_id): OrgHook
    {
        $path = '/orgs/{org}/hooks/{hook_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrgHook::class, $data);
    }

    public function orgsDeleteWebhook(string $org, int $hook_id): void
    {
        $path = '/orgs/{org}/hooks/{hook_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsGetWebhookConfigForOrg(string $org, int $hook_id): WebhookConfig
    {
        $path = '/orgs/{org}/hooks/{hook_id}/config';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(WebhookConfig::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\HookDeliveryItem>
     */
    public function orgsListWebhookDeliveries(
        string $org,
        int $hook_id,
        ?int $per_page = null,
        ?string $cursor = null,
        ?OrgsListWebhookDeliveriesStatus $status = null,
    ): array {
        $path = '/orgs/{org}/hooks/{hook_id}/deliveries';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($cursor !== null) {
            $query[] = 'cursor=' . \urlencode($cursor);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): HookDeliveryItem => $this->hydrator->hydrate(HookDeliveryItem::class, (array) $item),
            $data,
        ));
    }

    public function orgsGetWebhookDelivery(string $org, int $hook_id, int $delivery_id): HookDelivery
    {
        $path = '/orgs/{org}/hooks/{hook_id}/deliveries/{delivery_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $path = \str_replace('{delivery_id}', (string) $delivery_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(HookDelivery::class, $data);
    }

    public function orgsRedeliverWebhookDelivery(string $org, int $hook_id, int $delivery_id): void
    {
        $path = '/orgs/{org}/hooks/{hook_id}/deliveries/{delivery_id}/attempts';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $path = \str_replace('{delivery_id}', (string) $delivery_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsPingWebhook(string $org, int $hook_id): void
    {
        $path = '/orgs/{org}/hooks/{hook_id}/pings';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @param list<string> $sort
     */
    public function apiInsightsGetRouteStatsByActor(
        string $org,
        ApiInsightsGetRouteStatsByActorActorType $actor_type,
        int $actor_id,
        string $min_timestamp,
        ?string $max_timestamp = null,
        ?int $page = null,
        ?int $per_page = null,
        ?ApiInsightsGetRouteStatsByActorDirection $direction = null,
        ?array $sort = null,
        ?string $api_route_substring = null,
    ): ApiInsightsRouteStats {
        $path = '/orgs/{org}/insights/api/route-stats/{actor_type}/{actor_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{actor_type}', $actor_type->value, $path);
        $path = \str_replace('{actor_id}', (string) $actor_id, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($sort !== null) { foreach ($sort as $__v) { $query[] = 'sort=' . \urlencode($__v->value); } }
        if ($api_route_substring !== null) {
            $query[] = 'api_route_substring=' . \urlencode($api_route_substring);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsRouteStats::class, $data);
    }

    /**
     * @param list<string> $sort
     */
    public function apiInsightsGetSubjectStats(
        string $org,
        string $min_timestamp,
        ?string $max_timestamp = null,
        ?int $page = null,
        ?int $per_page = null,
        ?ApiInsightsGetSubjectStatsDirection $direction = null,
        ?array $sort = null,
        ?string $subject_name_substring = null,
    ): ApiInsightsSubjectStats {
        $path = '/orgs/{org}/insights/api/subject-stats';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($sort !== null) { foreach ($sort as $__v) { $query[] = 'sort=' . \urlencode($__v->value); } }
        if ($subject_name_substring !== null) {
            $query[] = 'subject_name_substring=' . \urlencode($subject_name_substring);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsSubjectStats::class, $data);
    }

    public function apiInsightsGetSummaryStats(
        string $org,
        string $min_timestamp,
        ?string $max_timestamp = null,
    ): ApiInsightsSummaryStats {
        $path = '/orgs/{org}/insights/api/summary-stats';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsSummaryStats::class, $data);
    }

    public function apiInsightsGetSummaryStatsByUser(
        string $org,
        string $user_id,
        string $min_timestamp,
        ?string $max_timestamp = null,
    ): ApiInsightsSummaryStats {
        $path = '/orgs/{org}/insights/api/summary-stats/users/{user_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{user_id}', $user_id, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsSummaryStats::class, $data);
    }

    public function apiInsightsGetSummaryStatsByActor(
        string $org,
        ApiInsightsGetSummaryStatsByActorActorType $actor_type,
        int $actor_id,
        string $min_timestamp,
        ?string $max_timestamp = null,
    ): ApiInsightsSummaryStats {
        $path = '/orgs/{org}/insights/api/summary-stats/{actor_type}/{actor_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{actor_type}', $actor_type->value, $path);
        $path = \str_replace('{actor_id}', (string) $actor_id, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsSummaryStats::class, $data);
    }

    public function apiInsightsGetTimeStats(
        string $org,
        string $min_timestamp,
        string $timestamp_increment,
        ?string $max_timestamp = null,
    ): ApiInsightsTimeStats {
        $path = '/orgs/{org}/insights/api/time-stats';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        $query[] = 'timestamp_increment=' . \urlencode($timestamp_increment);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsTimeStats::class, $data);
    }

    public function apiInsightsGetTimeStatsByUser(
        string $org,
        string $user_id,
        string $min_timestamp,
        string $timestamp_increment,
        ?string $max_timestamp = null,
    ): ApiInsightsTimeStats {
        $path = '/orgs/{org}/insights/api/time-stats/users/{user_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{user_id}', $user_id, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        $query[] = 'timestamp_increment=' . \urlencode($timestamp_increment);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsTimeStats::class, $data);
    }

    public function apiInsightsGetTimeStatsByActor(
        string $org,
        ApiInsightsGetTimeStatsByActorActorType $actor_type,
        int $actor_id,
        string $min_timestamp,
        string $timestamp_increment,
        ?string $max_timestamp = null,
    ): ApiInsightsTimeStats {
        $path = '/orgs/{org}/insights/api/time-stats/{actor_type}/{actor_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{actor_type}', $actor_type->value, $path);
        $path = \str_replace('{actor_id}', (string) $actor_id, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        $query[] = 'timestamp_increment=' . \urlencode($timestamp_increment);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsTimeStats::class, $data);
    }

    /**
     * @param list<string> $sort
     */
    public function apiInsightsGetUserStats(
        string $org,
        string $user_id,
        string $min_timestamp,
        ?string $max_timestamp = null,
        ?int $page = null,
        ?int $per_page = null,
        ?ApiInsightsGetUserStatsDirection $direction = null,
        ?array $sort = null,
        ?string $actor_name_substring = null,
    ): ApiInsightsUserStats {
        $path = '/orgs/{org}/insights/api/user-stats/{user_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{user_id}', $user_id, $path);
        $query = [];
        $query[] = 'min_timestamp=' . \urlencode($min_timestamp);
        if ($max_timestamp !== null) {
            $query[] = 'max_timestamp=' . \urlencode($max_timestamp);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($sort !== null) { foreach ($sort as $__v) { $query[] = 'sort=' . \urlencode($__v->value); } }
        if ($actor_name_substring !== null) {
            $query[] = 'actor_name_substring=' . \urlencode($actor_name_substring);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiInsightsUserStats::class, $data);
    }

    public function appsGetOrgInstallation(string $org): Installation
    {
        $path = '/orgs/{org}/installation';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Installation::class, $data);
    }

    public function orgsListAppInstallations(string $org, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/orgs/{org}/installations';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function interactionsGetRestrictionsForOrg(string $org): void
    {
        $path = '/orgs/{org}/interaction-limits';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function interactionsSetRestrictionsForOrg(string $org, InteractionLimit $body): InteractionLimitResponse
    {
        $path = '/orgs/{org}/interaction-limits';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(InteractionLimitResponse::class, $data);
    }

    public function interactionsRemoveRestrictionsForOrg(string $org): void
    {
        $path = '/orgs/{org}/interaction-limits';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationInvitation>
     */
    public function orgsListPendingInvitations(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
        ?OrgsListPendingInvitationsRole $role = null,
        ?OrgsListPendingInvitationsInvitationSource $invitation_source = null,
    ): array {
        $path = '/orgs/{org}/invitations';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($role !== null) {
            $query[] = 'role=' . \urlencode($role->value);
        }
        if ($invitation_source !== null) {
            $query[] = 'invitation_source=' . \urlencode($invitation_source->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationInvitation => $this->hydrator->hydrate(OrganizationInvitation::class, (array) $item),
            $data,
        ));
    }

    public function orgsCancelInvitation(string $org, int $invitation_id): void
    {
        $path = '/orgs/{org}/invitations/{invitation_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{invitation_id}', (string) $invitation_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Team>
     */
    public function orgsListInvitationTeams(
        string $org,
        int $invitation_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/invitations/{invitation_id}/teams';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{invitation_id}', (string) $invitation_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Team => $this->hydrator->hydrate(Team::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\IssueField>
     */
    public function orgsListIssueFields(string $org): array
    {
        $path = '/orgs/{org}/issue-fields';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): IssueField => $this->hydrator->hydrate(IssueField::class, (array) $item),
            $data,
        ));
    }

    public function orgsCreateIssueField(string $org, OrganizationCreateIssueField $body): IssueField
    {
        $path = '/orgs/{org}/issue-fields';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(IssueField::class, $data);
    }

    public function orgsDeleteIssueField(string $org, int $issue_field_id): void
    {
        $path = '/orgs/{org}/issue-fields/{issue_field_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{issue_field_id}', (string) $issue_field_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsUpdateIssueField(
        string $org,
        int $issue_field_id,
        OrganizationUpdateIssueField $body,
    ): IssueField {
        $path = '/orgs/{org}/issue-fields/{issue_field_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{issue_field_id}', (string) $issue_field_id, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(IssueField::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\IssueType>
     */
    public function orgsListIssueTypes(string $org): array
    {
        $path = '/orgs/{org}/issue-types';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): IssueType => $this->hydrator->hydrate(IssueType::class, (array) $item),
            $data,
        ));
    }

    public function orgsCreateIssueType(string $org, OrganizationCreateIssueType $body): IssueType
    {
        $path = '/orgs/{org}/issue-types';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(IssueType::class, $data);
    }

    public function orgsUpdateIssueType(string $org, int $issue_type_id, OrganizationUpdateIssueType $body): IssueType
    {
        $path = '/orgs/{org}/issue-types/{issue_type_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{issue_type_id}', (string) $issue_type_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(IssueType::class, $data);
    }

    public function orgsDeleteIssueType(string $org, int $issue_type_id): void
    {
        $path = '/orgs/{org}/issue-types/{issue_type_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{issue_type_id}', (string) $issue_type_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Issue>
     */
    public function issuesListForOrg(
        string $org,
        ?IssuesListForOrgFilter $filter = null,
        ?IssuesListForOrgState $state = null,
        ?string $labels = null,
        ?string $type = null,
        ?IssuesListForOrgSort $sort = null,
        ?IssuesListForOrgDirection $direction = null,
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/issues';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($filter !== null) {
            $query[] = 'filter=' . \urlencode($filter->value);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($labels !== null) {
            $query[] = 'labels=' . \urlencode($labels);
        }
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Issue => $this->hydrator->hydrate(Issue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function orgsListMembers(
        string $org,
        ?OrgsListMembersFilter $filter = null,
        ?OrgsListMembersRole $role = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/members';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($filter !== null) {
            $query[] = 'filter=' . \urlencode($filter->value);
        }
        if ($role !== null) {
            $query[] = 'role=' . \urlencode($role->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function orgsCheckMembershipForUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/members/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsRemoveMember(string $org, string $username): void
    {
        $path = '/orgs/{org}/members/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesGetCodespacesForUserInOrg(
        string $org,
        string $username,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/members/{username}/codespaces';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesDeleteFromOrganization(string $org, string $username, string $codespace_name): void
    {
        $path = '/orgs/{org}/members/{username}/codespaces/{codespace_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesStopInOrganization(string $org, string $username, string $codespace_name): Codespace
    {
        $path = '/orgs/{org}/members/{username}/codespaces/{codespace_name}/stop';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Codespace::class, $data);
    }

    public function copilotGetCopilotSeatDetailsForUser(string $org, string $username): CopilotSeatDetails
    {
        $path = '/orgs/{org}/members/{username}/copilot';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CopilotSeatDetails::class, $data);
    }

    public function orgsGetMembershipForUser(string $org, string $username): OrgMembership
    {
        $path = '/orgs/{org}/memberships/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrgMembership::class, $data);
    }

    public function orgsRemoveMembershipForUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/memberships/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @param list<string> $exclude
     * @return list<\Acme\GitHub\Generated\Model\Migration>
     */
    public function migrationsListForOrg(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
        ?array $exclude = null,
    ): array {
        $path = '/orgs/{org}/migrations';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($exclude !== null) { foreach ($exclude as $__v) { $query[] = 'exclude=' . \urlencode($__v->value); } }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Migration => $this->hydrator->hydrate(Migration::class, (array) $item),
            $data,
        ));
    }

    /**
     * @param list<string> $exclude
     */
    public function migrationsGetStatusForOrg(string $org, int $migration_id, ?array $exclude = null): Migration
    {
        $path = '/orgs/{org}/migrations/{migration_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $query = [];
        if ($exclude !== null) { foreach ($exclude as $__v) { $query[] = 'exclude=' . \urlencode($__v->value); } }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Migration::class, $data);
    }

    public function migrationsDownloadArchiveForOrg(string $org, int $migration_id): void
    {
        $path = '/orgs/{org}/migrations/{migration_id}/archive';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function migrationsDeleteArchiveForOrg(string $org, int $migration_id): void
    {
        $path = '/orgs/{org}/migrations/{migration_id}/archive';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function migrationsUnlockRepoForOrg(string $org, int $migration_id, string $repo_name): void
    {
        $path = '/orgs/{org}/migrations/{migration_id}/repos/{repo_name}/lock';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $path = \str_replace('{repo_name}', $repo_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function migrationsListReposForOrg(
        string $org,
        int $migration_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/migrations/{migration_id}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    public function orgsListOrgRoles(string $org): void
    {
        $path = '/orgs/{org}/organization-roles';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsRevokeAllOrgRolesTeam(string $org, string $team_slug): void
    {
        $path = '/orgs/{org}/organization-roles/teams/{team_slug}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsAssignTeamToOrgRole(string $org, string $team_slug, int $role_id): void
    {
        $path = '/orgs/{org}/organization-roles/teams/{team_slug}/{role_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $path = \str_replace('{role_id}', (string) $role_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsRevokeOrgRoleTeam(string $org, string $team_slug, int $role_id): void
    {
        $path = '/orgs/{org}/organization-roles/teams/{team_slug}/{role_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $path = \str_replace('{role_id}', (string) $role_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsRevokeAllOrgRolesUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/organization-roles/users/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsAssignUserToOrgRole(string $org, string $username, int $role_id): void
    {
        $path = '/orgs/{org}/organization-roles/users/{username}/{role_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{role_id}', (string) $role_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsRevokeOrgRoleUser(string $org, string $username, int $role_id): void
    {
        $path = '/orgs/{org}/organization-roles/users/{username}/{role_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{role_id}', (string) $role_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsGetOrgRole(string $org, int $role_id): OrganizationRole
    {
        $path = '/orgs/{org}/organization-roles/{role_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{role_id}', (string) $role_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrganizationRole::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\TeamRoleAssignment>
     */
    public function orgsListOrgRoleTeams(string $org, int $role_id, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/orgs/{org}/organization-roles/{role_id}/teams';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{role_id}', (string) $role_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): TeamRoleAssignment => $this->hydrator->hydrate(TeamRoleAssignment::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\UserRoleAssignment>
     */
    public function orgsListOrgRoleUsers(string $org, int $role_id, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/orgs/{org}/organization-roles/{role_id}/users';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{role_id}', (string) $role_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): UserRoleAssignment => $this->hydrator->hydrate(UserRoleAssignment::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function orgsListOutsideCollaborators(
        string $org,
        ?OrgsListOutsideCollaboratorsFilter $filter = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/outside_collaborators';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($filter !== null) {
            $query[] = 'filter=' . \urlencode($filter->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function orgsRemoveOutsideCollaborator(string $org, string $username): void
    {
        $path = '/orgs/{org}/outside_collaborators/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Package>
     */
    public function packagesListPackagesForOrganization(
        string $org,
        PackagesListPackagesForOrganizationPackageType $package_type,
        ?PackagesListPackagesForOrganizationVisibility $visibility = null,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/orgs/{org}/packages';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        $query[] = 'package_type=' . \urlencode($package_type->value);
        if ($visibility !== null) {
            $query[] = 'visibility=' . \urlencode($visibility->value);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Package => $this->hydrator->hydrate(Package::class, (array) $item),
            $data,
        ));
    }

    public function packagesGetPackageForOrganization(
        PackagesGetPackageForOrganizationPackageType $package_type,
        string $package_name,
        string $org,
    ): Package {
        $path = '/orgs/{org}/packages/{package_type}/{package_name}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Package::class, $data);
    }

    public function packagesDeletePackageForOrg(
        PackagesDeletePackageForOrgPackageType $package_type,
        string $package_name,
        string $org,
    ): void {
        $path = '/orgs/{org}/packages/{package_type}/{package_name}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function packagesRestorePackageForOrg(
        PackagesRestorePackageForOrgPackageType $package_type,
        string $package_name,
        string $org,
        ?string $token = null,
    ): void {
        $path = '/orgs/{org}/packages/{package_type}/{package_name}/restore';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($token !== null) {
            $query[] = 'token=' . \urlencode($token);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PackageVersion>
     */
    public function packagesGetAllPackageVersionsForPackageOwnedByOrg(
        PackagesGetAllPackageVersionsForPackageOwnedByOrgPackageType $package_type,
        string $package_name,
        string $org,
        ?int $page = null,
        ?int $per_page = null,
        ?PackagesGetAllPackageVersionsForPackageOwnedByOrgState $state = null,
    ): array {
        $path = '/orgs/{org}/packages/{package_type}/{package_name}/versions';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PackageVersion => $this->hydrator->hydrate(PackageVersion::class, (array) $item),
            $data,
        ));
    }

    public function packagesGetPackageVersionForOrganization(
        PackagesGetPackageVersionForOrganizationPackageType $package_type,
        string $package_name,
        string $org,
        int $package_version_id,
    ): PackageVersion {
        $path = '/orgs/{org}/packages/{package_type}/{package_name}/versions/{package_version_id}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PackageVersion::class, $data);
    }

    public function packagesDeletePackageVersionForOrg(
        PackagesDeletePackageVersionForOrgPackageType $package_type,
        string $package_name,
        string $org,
        int $package_version_id,
    ): void {
        $path = '/orgs/{org}/packages/{package_type}/{package_name}/versions/{package_version_id}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function packagesRestorePackageVersionForOrg(
        PackagesRestorePackageVersionForOrgPackageType $package_type,
        string $package_name,
        string $org,
        int $package_version_id,
    ): void {
        $path = '/orgs/{org}/packages/{package_type}/{package_name}/versions/{package_version_id}/restore';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @param list<string> $owner
     * @param list<string> $token_id
     * @return list<\Acme\GitHub\Generated\Model\OrganizationProgrammaticAccessGrantRequest>
     */
    public function orgsListPatGrantRequests(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
        ?OrgsListPatGrantRequestsSort $sort = null,
        ?OrgsListPatGrantRequestsDirection $direction = null,
        ?array $owner = null,
        ?string $repository = null,
        ?string $permission = null,
        ?\DateTimeImmutable $last_used_before = null,
        ?\DateTimeImmutable $last_used_after = null,
        ?array $token_id = null,
    ): array {
        $path = '/orgs/{org}/personal-access-token-requests';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($owner !== null) { foreach ($owner as $__v) { $query[] = 'owner=' . \urlencode($__v); } }
        if ($repository !== null) {
            $query[] = 'repository=' . \urlencode($repository);
        }
        if ($permission !== null) {
            $query[] = 'permission=' . \urlencode($permission);
        }
        if ($last_used_before !== null) {
            $query[] = 'last_used_before=' . \urlencode($last_used_before->format(\DateTimeInterface::RFC3339));
        }
        if ($last_used_after !== null) {
            $query[] = 'last_used_after=' . \urlencode($last_used_after->format(\DateTimeInterface::RFC3339));
        }
        if ($token_id !== null) { foreach ($token_id as $__v) { $query[] = 'token_id=' . \urlencode($__v); } }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationProgrammaticAccessGrantRequest => $this->hydrator->hydrate(OrganizationProgrammaticAccessGrantRequest::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function orgsListPatGrantRequestRepositories(
        string $org,
        int $pat_request_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/personal-access-token-requests/{pat_request_id}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{pat_request_id}', (string) $pat_request_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    /**
     * @param list<string> $owner
     * @param list<string> $token_id
     * @return list<\Acme\GitHub\Generated\Model\OrganizationProgrammaticAccessGrant>
     */
    public function orgsListPatGrants(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
        ?OrgsListPatGrantsSort $sort = null,
        ?OrgsListPatGrantsDirection $direction = null,
        ?array $owner = null,
        ?string $repository = null,
        ?string $permission = null,
        ?\DateTimeImmutable $last_used_before = null,
        ?\DateTimeImmutable $last_used_after = null,
        ?array $token_id = null,
    ): array {
        $path = '/orgs/{org}/personal-access-tokens';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($owner !== null) { foreach ($owner as $__v) { $query[] = 'owner=' . \urlencode($__v); } }
        if ($repository !== null) {
            $query[] = 'repository=' . \urlencode($repository);
        }
        if ($permission !== null) {
            $query[] = 'permission=' . \urlencode($permission);
        }
        if ($last_used_before !== null) {
            $query[] = 'last_used_before=' . \urlencode($last_used_before->format(\DateTimeInterface::RFC3339));
        }
        if ($last_used_after !== null) {
            $query[] = 'last_used_after=' . \urlencode($last_used_after->format(\DateTimeInterface::RFC3339));
        }
        if ($token_id !== null) { foreach ($token_id as $__v) { $query[] = 'token_id=' . \urlencode($__v); } }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationProgrammaticAccessGrant => $this->hydrator->hydrate(OrganizationProgrammaticAccessGrant::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function orgsListPatGrantRepositories(
        string $org,
        int $pat_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/personal-access-tokens/{pat_id}/repositories';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{pat_id}', (string) $pat_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    public function privateRegistriesListOrgPrivateRegistries(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/private-registries';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function privateRegistriesGetOrgPublicKey(string $org): void
    {
        $path = '/orgs/{org}/private-registries/public-key';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function privateRegistriesGetOrgPrivateRegistry(
        string $org,
        string $secret_name,
    ): OrgPrivateRegistryConfiguration {
        $path = '/orgs/{org}/private-registries/{secret_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrgPrivateRegistryConfiguration::class, $data);
    }

    public function privateRegistriesDeleteOrgPrivateRegistry(string $org, string $secret_name): void
    {
        $path = '/orgs/{org}/private-registries/{secret_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ProjectsV2>
     */
    public function projectsListForOrg(
        string $org,
        ?string $q = null,
        ?string $before = null,
        ?string $after = null,
        ?int $per_page = null,
    ): array {
        $path = '/orgs/{org}/projectsV2';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($q !== null) {
            $query[] = 'q=' . \urlencode($q);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ProjectsV2 => $this->hydrator->hydrate(ProjectsV2::class, (array) $item),
            $data,
        ));
    }

    public function projectsGetForOrg(int $project_number, string $org): ProjectsV2
    {
        $path = '/orgs/{org}/projectsV2/{project_number}';
        $path = \str_replace('{project_number}', (string) $project_number, $path);
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProjectsV2::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ProjectsV2Field>
     */
    public function projectsListFieldsForOrg(
        int $project_number,
        string $org,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
    ): array {
        $path = '/orgs/{org}/projectsV2/{project_number}/fields';
        $path = \str_replace('{project_number}', (string) $project_number, $path);
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ProjectsV2Field => $this->hydrator->hydrate(ProjectsV2Field::class, (array) $item),
            $data,
        ));
    }

    public function projectsGetFieldForOrg(int $project_number, int $field_id, string $org): ProjectsV2Field
    {
        $path = '/orgs/{org}/projectsV2/{project_number}/fields/{field_id}';
        $path = \str_replace('{project_number}', (string) $project_number, $path);
        $path = \str_replace('{field_id}', (string) $field_id, $path);
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProjectsV2Field::class, $data);
    }

    public function projectsDeleteItemForOrg(int $project_number, string $org, int $item_id): void
    {
        $path = '/orgs/{org}/projectsV2/{project_number}/items/{item_id}';
        $path = \str_replace('{project_number}', (string) $project_number, $path);
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{item_id}', (string) $item_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CustomProperty>
     */
    public function orgsCustomPropertiesForReposGetOrganizationDefinitions(string $org): array
    {
        $path = '/orgs/{org}/properties/schema';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CustomProperty => $this->hydrator->hydrate(CustomProperty::class, (array) $item),
            $data,
        ));
    }

    public function orgsCustomPropertiesForReposGetOrganizationDefinition(
        string $org,
        string $custom_property_name,
    ): CustomProperty {
        $path = '/orgs/{org}/properties/schema/{custom_property_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{custom_property_name}', $custom_property_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CustomProperty::class, $data);
    }

    public function orgsCustomPropertiesForReposCreateOrUpdateOrganizationDefinition(
        string $org,
        string $custom_property_name,
        CustomPropertySetPayload $body,
    ): CustomProperty {
        $path = '/orgs/{org}/properties/schema/{custom_property_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{custom_property_name}', $custom_property_name, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CustomProperty::class, $data);
    }

    public function orgsCustomPropertiesForReposDeleteOrganizationDefinition(
        string $org,
        string $custom_property_name,
    ): void {
        $path = '/orgs/{org}/properties/schema/{custom_property_name}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{custom_property_name}', $custom_property_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrgRepoCustomPropertyValues>
     */
    public function orgsCustomPropertiesForReposGetOrganizationValues(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
        ?string $repository_query = null,
    ): array {
        $path = '/orgs/{org}/properties/values';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($repository_query !== null) {
            $query[] = 'repository_query=' . \urlencode($repository_query);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrgRepoCustomPropertyValues => $this->hydrator->hydrate(OrgRepoCustomPropertyValues::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function orgsListPublicMembers(string $org, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/orgs/{org}/public_members';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function orgsCheckPublicMembershipForUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/public_members/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsSetPublicMembershipForAuthenticatedUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/public_members/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsRemovePublicMembershipForAuthenticatedUser(string $org, string $username): void
    {
        $path = '/orgs/{org}/public_members/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function reposListForOrg(
        string $org,
        ?ReposListForOrgType $type = null,
        ?ReposListForOrgSort $sort = null,
        ?ReposListForOrgDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/repos';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type->value);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RepositoryRuleset>
     */
    public function reposGetOrgRulesets(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
        ?string $targets = null,
    ): array {
        $path = '/orgs/{org}/rulesets';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($targets !== null) {
            $query[] = 'targets=' . \urlencode($targets);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RepositoryRuleset => $this->hydrator->hydrate(RepositoryRuleset::class, (array) $item),
            $data,
        ));
    }

    public function reposGetOrgRuleSuites(
        string $org,
        ?string $ref = null,
        ?string $repository_name = null,
        ?ReposGetOrgRuleSuitesTimePeriod $time_period = null,
        ?string $actor_name = null,
        ?ReposGetOrgRuleSuitesRuleSuiteResult $rule_suite_result = null,
        ?int $per_page = null,
        ?int $page = null,
    ): RuleSuites {
        $path = '/orgs/{org}/rulesets/rule-suites';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($repository_name !== null) {
            $query[] = 'repository_name=' . \urlencode($repository_name);
        }
        if ($time_period !== null) {
            $query[] = 'time_period=' . \urlencode($time_period->value);
        }
        if ($actor_name !== null) {
            $query[] = 'actor_name=' . \urlencode($actor_name);
        }
        if ($rule_suite_result !== null) {
            $query[] = 'rule_suite_result=' . \urlencode($rule_suite_result->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RuleSuites::class, $data);
    }

    public function reposGetOrgRuleSuite(string $org, int $rule_suite_id): RuleSuite
    {
        $path = '/orgs/{org}/rulesets/rule-suites/{rule_suite_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{rule_suite_id}', (string) $rule_suite_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RuleSuite::class, $data);
    }

    public function reposGetOrgRuleset(string $org, int $ruleset_id): RepositoryRuleset
    {
        $path = '/orgs/{org}/rulesets/{ruleset_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{ruleset_id}', (string) $ruleset_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepositoryRuleset::class, $data);
    }

    public function reposDeleteOrgRuleset(string $org, int $ruleset_id): void
    {
        $path = '/orgs/{org}/rulesets/{ruleset_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{ruleset_id}', (string) $ruleset_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RulesetVersion>
     */
    public function orgsGetOrgRulesetHistory(
        string $org,
        int $ruleset_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/rulesets/{ruleset_id}/history';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{ruleset_id}', (string) $ruleset_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RulesetVersion => $this->hydrator->hydrate(RulesetVersion::class, (array) $item),
            $data,
        ));
    }

    public function orgsGetOrgRulesetVersion(string $org, int $ruleset_id, int $version_id): RulesetVersionWithState
    {
        $path = '/orgs/{org}/rulesets/{ruleset_id}/history/{version_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{ruleset_id}', (string) $ruleset_id, $path);
        $path = \str_replace('{version_id}', (string) $version_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RulesetVersionWithState::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationSecretScanningAlert>
     */
    public function secretScanningListAlertsForOrg(
        string $org,
        ?SecretScanningListAlertsForOrgState $state = null,
        ?string $secret_type = null,
        ?string $exclude_secret_types = null,
        ?string $exclude_providers = null,
        ?string $providers = null,
        ?string $resolution = null,
        ?string $assignee = null,
        ?SecretScanningListAlertsForOrgSort $sort = null,
        ?SecretScanningListAlertsForOrgDirection $direction = null,
        ?int $page = null,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $validity = null,
        ?bool $is_publicly_leaked = null,
        ?bool $is_multi_repo = null,
        ?bool $hide_secret = null,
    ): array {
        $path = '/orgs/{org}/secret-scanning/alerts';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($secret_type !== null) {
            $query[] = 'secret_type=' . \urlencode($secret_type);
        }
        if ($exclude_secret_types !== null) {
            $query[] = 'exclude_secret_types=' . \urlencode($exclude_secret_types);
        }
        if ($exclude_providers !== null) {
            $query[] = 'exclude_providers=' . \urlencode($exclude_providers);
        }
        if ($providers !== null) {
            $query[] = 'providers=' . \urlencode($providers);
        }
        if ($resolution !== null) {
            $query[] = 'resolution=' . \urlencode($resolution);
        }
        if ($assignee !== null) {
            $query[] = 'assignee=' . \urlencode($assignee);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($validity !== null) {
            $query[] = 'validity=' . \urlencode($validity);
        }
        if ($is_publicly_leaked !== null) {
            $query[] = 'is_publicly_leaked=' . \urlencode((string) $is_publicly_leaked);
        }
        if ($is_multi_repo !== null) {
            $query[] = 'is_multi_repo=' . \urlencode((string) $is_multi_repo);
        }
        if ($hide_secret !== null) {
            $query[] = 'hide_secret=' . \urlencode((string) $hide_secret);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationSecretScanningAlert => $this->hydrator->hydrate(OrganizationSecretScanningAlert::class, (array) $item),
            $data,
        ));
    }

    public function secretScanningListOrgPatternConfigs(string $org): SecretScanningPatternConfiguration
    {
        $path = '/orgs/{org}/secret-scanning/pattern-configurations';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SecretScanningPatternConfiguration::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RepositoryAdvisory>
     */
    public function securityAdvisoriesListOrgRepositoryAdvisories(
        string $org,
        ?SecurityAdvisoriesListOrgRepositoryAdvisoriesDirection $direction = null,
        ?SecurityAdvisoriesListOrgRepositoryAdvisoriesSort $sort = null,
        ?string $before = null,
        ?string $after = null,
        ?int $per_page = null,
        ?SecurityAdvisoriesListOrgRepositoryAdvisoriesState $state = null,
    ): array {
        $path = '/orgs/{org}/security-advisories';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RepositoryAdvisory => $this->hydrator->hydrate(RepositoryAdvisory::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\TeamSimple>
     */
    public function orgsListSecurityManagerTeams(string $org): array
    {
        $path = '/orgs/{org}/security-managers';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): TeamSimple => $this->hydrator->hydrate(TeamSimple::class, (array) $item),
            $data,
        ));
    }

    public function orgsAddSecurityManagerTeam(string $org, string $team_slug): void
    {
        $path = '/orgs/{org}/security-managers/teams/{team_slug}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsRemoveSecurityManagerTeam(string $org, string $team_slug): void
    {
        $path = '/orgs/{org}/security-managers/teams/{team_slug}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsGetImmutableReleasesSettings(string $org): ImmutableReleasesOrganizationSettings
    {
        $path = '/orgs/{org}/settings/immutable-releases';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ImmutableReleasesOrganizationSettings::class, $data);
    }

    public function orgsGetImmutableReleasesSettingsRepositories(
        string $org,
        ?int $page = null,
        ?int $per_page = null,
    ): void {
        $path = '/orgs/{org}/settings/immutable-releases/repositories';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsEnableSelectedRepositoryImmutableReleasesOrganization(string $org, int $repository_id): void
    {
        $path = '/orgs/{org}/settings/immutable-releases/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function orgsDisableSelectedRepositoryImmutableReleasesOrganization(string $org, int $repository_id): void
    {
        $path = '/orgs/{org}/settings/immutable-releases/repositories/{repository_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function hostedComputeListNetworkConfigurationsForOrg(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/orgs/{org}/settings/network-configurations';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function hostedComputeGetNetworkConfigurationForOrg(
        string $org,
        string $network_configuration_id,
    ): NetworkConfiguration {
        $path = '/orgs/{org}/settings/network-configurations/{network_configuration_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{network_configuration_id}', $network_configuration_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(NetworkConfiguration::class, $data);
    }

    public function hostedComputeDeleteNetworkConfigurationFromOrg(
        string $org,
        string $network_configuration_id,
    ): void {
        $path = '/orgs/{org}/settings/network-configurations/{network_configuration_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{network_configuration_id}', $network_configuration_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function hostedComputeGetNetworkSettingsForOrg(string $org, string $network_settings_id): NetworkSettings
    {
        $path = '/orgs/{org}/settings/network-settings/{network_settings_id}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{network_settings_id}', $network_settings_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(NetworkSettings::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CopilotUsageMetricsDay>
     */
    public function copilotCopilotMetricsForTeam(
        string $org,
        string $team_slug,
        ?string $since = null,
        ?string $until = null,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/orgs/{org}/team/{team_slug}/copilot/metrics';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since);
        }
        if ($until !== null) {
            $query[] = 'until=' . \urlencode($until);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CopilotUsageMetricsDay => $this->hydrator->hydrate(CopilotUsageMetricsDay::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Team>
     */
    public function teamsList(
        string $org,
        ?int $per_page = null,
        ?int $page = null,
        ?TeamsListTeamType $team_type = null,
    ): array {
        $path = '/orgs/{org}/teams';
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($team_type !== null) {
            $query[] = 'team_type=' . \urlencode($team_type->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Team => $this->hydrator->hydrate(Team::class, (array) $item),
            $data,
        ));
    }

    public function teamsGetByName(string $org, string $team_slug): TeamFull
    {
        $path = '/orgs/{org}/teams/{team_slug}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(TeamFull::class, $data);
    }

    public function teamsDeleteInOrg(string $org, string $team_slug): void
    {
        $path = '/orgs/{org}/teams/{team_slug}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationInvitation>
     */
    public function teamsListPendingInvitationsInOrg(
        string $org,
        string $team_slug,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/teams/{team_slug}/invitations';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationInvitation => $this->hydrator->hydrate(OrganizationInvitation::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function teamsListMembersInOrg(
        string $org,
        string $team_slug,
        ?TeamsListMembersInOrgRole $role = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/teams/{team_slug}/members';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $query = [];
        if ($role !== null) {
            $query[] = 'role=' . \urlencode($role->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function teamsGetMembershipForUserInOrg(string $org, string $team_slug, string $username): TeamMembership
    {
        $path = '/orgs/{org}/teams/{team_slug}/memberships/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(TeamMembership::class, $data);
    }

    public function teamsRemoveMembershipForUserInOrg(string $org, string $team_slug, string $username): void
    {
        $path = '/orgs/{org}/teams/{team_slug}/memberships/{username}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function teamsListReposInOrg(
        string $org,
        string $team_slug,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/teams/{team_slug}/repos';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    public function teamsCheckPermissionsForRepoInOrg(
        string $org,
        string $team_slug,
        string $owner,
        string $repo,
    ): TeamRepository {
        $path = '/orgs/{org}/teams/{team_slug}/repos/{owner}/{repo}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(TeamRepository::class, $data);
    }

    public function teamsRemoveRepoInOrg(string $org, string $team_slug, string $owner, string $repo): void
    {
        $path = '/orgs/{org}/teams/{team_slug}/repos/{owner}/{repo}';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Team>
     */
    public function teamsListChildInOrg(
        string $org,
        string $team_slug,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/orgs/{org}/teams/{team_slug}/teams';
        $path = \str_replace('{org}', $org, $path);
        $path = \str_replace('{team_slug}', $team_slug, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Team => $this->hydrator->hydrate(Team::class, (array) $item),
            $data,
        ));
    }

    public function rateLimitGet(): RateLimitOverview
    {
        $path = '/rate_limit';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RateLimitOverview::class, $data);
    }

    public function reposGet(string $owner, string $repo): FullRepository
    {
        $path = '/repos/{owner}/{repo}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(FullRepository::class, $data);
    }

    public function reposDelete(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListArtifactsForRepo(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
        ?string $name = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/artifacts';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetArtifact(string $owner, string $repo, int $artifact_id): Artifact
    {
        $path = '/repos/{owner}/{repo}/actions/artifacts/{artifact_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{artifact_id}', (string) $artifact_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Artifact::class, $data);
    }

    public function actionsDeleteArtifact(string $owner, string $repo, int $artifact_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/artifacts/{artifact_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{artifact_id}', (string) $artifact_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsDownloadArtifact(
        string $owner,
        string $repo,
        int $artifact_id,
        string $archive_format,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/artifacts/{artifact_id}/{archive_format}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{artifact_id}', (string) $artifact_id, $path);
        $path = \str_replace('{archive_format}', $archive_format, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetActionsCacheRetentionLimitForRepository(
        string $owner,
        string $repo,
    ): ActionsCacheRetentionLimitForRepository {
        $path = '/repos/{owner}/{repo}/actions/cache/retention-limit';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheRetentionLimitForRepository::class, $data);
    }

    public function actionsSetActionsCacheRetentionLimitForRepository(
        string $owner,
        string $repo,
        ActionsCacheRetentionLimitForRepository $body,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/cache/retention-limit';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetActionsCacheStorageLimitForRepository(
        string $owner,
        string $repo,
    ): ActionsCacheStorageLimitForRepository {
        $path = '/repos/{owner}/{repo}/actions/cache/storage-limit';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheStorageLimitForRepository::class, $data);
    }

    public function actionsSetActionsCacheStorageLimitForRepository(
        string $owner,
        string $repo,
        ActionsCacheStorageLimitForRepository $body,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/cache/storage-limit';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetActionsCacheUsage(string $owner, string $repo): ActionsCacheUsageByRepository
    {
        $path = '/repos/{owner}/{repo}/actions/cache/usage';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheUsageByRepository::class, $data);
    }

    public function actionsGetActionsCacheList(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
        ?string $ref = null,
        ?string $key = null,
        ?ActionsGetActionsCacheListSort $sort = null,
        ?ActionsGetActionsCacheListDirection $direction = null,
    ): ActionsCacheList {
        $path = '/repos/{owner}/{repo}/actions/caches';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($key !== null) {
            $query[] = 'key=' . \urlencode($key);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheList::class, $data);
    }

    public function actionsDeleteActionsCacheByKey(
        string $owner,
        string $repo,
        string $key,
        ?string $ref = null,
    ): ActionsCacheList {
        $path = '/repos/{owner}/{repo}/actions/caches';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        $query[] = 'key=' . \urlencode($key);
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsCacheList::class, $data);
    }

    public function actionsDeleteActionsCacheById(string $owner, string $repo, int $cache_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/caches/{cache_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{cache_id}', (string) $cache_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetJobForWorkflowRun(string $owner, string $repo, int $job_id): Job
    {
        $path = '/repos/{owner}/{repo}/actions/jobs/{job_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{job_id}', (string) $job_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Job::class, $data);
    }

    public function actionsDownloadJobLogsForWorkflowRun(string $owner, string $repo, int $job_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/jobs/{job_id}/logs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{job_id}', (string) $job_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetCustomOidcSubClaimForRepo(string $owner, string $repo): OidcCustomSubRepo
    {
        $path = '/repos/{owner}/{repo}/actions/oidc/customization/sub';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OidcCustomSubRepo::class, $data);
    }

    public function actionsListRepoOrganizationSecrets(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/organization-secrets';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListRepoOrganizationVariables(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/organization-variables';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetGithubActionsPermissionsRepository(
        string $owner,
        string $repo,
    ): ActionsRepositoryPermissions {
        $path = '/repos/{owner}/{repo}/actions/permissions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsRepositoryPermissions::class, $data);
    }

    public function actionsGetWorkflowAccessToRepository(
        string $owner,
        string $repo,
    ): ActionsWorkflowAccessToRepository {
        $path = '/repos/{owner}/{repo}/actions/permissions/access';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsWorkflowAccessToRepository::class, $data);
    }

    public function actionsSetWorkflowAccessToRepository(
        string $owner,
        string $repo,
        ActionsWorkflowAccessToRepository $body,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/permissions/access';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetArtifactAndLogRetentionSettingsRepository(
        string $owner,
        string $repo,
    ): ActionsArtifactAndLogRetentionResponse {
        $path = '/repos/{owner}/{repo}/actions/permissions/artifact-and-log-retention';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsArtifactAndLogRetentionResponse::class, $data);
    }

    public function actionsSetArtifactAndLogRetentionSettingsRepository(
        string $owner,
        string $repo,
        ActionsArtifactAndLogRetention $body,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/permissions/artifact-and-log-retention';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetForkPrContributorApprovalPermissionsRepository(
        string $owner,
        string $repo,
    ): ActionsForkPrContributorApproval {
        $path = '/repos/{owner}/{repo}/actions/permissions/fork-pr-contributor-approval';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsForkPrContributorApproval::class, $data);
    }

    public function actionsSetForkPrContributorApprovalPermissionsRepository(
        string $owner,
        string $repo,
        ActionsForkPrContributorApproval $body,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/permissions/fork-pr-contributor-approval';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetPrivateRepoForkPrWorkflowsSettingsRepository(
        string $owner,
        string $repo,
    ): ActionsForkPrWorkflowsPrivateRepos {
        $path = '/repos/{owner}/{repo}/actions/permissions/fork-pr-workflows-private-repos';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsForkPrWorkflowsPrivateRepos::class, $data);
    }

    public function actionsSetPrivateRepoForkPrWorkflowsSettingsRepository(
        string $owner,
        string $repo,
        ActionsForkPrWorkflowsPrivateReposRequest $body,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/permissions/fork-pr-workflows-private-repos';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetAllowedActionsRepository(string $owner, string $repo): SelectedActions
    {
        $path = '/repos/{owner}/{repo}/actions/permissions/selected-actions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SelectedActions::class, $data);
    }

    public function actionsSetAllowedActionsRepository(string $owner, string $repo, SelectedActions $body): void
    {
        $path = '/repos/{owner}/{repo}/actions/permissions/selected-actions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetGithubActionsDefaultWorkflowPermissionsRepository(
        string $owner,
        string $repo,
    ): ActionsGetDefaultWorkflowPermissions {
        $path = '/repos/{owner}/{repo}/actions/permissions/workflow';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsGetDefaultWorkflowPermissions::class, $data);
    }

    public function actionsSetGithubActionsDefaultWorkflowPermissionsRepository(
        string $owner,
        string $repo,
        ActionsSetDefaultWorkflowPermissions $body,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/permissions/workflow';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListSelfHostedRunnersForRepo(
        string $owner,
        string $repo,
        ?string $name = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/runners';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RunnerApplication>
     */
    public function actionsListRunnerApplicationsForRepo(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/actions/runners/downloads';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RunnerApplication => $this->hydrator->hydrate(RunnerApplication::class, (array) $item),
            $data,
        ));
    }

    public function actionsCreateRegistrationTokenForRepo(string $owner, string $repo): AuthenticationToken
    {
        $path = '/repos/{owner}/{repo}/actions/runners/registration-token';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(AuthenticationToken::class, $data);
    }

    public function actionsCreateRemoveTokenForRepo(string $owner, string $repo): AuthenticationToken
    {
        $path = '/repos/{owner}/{repo}/actions/runners/remove-token';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(AuthenticationToken::class, $data);
    }

    public function actionsGetSelfHostedRunnerForRepo(string $owner, string $repo, int $runner_id): Runner
    {
        $path = '/repos/{owner}/{repo}/actions/runners/{runner_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Runner::class, $data);
    }

    public function actionsDeleteSelfHostedRunnerFromRepo(string $owner, string $repo, int $runner_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/runners/{runner_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListLabelsForSelfHostedRunnerForRepo(string $owner, string $repo, int $runner_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/runners/{runner_id}/labels';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsRemoveAllCustomLabelsFromSelfHostedRunnerForRepo(
        string $owner,
        string $repo,
        int $runner_id,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/runners/{runner_id}/labels';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsRemoveCustomLabelFromSelfHostedRunnerForRepo(
        string $owner,
        string $repo,
        int $runner_id,
        string $name,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/runners/{runner_id}/labels/{name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{runner_id}', (string) $runner_id, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListWorkflowRunsForRepo(
        string $owner,
        string $repo,
        ?string $actor = null,
        ?string $branch = null,
        ?string $event = null,
        ?ActionsListWorkflowRunsForRepoStatus $status = null,
        ?int $per_page = null,
        ?int $page = null,
        ?\DateTimeImmutable $created = null,
        ?bool $exclude_pull_requests = null,
        ?int $check_suite_id = null,
        ?string $head_sha = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/runs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($actor !== null) {
            $query[] = 'actor=' . \urlencode($actor);
        }
        if ($branch !== null) {
            $query[] = 'branch=' . \urlencode($branch);
        }
        if ($event !== null) {
            $query[] = 'event=' . \urlencode($event);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($created !== null) {
            $query[] = 'created=' . \urlencode($created->format(\DateTimeInterface::RFC3339));
        }
        if ($exclude_pull_requests !== null) {
            $query[] = 'exclude_pull_requests=' . \urlencode((string) $exclude_pull_requests);
        }
        if ($check_suite_id !== null) {
            $query[] = 'check_suite_id=' . \urlencode((string) $check_suite_id);
        }
        if ($head_sha !== null) {
            $query[] = 'head_sha=' . \urlencode($head_sha);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetWorkflowRun(
        string $owner,
        string $repo,
        int $run_id,
        ?bool $exclude_pull_requests = null,
    ): WorkflowRun {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $query = [];
        if ($exclude_pull_requests !== null) {
            $query[] = 'exclude_pull_requests=' . \urlencode((string) $exclude_pull_requests);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(WorkflowRun::class, $data);
    }

    public function actionsDeleteWorkflowRun(string $owner, string $repo, int $run_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\EnvironmentApprovals>
     */
    public function actionsGetReviewsForRun(string $owner, string $repo, int $run_id): array
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/approvals';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): EnvironmentApprovals => $this->hydrator->hydrate(EnvironmentApprovals::class, (array) $item),
            $data,
        ));
    }

    public function actionsApproveWorkflowRun(string $owner, string $repo, int $run_id): EmptyObject
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/approve';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(EmptyObject::class, $data);
    }

    public function actionsListWorkflowRunArtifacts(
        string $owner,
        string $repo,
        int $run_id,
        ?int $per_page = null,
        ?int $page = null,
        ?string $name = null,
        ?ActionsListWorkflowRunArtifactsDirection $direction = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/artifacts';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetWorkflowRunAttempt(
        string $owner,
        string $repo,
        int $run_id,
        int $attempt_number,
        ?bool $exclude_pull_requests = null,
    ): WorkflowRun {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/attempts/{attempt_number}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $path = \str_replace('{attempt_number}', (string) $attempt_number, $path);
        $query = [];
        if ($exclude_pull_requests !== null) {
            $query[] = 'exclude_pull_requests=' . \urlencode((string) $exclude_pull_requests);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(WorkflowRun::class, $data);
    }

    public function actionsListJobsForWorkflowRunAttempt(
        string $owner,
        string $repo,
        int $run_id,
        int $attempt_number,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/attempts/{attempt_number}/jobs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $path = \str_replace('{attempt_number}', (string) $attempt_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsDownloadWorkflowRunAttemptLogs(
        string $owner,
        string $repo,
        int $run_id,
        int $attempt_number,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/attempts/{attempt_number}/logs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $path = \str_replace('{attempt_number}', (string) $attempt_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsCancelWorkflowRun(string $owner, string $repo, int $run_id): EmptyObject
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/cancel';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(EmptyObject::class, $data);
    }

    public function actionsForceCancelWorkflowRun(string $owner, string $repo, int $run_id): EmptyObject
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/force-cancel';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(EmptyObject::class, $data);
    }

    public function actionsListJobsForWorkflowRun(
        string $owner,
        string $repo,
        int $run_id,
        ?ActionsListJobsForWorkflowRunFilter $filter = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/jobs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $query = [];
        if ($filter !== null) {
            $query[] = 'filter=' . \urlencode($filter->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsDownloadWorkflowRunLogs(string $owner, string $repo, int $run_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/logs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsDeleteWorkflowRunLogs(string $owner, string $repo, int $run_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/logs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PendingDeployment>
     */
    public function actionsGetPendingDeploymentsForRun(string $owner, string $repo, int $run_id): array
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/pending_deployments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PendingDeployment => $this->hydrator->hydrate(PendingDeployment::class, (array) $item),
            $data,
        ));
    }

    public function actionsGetWorkflowRunUsage(string $owner, string $repo, int $run_id): WorkflowRunUsage
    {
        $path = '/repos/{owner}/{repo}/actions/runs/{run_id}/timing';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{run_id}', (string) $run_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(WorkflowRunUsage::class, $data);
    }

    public function actionsListRepoSecrets(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/secrets';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetRepoPublicKey(string $owner, string $repo): ActionsPublicKey
    {
        $path = '/repos/{owner}/{repo}/actions/secrets/public-key';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsPublicKey::class, $data);
    }

    public function actionsGetRepoSecret(string $owner, string $repo, string $secret_name): ActionsSecret
    {
        $path = '/repos/{owner}/{repo}/actions/secrets/{secret_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsSecret::class, $data);
    }

    public function actionsDeleteRepoSecret(string $owner, string $repo, string $secret_name): void
    {
        $path = '/repos/{owner}/{repo}/actions/secrets/{secret_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListRepoVariables(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/variables';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetRepoVariable(string $owner, string $repo, string $name): ActionsVariable
    {
        $path = '/repos/{owner}/{repo}/actions/variables/{name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsVariable::class, $data);
    }

    public function actionsDeleteRepoVariable(string $owner, string $repo, string $name): void
    {
        $path = '/repos/{owner}/{repo}/actions/variables/{name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListRepoWorkflows(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/workflows';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetWorkflow(string $owner, string $repo, $workflow_id): Workflow
    {
        $path = '/repos/{owner}/{repo}/actions/workflows/{workflow_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{workflow_id}', (string) $workflow_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Workflow::class, $data);
    }

    public function actionsDisableWorkflow(string $owner, string $repo, $workflow_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/workflows/{workflow_id}/disable';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{workflow_id}', (string) $workflow_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsEnableWorkflow(string $owner, string $repo, $workflow_id): void
    {
        $path = '/repos/{owner}/{repo}/actions/workflows/{workflow_id}/enable';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{workflow_id}', (string) $workflow_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListWorkflowRuns(
        string $owner,
        string $repo,
        $workflow_id,
        ?string $actor = null,
        ?string $branch = null,
        ?string $event = null,
        ?ActionsListWorkflowRunsStatus $status = null,
        ?int $per_page = null,
        ?int $page = null,
        ?\DateTimeImmutable $created = null,
        ?bool $exclude_pull_requests = null,
        ?int $check_suite_id = null,
        ?string $head_sha = null,
    ): void {
        $path = '/repos/{owner}/{repo}/actions/workflows/{workflow_id}/runs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{workflow_id}', (string) $workflow_id, $path);
        $query = [];
        if ($actor !== null) {
            $query[] = 'actor=' . \urlencode($actor);
        }
        if ($branch !== null) {
            $query[] = 'branch=' . \urlencode($branch);
        }
        if ($event !== null) {
            $query[] = 'event=' . \urlencode($event);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($created !== null) {
            $query[] = 'created=' . \urlencode($created->format(\DateTimeInterface::RFC3339));
        }
        if ($exclude_pull_requests !== null) {
            $query[] = 'exclude_pull_requests=' . \urlencode((string) $exclude_pull_requests);
        }
        if ($check_suite_id !== null) {
            $query[] = 'check_suite_id=' . \urlencode((string) $check_suite_id);
        }
        if ($head_sha !== null) {
            $query[] = 'head_sha=' . \urlencode($head_sha);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetWorkflowUsage(string $owner, string $repo, $workflow_id): WorkflowUsage
    {
        $path = '/repos/{owner}/{repo}/actions/workflows/{workflow_id}/timing';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{workflow_id}', (string) $workflow_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(WorkflowUsage::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Activity>
     */
    public function reposListActivities(
        string $owner,
        string $repo,
        ?ReposListActivitiesDirection $direction = null,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $ref = null,
        ?string $actor = null,
        ?ReposListActivitiesTimePeriod $time_period = null,
        ?ReposListActivitiesActivityType $activity_type = null,
    ): array {
        $path = '/repos/{owner}/{repo}/activity';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($actor !== null) {
            $query[] = 'actor=' . \urlencode($actor);
        }
        if ($time_period !== null) {
            $query[] = 'time_period=' . \urlencode($time_period->value);
        }
        if ($activity_type !== null) {
            $query[] = 'activity_type=' . \urlencode($activity_type->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Activity => $this->hydrator->hydrate(Activity::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function issuesListAssignees(string $owner, string $repo, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/repos/{owner}/{repo}/assignees';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function issuesCheckUserCanBeAssigned(string $owner, string $repo, string $assignee): void
    {
        $path = '/repos/{owner}/{repo}/assignees/{assignee}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{assignee}', $assignee, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposListAttestations(
        string $owner,
        string $repo,
        string $subject_digest,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $predicate_type = null,
    ): void {
        $path = '/repos/{owner}/{repo}/attestations/{subject_digest}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{subject_digest}', $subject_digest, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($predicate_type !== null) {
            $query[] = 'predicate_type=' . \urlencode($predicate_type);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Autolink>
     */
    public function reposListAutolinks(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/autolinks';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Autolink => $this->hydrator->hydrate(Autolink::class, (array) $item),
            $data,
        ));
    }

    public function reposGetAutolink(string $owner, string $repo, int $autolink_id): Autolink
    {
        $path = '/repos/{owner}/{repo}/autolinks/{autolink_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{autolink_id}', (string) $autolink_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Autolink::class, $data);
    }

    public function reposDeleteAutolink(string $owner, string $repo, int $autolink_id): void
    {
        $path = '/repos/{owner}/{repo}/autolinks/{autolink_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{autolink_id}', (string) $autolink_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposCheckAutomatedSecurityFixes(string $owner, string $repo): CheckAutomatedSecurityFixes
    {
        $path = '/repos/{owner}/{repo}/automated-security-fixes';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CheckAutomatedSecurityFixes::class, $data);
    }

    public function reposEnableAutomatedSecurityFixes(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/automated-security-fixes';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposDisableAutomatedSecurityFixes(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/automated-security-fixes';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ShortBranch>
     */
    public function reposListBranches(
        string $owner,
        string $repo,
        ?bool $protected = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/branches';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($protected !== null) {
            $query[] = 'protected=' . \urlencode((string) $protected);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ShortBranch => $this->hydrator->hydrate(ShortBranch::class, (array) $item),
            $data,
        ));
    }

    public function reposGetBranch(string $owner, string $repo, string $branch): BranchWithProtection
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(BranchWithProtection::class, $data);
    }

    public function reposGetBranchProtection(string $owner, string $repo, string $branch): BranchProtection
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(BranchProtection::class, $data);
    }

    public function reposDeleteBranchProtection(string $owner, string $repo, string $branch): void
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetAdminBranchProtection(
        string $owner,
        string $repo,
        string $branch,
    ): ProtectedBranchAdminEnforced {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/enforce_admins';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProtectedBranchAdminEnforced::class, $data);
    }

    public function reposSetAdminBranchProtection(
        string $owner,
        string $repo,
        string $branch,
    ): ProtectedBranchAdminEnforced {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/enforce_admins';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProtectedBranchAdminEnforced::class, $data);
    }

    public function reposDeleteAdminBranchProtection(string $owner, string $repo, string $branch): void
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/enforce_admins';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetPullRequestReviewProtection(
        string $owner,
        string $repo,
        string $branch,
    ): ProtectedBranchPullRequestReview {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/required_pull_request_reviews';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProtectedBranchPullRequestReview::class, $data);
    }

    public function reposDeletePullRequestReviewProtection(string $owner, string $repo, string $branch): void
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/required_pull_request_reviews';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetCommitSignatureProtection(
        string $owner,
        string $repo,
        string $branch,
    ): ProtectedBranchAdminEnforced {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/required_signatures';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProtectedBranchAdminEnforced::class, $data);
    }

    public function reposCreateCommitSignatureProtection(
        string $owner,
        string $repo,
        string $branch,
    ): ProtectedBranchAdminEnforced {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/required_signatures';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProtectedBranchAdminEnforced::class, $data);
    }

    public function reposDeleteCommitSignatureProtection(string $owner, string $repo, string $branch): void
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/required_signatures';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetStatusChecksProtection(string $owner, string $repo, string $branch): StatusCheckPolicy
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(StatusCheckPolicy::class, $data);
    }

    public function reposRemoveStatusCheckProtection(string $owner, string $repo, string $branch): void
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetAllStatusCheckContexts(string $owner, string $repo, string $branch): void
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks/contexts';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetAccessRestrictions(string $owner, string $repo, string $branch): BranchRestrictionPolicy
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/restrictions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(BranchRestrictionPolicy::class, $data);
    }

    public function reposDeleteAccessRestrictions(string $owner, string $repo, string $branch): void
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/restrictions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Integration>
     */
    public function reposGetAppsWithAccessToProtectedBranch(string $owner, string $repo, string $branch): array
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/restrictions/apps';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Integration => $this->hydrator->hydrate(Integration::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Team>
     */
    public function reposGetTeamsWithAccessToProtectedBranch(string $owner, string $repo, string $branch): array
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/restrictions/teams';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Team => $this->hydrator->hydrate(Team::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function reposGetUsersWithAccessToProtectedBranch(string $owner, string $repo, string $branch): array
    {
        $path = '/repos/{owner}/{repo}/branches/{branch}/protection/restrictions/users';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function checksGet(string $owner, string $repo, int $check_run_id): CheckRun
    {
        $path = '/repos/{owner}/{repo}/check-runs/{check_run_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{check_run_id}', (string) $check_run_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CheckRun::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CheckAnnotation>
     */
    public function checksListAnnotations(
        string $owner,
        string $repo,
        int $check_run_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/check-runs/{check_run_id}/annotations';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{check_run_id}', (string) $check_run_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CheckAnnotation => $this->hydrator->hydrate(CheckAnnotation::class, (array) $item),
            $data,
        ));
    }

    public function checksRerequestRun(string $owner, string $repo, int $check_run_id): EmptyObject
    {
        $path = '/repos/{owner}/{repo}/check-runs/{check_run_id}/rerequest';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{check_run_id}', (string) $check_run_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(EmptyObject::class, $data);
    }

    public function checksGetSuite(string $owner, string $repo, int $check_suite_id): CheckSuite
    {
        $path = '/repos/{owner}/{repo}/check-suites/{check_suite_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{check_suite_id}', (string) $check_suite_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CheckSuite::class, $data);
    }

    public function checksListForSuite(
        string $owner,
        string $repo,
        int $check_suite_id,
        ?string $check_name = null,
        ?ChecksListForSuiteStatus $status = null,
        ?ChecksListForSuiteFilter $filter = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/check-suites/{check_suite_id}/check-runs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{check_suite_id}', (string) $check_suite_id, $path);
        $query = [];
        if ($check_name !== null) {
            $query[] = 'check_name=' . \urlencode($check_name);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status->value);
        }
        if ($filter !== null) {
            $query[] = 'filter=' . \urlencode($filter->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function checksRerequestSuite(string $owner, string $repo, int $check_suite_id): EmptyObject
    {
        $path = '/repos/{owner}/{repo}/check-suites/{check_suite_id}/rerequest';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{check_suite_id}', (string) $check_suite_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(EmptyObject::class, $data);
    }

    public function codeScanningGetAlert(string $owner, string $repo, AlertNumber $alert_number): CodeScanningAlert
    {
        $path = '/repos/{owner}/{repo}/code-scanning/alerts/{alert_number}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{alert_number}', (string) $alert_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningAlert::class, $data);
    }

    public function codeScanningGetAutofix(
        string $owner,
        string $repo,
        AlertNumber $alert_number,
    ): CodeScanningAutofix {
        $path = '/repos/{owner}/{repo}/code-scanning/alerts/{alert_number}/autofix';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{alert_number}', (string) $alert_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningAutofix::class, $data);
    }

    public function codeScanningCreateAutofix(
        string $owner,
        string $repo,
        AlertNumber $alert_number,
    ): CodeScanningAutofix {
        $path = '/repos/{owner}/{repo}/code-scanning/alerts/{alert_number}/autofix';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{alert_number}', (string) $alert_number, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningAutofix::class, $data);
    }

    public function codeScanningCommitAutofix(
        string $owner,
        string $repo,
        AlertNumber $alert_number,
        CodeScanningAutofixCommits $body,
    ): CodeScanningAutofixCommitsResponse {
        $path = '/repos/{owner}/{repo}/code-scanning/alerts/{alert_number}/autofix/commits';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{alert_number}', (string) $alert_number, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningAutofixCommitsResponse::class, $data);
    }

    public function codeScanningGetAnalysis(string $owner, string $repo, int $analysis_id): CodeScanningAnalysis
    {
        $path = '/repos/{owner}/{repo}/code-scanning/analyses/{analysis_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{analysis_id}', (string) $analysis_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningAnalysis::class, $data);
    }

    public function codeScanningDeleteAnalysis(
        string $owner,
        string $repo,
        int $analysis_id,
        ?string $confirm_delete = null,
    ): CodeScanningAnalysisDeletion {
        $path = '/repos/{owner}/{repo}/code-scanning/analyses/{analysis_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{analysis_id}', (string) $analysis_id, $path);
        $query = [];
        if ($confirm_delete !== null) {
            $query[] = 'confirm_delete=' . \urlencode($confirm_delete);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningAnalysisDeletion::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CodeScanningCodeqlDatabase>
     */
    public function codeScanningListCodeqlDatabases(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/code-scanning/codeql/databases';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CodeScanningCodeqlDatabase => $this->hydrator->hydrate(CodeScanningCodeqlDatabase::class, (array) $item),
            $data,
        ));
    }

    public function codeScanningGetCodeqlDatabase(
        string $owner,
        string $repo,
        string $language,
    ): CodeScanningCodeqlDatabase {
        $path = '/repos/{owner}/{repo}/code-scanning/codeql/databases/{language}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{language}', $language, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningCodeqlDatabase::class, $data);
    }

    public function codeScanningDeleteCodeqlDatabase(string $owner, string $repo, string $language): void
    {
        $path = '/repos/{owner}/{repo}/code-scanning/codeql/databases/{language}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{language}', $language, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codeScanningGetVariantAnalysis(
        string $owner,
        string $repo,
        int $codeql_variant_analysis_id,
    ): CodeScanningVariantAnalysis {
        $path = '/repos/{owner}/{repo}/code-scanning/codeql/variant-analyses/{codeql_variant_analysis_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{codeql_variant_analysis_id}', (string) $codeql_variant_analysis_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningVariantAnalysis::class, $data);
    }

    public function codeScanningGetVariantAnalysisRepoTask(
        string $owner,
        string $repo,
        int $codeql_variant_analysis_id,
        string $repo_owner,
        string $repo_name,
    ): CodeScanningVariantAnalysisRepoTask {
        $path = '/repos/{owner}/{repo}/code-scanning/codeql/variant-analyses/{codeql_variant_analysis_id}/repos/{repo_owner}/{repo_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{codeql_variant_analysis_id}', (string) $codeql_variant_analysis_id, $path);
        $path = \str_replace('{repo_owner}', $repo_owner, $path);
        $path = \str_replace('{repo_name}', $repo_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningVariantAnalysisRepoTask::class, $data);
    }

    public function codeScanningGetDefaultSetup(string $owner, string $repo): CodeScanningDefaultSetup
    {
        $path = '/repos/{owner}/{repo}/code-scanning/default-setup';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningDefaultSetup::class, $data);
    }

    public function codeScanningUpdateDefaultSetup(
        string $owner,
        string $repo,
        CodeScanningDefaultSetupUpdate $body,
    ): EmptyObject {
        $path = '/repos/{owner}/{repo}/code-scanning/default-setup';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(EmptyObject::class, $data);
    }

    public function codeScanningGetSarif(string $owner, string $repo, string $sarif_id): CodeScanningSarifsStatus
    {
        $path = '/repos/{owner}/{repo}/code-scanning/sarifs/{sarif_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{sarif_id}', $sarif_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeScanningSarifsStatus::class, $data);
    }

    public function codeSecurityGetConfigurationForRepository(
        string $owner,
        string $repo,
    ): CodeSecurityConfigurationForRepository {
        $path = '/repos/{owner}/{repo}/code-security-configuration';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeSecurityConfigurationForRepository::class, $data);
    }

    public function reposCodeownersErrors(string $owner, string $repo, ?string $ref = null): CodeownersErrors
    {
        $path = '/repos/{owner}/{repo}/codeowners/errors';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodeownersErrors::class, $data);
    }

    public function codespacesListInRepositoryForAuthenticatedUser(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/codespaces';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesListDevcontainersInRepositoryForAuthenticatedUser(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/codespaces/devcontainers';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesRepoMachinesForAuthenticatedUser(
        string $owner,
        string $repo,
        ?string $location = null,
        ?string $client_ip = null,
        ?string $ref = null,
    ): void {
        $path = '/repos/{owner}/{repo}/codespaces/machines';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($location !== null) {
            $query[] = 'location=' . \urlencode($location);
        }
        if ($client_ip !== null) {
            $query[] = 'client_ip=' . \urlencode($client_ip);
        }
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesPreFlightWithRepoForAuthenticatedUser(
        string $owner,
        string $repo,
        ?string $ref = null,
        ?string $client_ip = null,
    ): void {
        $path = '/repos/{owner}/{repo}/codespaces/new';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($client_ip !== null) {
            $query[] = 'client_ip=' . \urlencode($client_ip);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesCheckPermissionsForDevcontainer(
        string $owner,
        string $repo,
        string $ref,
        string $devcontainer_path,
    ): CodespacesPermissionsCheckForDevcontainer {
        $path = '/repos/{owner}/{repo}/codespaces/permissions_check';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        $query[] = 'ref=' . \urlencode($ref);
        $query[] = 'devcontainer_path=' . \urlencode($devcontainer_path);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodespacesPermissionsCheckForDevcontainer::class, $data);
    }

    public function codespacesListRepoSecrets(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/codespaces/secrets';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesGetRepoPublicKey(string $owner, string $repo): CodespacesPublicKey
    {
        $path = '/repos/{owner}/{repo}/codespaces/secrets/public-key';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodespacesPublicKey::class, $data);
    }

    public function codespacesGetRepoSecret(string $owner, string $repo, string $secret_name): RepoCodespacesSecret
    {
        $path = '/repos/{owner}/{repo}/codespaces/secrets/{secret_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepoCodespacesSecret::class, $data);
    }

    public function codespacesDeleteRepoSecret(string $owner, string $repo, string $secret_name): void
    {
        $path = '/repos/{owner}/{repo}/codespaces/secrets/{secret_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Collaborator>
     */
    public function reposListCollaborators(
        string $owner,
        string $repo,
        ?ReposListCollaboratorsAffiliation $affiliation = null,
        ?ReposListCollaboratorsPermission $permission = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/collaborators';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($affiliation !== null) {
            $query[] = 'affiliation=' . \urlencode($affiliation->value);
        }
        if ($permission !== null) {
            $query[] = 'permission=' . \urlencode($permission->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Collaborator => $this->hydrator->hydrate(Collaborator::class, (array) $item),
            $data,
        ));
    }

    public function reposCheckCollaborator(string $owner, string $repo, string $username): void
    {
        $path = '/repos/{owner}/{repo}/collaborators/{username}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposRemoveCollaborator(string $owner, string $repo, string $username): void
    {
        $path = '/repos/{owner}/{repo}/collaborators/{username}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetCollaboratorPermissionLevel(
        string $owner,
        string $repo,
        string $username,
    ): RepositoryCollaboratorPermission {
        $path = '/repos/{owner}/{repo}/collaborators/{username}/permission';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepositoryCollaboratorPermission::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CommitComment>
     */
    public function reposListCommitCommentsForRepo(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/comments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CommitComment => $this->hydrator->hydrate(CommitComment::class, (array) $item),
            $data,
        ));
    }

    public function reposGetCommitComment(string $owner, string $repo, int $comment_id): CommitComment
    {
        $path = '/repos/{owner}/{repo}/comments/{comment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CommitComment::class, $data);
    }

    public function reposDeleteCommitComment(string $owner, string $repo, int $comment_id): void
    {
        $path = '/repos/{owner}/{repo}/comments/{comment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Reaction>
     */
    public function reactionsListForCommitComment(
        string $owner,
        string $repo,
        int $comment_id,
        ?ReactionsListForCommitCommentContent $content = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/comments/{comment_id}/reactions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $query = [];
        if ($content !== null) {
            $query[] = 'content=' . \urlencode($content->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Reaction => $this->hydrator->hydrate(Reaction::class, (array) $item),
            $data,
        ));
    }

    public function reactionsDeleteForCommitComment(
        string $owner,
        string $repo,
        int $comment_id,
        int $reaction_id,
    ): void {
        $path = '/repos/{owner}/{repo}/comments/{comment_id}/reactions/{reaction_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $path = \str_replace('{reaction_id}', (string) $reaction_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Commit>
     */
    public function reposListCommits(
        string $owner,
        string $repo,
        ?string $sha = null,
        ?string $path = null,
        ?string $author = null,
        ?string $committer = null,
        ?\DateTimeImmutable $since = null,
        ?\DateTimeImmutable $until = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/commits';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($sha !== null) {
            $query[] = 'sha=' . \urlencode($sha);
        }
        if ($path !== null) {
            $query[] = 'path=' . \urlencode($path);
        }
        if ($author !== null) {
            $query[] = 'author=' . \urlencode($author);
        }
        if ($committer !== null) {
            $query[] = 'committer=' . \urlencode($committer);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($until !== null) {
            $query[] = 'until=' . \urlencode($until->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Commit => $this->hydrator->hydrate(Commit::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\BranchShort>
     */
    public function reposListBranchesForHeadCommit(string $owner, string $repo, string $commit_sha): array
    {
        $path = '/repos/{owner}/{repo}/commits/{commit_sha}/branches-where-head';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{commit_sha}', $commit_sha, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): BranchShort => $this->hydrator->hydrate(BranchShort::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CommitComment>
     */
    public function reposListCommentsForCommit(
        string $owner,
        string $repo,
        string $commit_sha,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/commits/{commit_sha}/comments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{commit_sha}', $commit_sha, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CommitComment => $this->hydrator->hydrate(CommitComment::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PullRequestSimple>
     */
    public function reposListPullRequestsAssociatedWithCommit(
        string $owner,
        string $repo,
        string $commit_sha,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/commits/{commit_sha}/pulls';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{commit_sha}', $commit_sha, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PullRequestSimple => $this->hydrator->hydrate(PullRequestSimple::class, (array) $item),
            $data,
        ));
    }

    public function reposGetCommit(
        string $owner,
        string $repo,
        string $ref,
        ?int $page = null,
        ?int $per_page = null,
    ): Commit {
        $path = '/repos/{owner}/{repo}/commits/{ref}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Commit::class, $data);
    }

    public function checksListForRef(
        string $owner,
        string $repo,
        string $ref,
        ?string $check_name = null,
        ?ChecksListForRefStatus $status = null,
        ?ChecksListForRefFilter $filter = null,
        ?int $per_page = null,
        ?int $page = null,
        ?int $app_id = null,
    ): void {
        $path = '/repos/{owner}/{repo}/commits/{ref}/check-runs';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $query = [];
        if ($check_name !== null) {
            $query[] = 'check_name=' . \urlencode($check_name);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status->value);
        }
        if ($filter !== null) {
            $query[] = 'filter=' . \urlencode($filter->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($app_id !== null) {
            $query[] = 'app_id=' . \urlencode((string) $app_id);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function checksListSuitesForRef(
        string $owner,
        string $repo,
        string $ref,
        ?int $app_id = null,
        ?string $check_name = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/commits/{ref}/check-suites';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $query = [];
        if ($app_id !== null) {
            $query[] = 'app_id=' . \urlencode((string) $app_id);
        }
        if ($check_name !== null) {
            $query[] = 'check_name=' . \urlencode($check_name);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetCombinedStatusForRef(
        string $owner,
        string $repo,
        string $ref,
        ?int $per_page = null,
        ?int $page = null,
    ): CombinedCommitStatus {
        $path = '/repos/{owner}/{repo}/commits/{ref}/status';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CombinedCommitStatus::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Status>
     */
    public function reposListCommitStatusesForRef(
        string $owner,
        string $repo,
        string $ref,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/commits/{ref}/statuses';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Status => $this->hydrator->hydrate(Status::class, (array) $item),
            $data,
        ));
    }

    public function reposGetCommunityProfileMetrics(string $owner, string $repo): CommunityProfile
    {
        $path = '/repos/{owner}/{repo}/community/profile';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CommunityProfile::class, $data);
    }

    public function reposCompareCommits(
        string $owner,
        string $repo,
        string $basehead,
        ?int $page = null,
        ?int $per_page = null,
    ): CommitComparison {
        $path = '/repos/{owner}/{repo}/compare/{basehead}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{basehead}', $basehead, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CommitComparison::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Contributor>
     */
    public function reposListContributors(
        string $owner,
        string $repo,
        ?string $anon = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/contributors';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($anon !== null) {
            $query[] = 'anon=' . \urlencode($anon);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Contributor => $this->hydrator->hydrate(Contributor::class, (array) $item),
            $data,
        ));
    }

    public function dependabotGetAlert(string $owner, string $repo, AlertNumber $alert_number): DependabotAlert
    {
        $path = '/repos/{owner}/{repo}/dependabot/alerts/{alert_number}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{alert_number}', (string) $alert_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DependabotAlert::class, $data);
    }

    public function dependabotListRepoSecrets(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/dependabot/secrets';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dependabotGetRepoPublicKey(string $owner, string $repo): DependabotPublicKey
    {
        $path = '/repos/{owner}/{repo}/dependabot/secrets/public-key';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DependabotPublicKey::class, $data);
    }

    public function dependabotGetRepoSecret(string $owner, string $repo, string $secret_name): DependabotSecret
    {
        $path = '/repos/{owner}/{repo}/dependabot/secrets/{secret_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DependabotSecret::class, $data);
    }

    public function dependabotDeleteRepoSecret(string $owner, string $repo, string $secret_name): void
    {
        $path = '/repos/{owner}/{repo}/dependabot/secrets/{secret_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dependencyGraphDiffRange(
        string $owner,
        string $repo,
        string $basehead,
        ?string $name = null,
    ): DependencyGraphDiff {
        $path = '/repos/{owner}/{repo}/dependency-graph/compare/{basehead}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{basehead}', $basehead, $path);
        $query = [];
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DependencyGraphDiff::class, $data);
    }

    public function dependencyGraphExportSbom(string $owner, string $repo): DependencyGraphSpdxSbom
    {
        $path = '/repos/{owner}/{repo}/dependency-graph/sbom';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DependencyGraphSpdxSbom::class, $data);
    }

    public function dependencyGraphFetchSbomReport(string $owner, string $repo, string $sbom_uuid): void
    {
        $path = '/repos/{owner}/{repo}/dependency-graph/sbom/fetch-report/{sbom_uuid}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{sbom_uuid}', $sbom_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dependencyGraphGenerateSbomReport(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/dependency-graph/sbom/generate-report';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dependencyGraphCreateRepositorySnapshot(string $owner, string $repo, Snapshot $body): void
    {
        $path = '/repos/{owner}/{repo}/dependency-graph/snapshots';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Deployment>
     */
    public function reposListDeployments(
        string $owner,
        string $repo,
        ?string $sha = null,
        ?string $ref = null,
        ?string $task = null,
        ?string $environment = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/deployments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($sha !== null) {
            $query[] = 'sha=' . \urlencode($sha);
        }
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($task !== null) {
            $query[] = 'task=' . \urlencode($task);
        }
        if ($environment !== null) {
            $query[] = 'environment=' . \urlencode($environment);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Deployment => $this->hydrator->hydrate(Deployment::class, (array) $item),
            $data,
        ));
    }

    public function reposGetDeployment(string $owner, string $repo, int $deployment_id): Deployment
    {
        $path = '/repos/{owner}/{repo}/deployments/{deployment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{deployment_id}', (string) $deployment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Deployment::class, $data);
    }

    public function reposDeleteDeployment(string $owner, string $repo, int $deployment_id): void
    {
        $path = '/repos/{owner}/{repo}/deployments/{deployment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{deployment_id}', (string) $deployment_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\DeploymentStatus>
     */
    public function reposListDeploymentStatuses(
        string $owner,
        string $repo,
        int $deployment_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/deployments/{deployment_id}/statuses';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{deployment_id}', (string) $deployment_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): DeploymentStatus => $this->hydrator->hydrate(DeploymentStatus::class, (array) $item),
            $data,
        ));
    }

    public function reposGetDeploymentStatus(
        string $owner,
        string $repo,
        int $deployment_id,
        int $status_id,
    ): DeploymentStatus {
        $path = '/repos/{owner}/{repo}/deployments/{deployment_id}/statuses/{status_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{deployment_id}', (string) $deployment_id, $path);
        $path = \str_replace('{status_id}', (string) $status_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DeploymentStatus::class, $data);
    }

    public function reposGetAllEnvironments(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/environments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetEnvironment(string $owner, string $repo, string $environment_name): Environment
    {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Environment::class, $data);
    }

    public function reposDeleteAnEnvironment(string $owner, string $repo, string $environment_name): void
    {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposListDeploymentBranchPolicies(
        string $owner,
        string $repo,
        string $environment_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment-branch-policies';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposCreateDeploymentBranchPolicy(
        string $owner,
        string $repo,
        string $environment_name,
        DeploymentBranchPolicyNamePatternWithType $body,
    ): DeploymentBranchPolicy {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment-branch-policies';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DeploymentBranchPolicy::class, $data);
    }

    public function reposGetDeploymentBranchPolicy(
        string $owner,
        string $repo,
        string $environment_name,
        int $branch_policy_id,
    ): DeploymentBranchPolicy {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment-branch-policies/{branch_policy_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{branch_policy_id}', (string) $branch_policy_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DeploymentBranchPolicy::class, $data);
    }

    public function reposUpdateDeploymentBranchPolicy(
        string $owner,
        string $repo,
        string $environment_name,
        int $branch_policy_id,
        DeploymentBranchPolicyNamePattern $body,
    ): DeploymentBranchPolicy {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment-branch-policies/{branch_policy_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{branch_policy_id}', (string) $branch_policy_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DeploymentBranchPolicy::class, $data);
    }

    public function reposDeleteDeploymentBranchPolicy(
        string $owner,
        string $repo,
        string $environment_name,
        int $branch_policy_id,
    ): void {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment-branch-policies/{branch_policy_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{branch_policy_id}', (string) $branch_policy_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetAllDeploymentProtectionRules(string $environment_name, string $repo, string $owner): void
    {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment_protection_rules';
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{owner}', $owner, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposListCustomDeploymentRuleIntegrations(
        string $environment_name,
        string $repo,
        string $owner,
        ?int $page = null,
        ?int $per_page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment_protection_rules/apps';
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{owner}', $owner, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetCustomDeploymentProtectionRule(
        string $owner,
        string $repo,
        string $environment_name,
        int $protection_rule_id,
    ): DeploymentProtectionRule {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment_protection_rules/{protection_rule_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{protection_rule_id}', (string) $protection_rule_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DeploymentProtectionRule::class, $data);
    }

    public function reposDisableDeploymentProtectionRule(
        string $environment_name,
        string $repo,
        string $owner,
        int $protection_rule_id,
    ): void {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/deployment_protection_rules/{protection_rule_id}';
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{protection_rule_id}', (string) $protection_rule_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListEnvironmentSecrets(
        string $owner,
        string $repo,
        string $environment_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/secrets';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetEnvironmentPublicKey(
        string $owner,
        string $repo,
        string $environment_name,
    ): ActionsPublicKey {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/secrets/public-key';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsPublicKey::class, $data);
    }

    public function actionsGetEnvironmentSecret(
        string $owner,
        string $repo,
        string $environment_name,
        string $secret_name,
    ): ActionsSecret {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/secrets/{secret_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsSecret::class, $data);
    }

    public function actionsDeleteEnvironmentSecret(
        string $owner,
        string $repo,
        string $environment_name,
        string $secret_name,
    ): void {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/secrets/{secret_name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsListEnvironmentVariables(
        string $owner,
        string $repo,
        string $environment_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/variables';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actionsGetEnvironmentVariable(
        string $owner,
        string $repo,
        string $environment_name,
        string $name,
    ): ActionsVariable {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/variables/{name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ActionsVariable::class, $data);
    }

    public function actionsDeleteEnvironmentVariable(
        string $owner,
        string $repo,
        string $name,
        string $environment_name,
    ): void {
        $path = '/repos/{owner}/{repo}/environments/{environment_name}/variables/{name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{name}', $name, $path);
        $path = \str_replace('{environment_name}', $environment_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListRepoEvents(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/events';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function reposListForks(
        string $owner,
        string $repo,
        ?ReposListForksSort $sort = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/forks';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    public function gitGetBlob(string $owner, string $repo, string $file_sha): Blob
    {
        $path = '/repos/{owner}/{repo}/git/blobs/{file_sha}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{file_sha}', $file_sha, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Blob::class, $data);
    }

    public function gitGetCommit(string $owner, string $repo, string $commit_sha): GitCommit
    {
        $path = '/repos/{owner}/{repo}/git/commits/{commit_sha}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{commit_sha}', $commit_sha, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GitCommit::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\GitRef>
     */
    public function gitListMatchingRefs(string $owner, string $repo, string $ref): array
    {
        $path = '/repos/{owner}/{repo}/git/matching-refs/{ref}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): GitRef => $this->hydrator->hydrate(GitRef::class, (array) $item),
            $data,
        ));
    }

    public function gitGetRef(string $owner, string $repo, string $ref): GitRef
    {
        $path = '/repos/{owner}/{repo}/git/ref/{ref}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GitRef::class, $data);
    }

    public function gitDeleteRef(string $owner, string $repo, string $ref): void
    {
        $path = '/repos/{owner}/{repo}/git/refs/{ref}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function gitGetTag(string $owner, string $repo, string $tag_sha): GitTag
    {
        $path = '/repos/{owner}/{repo}/git/tags/{tag_sha}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{tag_sha}', $tag_sha, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GitTag::class, $data);
    }

    public function gitGetTree(string $owner, string $repo, string $tree_sha, ?string $recursive = null): GitTree
    {
        $path = '/repos/{owner}/{repo}/git/trees/{tree_sha}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{tree_sha}', $tree_sha, $path);
        $query = [];
        if ($recursive !== null) {
            $query[] = 'recursive=' . \urlencode($recursive);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GitTree::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Hook>
     */
    public function reposListWebhooks(string $owner, string $repo, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/repos/{owner}/{repo}/hooks';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Hook => $this->hydrator->hydrate(Hook::class, (array) $item),
            $data,
        ));
    }

    public function reposGetWebhook(string $owner, string $repo, int $hook_id): Hook
    {
        $path = '/repos/{owner}/{repo}/hooks/{hook_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Hook::class, $data);
    }

    public function reposDeleteWebhook(string $owner, string $repo, int $hook_id): void
    {
        $path = '/repos/{owner}/{repo}/hooks/{hook_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetWebhookConfigForRepo(string $owner, string $repo, int $hook_id): WebhookConfig
    {
        $path = '/repos/{owner}/{repo}/hooks/{hook_id}/config';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(WebhookConfig::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\HookDeliveryItem>
     */
    public function reposListWebhookDeliveries(
        string $owner,
        string $repo,
        int $hook_id,
        ?int $per_page = null,
        ?string $cursor = null,
        ?ReposListWebhookDeliveriesStatus $status = null,
    ): array {
        $path = '/repos/{owner}/{repo}/hooks/{hook_id}/deliveries';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($cursor !== null) {
            $query[] = 'cursor=' . \urlencode($cursor);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): HookDeliveryItem => $this->hydrator->hydrate(HookDeliveryItem::class, (array) $item),
            $data,
        ));
    }

    public function reposGetWebhookDelivery(string $owner, string $repo, int $hook_id, int $delivery_id): HookDelivery
    {
        $path = '/repos/{owner}/{repo}/hooks/{hook_id}/deliveries/{delivery_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $path = \str_replace('{delivery_id}', (string) $delivery_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(HookDelivery::class, $data);
    }

    public function reposRedeliverWebhookDelivery(string $owner, string $repo, int $hook_id, int $delivery_id): void
    {
        $path = '/repos/{owner}/{repo}/hooks/{hook_id}/deliveries/{delivery_id}/attempts';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $path = \str_replace('{delivery_id}', (string) $delivery_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposPingWebhook(string $owner, string $repo, int $hook_id): void
    {
        $path = '/repos/{owner}/{repo}/hooks/{hook_id}/pings';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposTestPushWebhook(string $owner, string $repo, int $hook_id): void
    {
        $path = '/repos/{owner}/{repo}/hooks/{hook_id}/tests';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{hook_id}', (string) $hook_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposCheckImmutableReleases(string $owner, string $repo): CheckImmutableReleases
    {
        $path = '/repos/{owner}/{repo}/immutable-releases';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CheckImmutableReleases::class, $data);
    }

    public function reposEnableImmutableReleases(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/immutable-releases';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposDisableImmutableReleases(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/immutable-releases';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function migrationsGetImportStatus(string $owner, string $repo): Import
    {
        $path = '/repos/{owner}/{repo}/import';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Import::class, $data);
    }

    public function migrationsCancelImport(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/import';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PorterAuthor>
     */
    public function migrationsGetCommitAuthors(string $owner, string $repo, ?int $since = null): array
    {
        $path = '/repos/{owner}/{repo}/import/authors';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode((string) $since);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PorterAuthor => $this->hydrator->hydrate(PorterAuthor::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PorterLargeFile>
     */
    public function migrationsGetLargeFiles(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/import/large_files';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PorterLargeFile => $this->hydrator->hydrate(PorterLargeFile::class, (array) $item),
            $data,
        ));
    }

    public function appsGetRepoInstallation(string $owner, string $repo): Installation
    {
        $path = '/repos/{owner}/{repo}/installation';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Installation::class, $data);
    }

    public function interactionsGetRestrictionsForRepo(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/interaction-limits';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function interactionsSetRestrictionsForRepo(
        string $owner,
        string $repo,
        InteractionLimit $body,
    ): InteractionLimitResponse {
        $path = '/repos/{owner}/{repo}/interaction-limits';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(InteractionLimitResponse::class, $data);
    }

    public function interactionsRemoveRestrictionsForRepo(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/interaction-limits';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RepositoryInvitation>
     */
    public function reposListInvitations(string $owner, string $repo, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/repos/{owner}/{repo}/invitations';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RepositoryInvitation => $this->hydrator->hydrate(RepositoryInvitation::class, (array) $item),
            $data,
        ));
    }

    public function reposDeleteInvitation(string $owner, string $repo, int $invitation_id): void
    {
        $path = '/repos/{owner}/{repo}/invitations/{invitation_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{invitation_id}', (string) $invitation_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Issue>
     */
    public function issuesListForRepo(
        string $owner,
        string $repo,
        ?string $milestone = null,
        ?IssuesListForRepoState $state = null,
        ?string $assignee = null,
        ?string $type = null,
        ?string $creator = null,
        ?string $mentioned = null,
        ?string $labels = null,
        ?IssuesListForRepoSort $sort = null,
        ?IssuesListForRepoDirection $direction = null,
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($milestone !== null) {
            $query[] = 'milestone=' . \urlencode($milestone);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($assignee !== null) {
            $query[] = 'assignee=' . \urlencode($assignee);
        }
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type);
        }
        if ($creator !== null) {
            $query[] = 'creator=' . \urlencode($creator);
        }
        if ($mentioned !== null) {
            $query[] = 'mentioned=' . \urlencode($mentioned);
        }
        if ($labels !== null) {
            $query[] = 'labels=' . \urlencode($labels);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Issue => $this->hydrator->hydrate(Issue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\IssueComment>
     */
    public function issuesListCommentsForRepo(
        string $owner,
        string $repo,
        ?IssuesListCommentsForRepoSort $sort = null,
        ?IssuesListCommentsForRepoDirection $direction = null,
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/comments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): IssueComment => $this->hydrator->hydrate(IssueComment::class, (array) $item),
            $data,
        ));
    }

    public function issuesGetComment(string $owner, string $repo, int $comment_id): IssueComment
    {
        $path = '/repos/{owner}/{repo}/issues/comments/{comment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(IssueComment::class, $data);
    }

    public function issuesDeleteComment(string $owner, string $repo, int $comment_id): void
    {
        $path = '/repos/{owner}/{repo}/issues/comments/{comment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function issuesPinComment(string $owner, string $repo, int $comment_id): IssueComment
    {
        $path = '/repos/{owner}/{repo}/issues/comments/{comment_id}/pin';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(IssueComment::class, $data);
    }

    public function issuesUnpinComment(string $owner, string $repo, int $comment_id): void
    {
        $path = '/repos/{owner}/{repo}/issues/comments/{comment_id}/pin';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Reaction>
     */
    public function reactionsListForIssueComment(
        string $owner,
        string $repo,
        int $comment_id,
        ?ReactionsListForIssueCommentContent $content = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/comments/{comment_id}/reactions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $query = [];
        if ($content !== null) {
            $query[] = 'content=' . \urlencode($content->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Reaction => $this->hydrator->hydrate(Reaction::class, (array) $item),
            $data,
        ));
    }

    public function reactionsDeleteForIssueComment(
        string $owner,
        string $repo,
        int $comment_id,
        int $reaction_id,
    ): void {
        $path = '/repos/{owner}/{repo}/issues/comments/{comment_id}/reactions/{reaction_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $path = \str_replace('{reaction_id}', (string) $reaction_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\IssueEvent>
     */
    public function issuesListEventsForRepo(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/events';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): IssueEvent => $this->hydrator->hydrate(IssueEvent::class, (array) $item),
            $data,
        ));
    }

    public function issuesGetEvent(string $owner, string $repo, int $event_id): IssueEvent
    {
        $path = '/repos/{owner}/{repo}/issues/events/{event_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{event_id}', (string) $event_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(IssueEvent::class, $data);
    }

    public function issuesGet(string $owner, string $repo, int $issue_number): Issue
    {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Issue::class, $data);
    }

    public function issuesCheckUserCanBeAssignedToIssue(
        string $owner,
        string $repo,
        int $issue_number,
        string $assignee,
    ): void {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/assignees/{assignee}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $path = \str_replace('{assignee}', $assignee, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\IssueComment>
     */
    public function issuesListComments(
        string $owner,
        string $repo,
        int $issue_number,
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/comments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): IssueComment => $this->hydrator->hydrate(IssueComment::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Issue>
     */
    public function issuesListDependenciesBlockedBy(
        string $owner,
        string $repo,
        int $issue_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/dependencies/blocked_by';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Issue => $this->hydrator->hydrate(Issue::class, (array) $item),
            $data,
        ));
    }

    public function issuesRemoveDependencyBlockedBy(
        string $owner,
        string $repo,
        int $issue_number,
        int $issue_id,
    ): Issue {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/dependencies/blocked_by/{issue_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $path = \str_replace('{issue_id}', (string) $issue_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Issue::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Issue>
     */
    public function issuesListDependenciesBlocking(
        string $owner,
        string $repo,
        int $issue_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/dependencies/blocking';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Issue => $this->hydrator->hydrate(Issue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\IssueEventForIssue>
     */
    public function issuesListEvents(
        string $owner,
        string $repo,
        int $issue_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/events';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): IssueEventForIssue => $this->hydrator->hydrate(IssueEventForIssue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\IssueFieldValue>
     */
    public function issuesListIssueFieldValuesForIssue(
        string $owner,
        string $repo,
        int $issue_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/issue-field-values';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): IssueFieldValue => $this->hydrator->hydrate(IssueFieldValue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Label>
     */
    public function issuesListLabelsOnIssue(
        string $owner,
        string $repo,
        int $issue_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/labels';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Label => $this->hydrator->hydrate(Label::class, (array) $item),
            $data,
        ));
    }

    public function issuesRemoveAllLabels(string $owner, string $repo, int $issue_number): void
    {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/labels';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Label>
     */
    public function issuesRemoveLabel(string $owner, string $repo, int $issue_number, string $name): array
    {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/labels/{name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Label => $this->hydrator->hydrate(Label::class, (array) $item),
            $data,
        ));
    }

    public function issuesUnlock(string $owner, string $repo, int $issue_number): void
    {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/lock';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function issuesGetParent(string $owner, string $repo, int $issue_number): Issue
    {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/parent';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Issue::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Reaction>
     */
    public function reactionsListForIssue(
        string $owner,
        string $repo,
        int $issue_number,
        ?ReactionsListForIssueContent $content = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/reactions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($content !== null) {
            $query[] = 'content=' . \urlencode($content->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Reaction => $this->hydrator->hydrate(Reaction::class, (array) $item),
            $data,
        ));
    }

    public function reactionsDeleteForIssue(string $owner, string $repo, int $issue_number, int $reaction_id): void
    {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/reactions/{reaction_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $path = \str_replace('{reaction_id}', (string) $reaction_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Issue>
     */
    public function issuesListSubIssues(
        string $owner,
        string $repo,
        int $issue_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/sub_issues';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Issue => $this->hydrator->hydrate(Issue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\TimelineIssueEvents>
     */
    public function issuesListEventsForTimeline(
        string $owner,
        string $repo,
        int $issue_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/issues/{issue_number}/timeline';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): TimelineIssueEvents => $this->hydrator->hydrate(TimelineIssueEvents::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\DeployKey>
     */
    public function reposListDeployKeys(string $owner, string $repo, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/repos/{owner}/{repo}/keys';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): DeployKey => $this->hydrator->hydrate(DeployKey::class, (array) $item),
            $data,
        ));
    }

    public function reposGetDeployKey(string $owner, string $repo, int $key_id): DeployKey
    {
        $path = '/repos/{owner}/{repo}/keys/{key_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{key_id}', (string) $key_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DeployKey::class, $data);
    }

    public function reposDeleteDeployKey(string $owner, string $repo, int $key_id): void
    {
        $path = '/repos/{owner}/{repo}/keys/{key_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{key_id}', (string) $key_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Label>
     */
    public function issuesListLabelsForRepo(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/labels';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Label => $this->hydrator->hydrate(Label::class, (array) $item),
            $data,
        ));
    }

    public function issuesGetLabel(string $owner, string $repo, string $name): Label
    {
        $path = '/repos/{owner}/{repo}/labels/{name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Label::class, $data);
    }

    public function issuesDeleteLabel(string $owner, string $repo, string $name): void
    {
        $path = '/repos/{owner}/{repo}/labels/{name}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{name}', $name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposListLanguages(string $owner, string $repo): Language
    {
        $path = '/repos/{owner}/{repo}/languages';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Language::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Milestone>
     */
    public function issuesListMilestones(
        string $owner,
        string $repo,
        ?IssuesListMilestonesState $state = null,
        ?IssuesListMilestonesSort $sort = null,
        ?IssuesListMilestonesDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/milestones';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Milestone => $this->hydrator->hydrate(Milestone::class, (array) $item),
            $data,
        ));
    }

    public function issuesGetMilestone(string $owner, string $repo, int $milestone_number): Milestone
    {
        $path = '/repos/{owner}/{repo}/milestones/{milestone_number}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{milestone_number}', (string) $milestone_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Milestone::class, $data);
    }

    public function issuesDeleteMilestone(string $owner, string $repo, int $milestone_number): void
    {
        $path = '/repos/{owner}/{repo}/milestones/{milestone_number}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{milestone_number}', (string) $milestone_number, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Label>
     */
    public function issuesListLabelsForMilestone(
        string $owner,
        string $repo,
        int $milestone_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/milestones/{milestone_number}/labels';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{milestone_number}', (string) $milestone_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Label => $this->hydrator->hydrate(Label::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Thread>
     */
    public function activityListRepoNotificationsForAuthenticatedUser(
        string $owner,
        string $repo,
        ?bool $all = null,
        ?bool $participating = null,
        ?\DateTimeImmutable $since = null,
        ?\DateTimeImmutable $before = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/notifications';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($all !== null) {
            $query[] = 'all=' . \urlencode((string) $all);
        }
        if ($participating !== null) {
            $query[] = 'participating=' . \urlencode((string) $participating);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Thread => $this->hydrator->hydrate(Thread::class, (array) $item),
            $data,
        ));
    }

    public function reposGetPages(string $owner, string $repo): Page
    {
        $path = '/repos/{owner}/{repo}/pages';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Page::class, $data);
    }

    public function reposDeletePagesSite(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/pages';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PageBuild>
     */
    public function reposListPagesBuilds(string $owner, string $repo, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/repos/{owner}/{repo}/pages/builds';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PageBuild => $this->hydrator->hydrate(PageBuild::class, (array) $item),
            $data,
        ));
    }

    public function reposRequestPagesBuild(string $owner, string $repo): PageBuildStatus
    {
        $path = '/repos/{owner}/{repo}/pages/builds';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PageBuildStatus::class, $data);
    }

    public function reposGetLatestPagesBuild(string $owner, string $repo): PageBuild
    {
        $path = '/repos/{owner}/{repo}/pages/builds/latest';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PageBuild::class, $data);
    }

    public function reposGetPagesBuild(string $owner, string $repo, int $build_id): PageBuild
    {
        $path = '/repos/{owner}/{repo}/pages/builds/{build_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{build_id}', (string) $build_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PageBuild::class, $data);
    }

    public function reposGetPagesDeployment(string $owner, string $repo, $pages_deployment_id): PagesDeploymentStatus
    {
        $path = '/repos/{owner}/{repo}/pages/deployments/{pages_deployment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pages_deployment_id}', (string) $pages_deployment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PagesDeploymentStatus::class, $data);
    }

    public function reposCancelPagesDeployment(string $owner, string $repo, $pages_deployment_id): void
    {
        $path = '/repos/{owner}/{repo}/pages/deployments/{pages_deployment_id}/cancel';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pages_deployment_id}', (string) $pages_deployment_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetPagesHealthCheck(string $owner, string $repo): PagesHealthCheck
    {
        $path = '/repos/{owner}/{repo}/pages/health';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PagesHealthCheck::class, $data);
    }

    public function reposCheckPrivateVulnerabilityReporting(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/private-vulnerability-reporting';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposEnablePrivateVulnerabilityReporting(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/private-vulnerability-reporting';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposDisablePrivateVulnerabilityReporting(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/private-vulnerability-reporting';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CustomPropertyValue>
     */
    public function reposCustomPropertiesForReposGetRepositoryValues(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/properties/values';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CustomPropertyValue => $this->hydrator->hydrate(CustomPropertyValue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PullRequestSimple>
     */
    public function pullsList(
        string $owner,
        string $repo,
        ?PullsListState $state = null,
        ?string $head = null,
        ?string $base = null,
        ?PullsListSort $sort = null,
        ?PullsListDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/pulls';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($head !== null) {
            $query[] = 'head=' . \urlencode($head);
        }
        if ($base !== null) {
            $query[] = 'base=' . \urlencode($base);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PullRequestSimple => $this->hydrator->hydrate(PullRequestSimple::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PullRequestReviewComment>
     */
    public function pullsListReviewCommentsForRepo(
        string $owner,
        string $repo,
        ?PullsListReviewCommentsForRepoSort $sort = null,
        ?PullsListReviewCommentsForRepoDirection $direction = null,
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/pulls/comments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PullRequestReviewComment => $this->hydrator->hydrate(PullRequestReviewComment::class, (array) $item),
            $data,
        ));
    }

    public function pullsGetReviewComment(string $owner, string $repo, int $comment_id): PullRequestReviewComment
    {
        $path = '/repos/{owner}/{repo}/pulls/comments/{comment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PullRequestReviewComment::class, $data);
    }

    public function pullsDeleteReviewComment(string $owner, string $repo, int $comment_id): void
    {
        $path = '/repos/{owner}/{repo}/pulls/comments/{comment_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Reaction>
     */
    public function reactionsListForPullRequestReviewComment(
        string $owner,
        string $repo,
        int $comment_id,
        ?ReactionsListForPullRequestReviewCommentContent $content = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/pulls/comments/{comment_id}/reactions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $query = [];
        if ($content !== null) {
            $query[] = 'content=' . \urlencode($content->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Reaction => $this->hydrator->hydrate(Reaction::class, (array) $item),
            $data,
        ));
    }

    public function reactionsDeleteForPullRequestComment(
        string $owner,
        string $repo,
        int $comment_id,
        int $reaction_id,
    ): void {
        $path = '/repos/{owner}/{repo}/pulls/comments/{comment_id}/reactions/{reaction_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{comment_id}', (string) $comment_id, $path);
        $path = \str_replace('{reaction_id}', (string) $reaction_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function pullsGet(string $owner, string $repo, int $pull_number): PullRequest
    {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PullRequest::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PullRequestReviewComment>
     */
    public function pullsListReviewComments(
        string $owner,
        string $repo,
        int $pull_number,
        ?PullsListReviewCommentsSort $sort = null,
        ?PullsListReviewCommentsDirection $direction = null,
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/comments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $query = [];
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PullRequestReviewComment => $this->hydrator->hydrate(PullRequestReviewComment::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Commit>
     */
    public function pullsListCommits(
        string $owner,
        string $repo,
        int $pull_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/commits';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Commit => $this->hydrator->hydrate(Commit::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\DiffEntry>
     */
    public function pullsListFiles(
        string $owner,
        string $repo,
        int $pull_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/files';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): DiffEntry => $this->hydrator->hydrate(DiffEntry::class, (array) $item),
            $data,
        ));
    }

    public function pullsCheckIfMerged(string $owner, string $repo, int $pull_number): void
    {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/merge';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function pullsListRequestedReviewers(
        string $owner,
        string $repo,
        int $pull_number,
    ): PullRequestReviewRequest {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/requested_reviewers';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PullRequestReviewRequest::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PullRequestReview>
     */
    public function pullsListReviews(
        string $owner,
        string $repo,
        int $pull_number,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/reviews';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PullRequestReview => $this->hydrator->hydrate(PullRequestReview::class, (array) $item),
            $data,
        ));
    }

    public function pullsGetReview(string $owner, string $repo, int $pull_number, int $review_id): PullRequestReview
    {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $path = \str_replace('{review_id}', (string) $review_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PullRequestReview::class, $data);
    }

    public function pullsDeletePendingReview(
        string $owner,
        string $repo,
        int $pull_number,
        int $review_id,
    ): PullRequestReview {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $path = \str_replace('{review_id}', (string) $review_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PullRequestReview::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ReviewComment>
     */
    public function pullsListCommentsForReview(
        string $owner,
        string $repo,
        int $pull_number,
        int $review_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id}/comments';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{pull_number}', (string) $pull_number, $path);
        $path = \str_replace('{review_id}', (string) $review_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ReviewComment => $this->hydrator->hydrate(ReviewComment::class, (array) $item),
            $data,
        ));
    }

    public function reposGetReadme(string $owner, string $repo, ?string $ref = null): ContentFile
    {
        $path = '/repos/{owner}/{repo}/readme';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ContentFile::class, $data);
    }

    public function reposGetReadmeInDirectory(
        string $owner,
        string $repo,
        string $dir,
        ?string $ref = null,
    ): ContentFile {
        $path = '/repos/{owner}/{repo}/readme/{dir}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{dir}', $dir, $path);
        $query = [];
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ContentFile::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Release>
     */
    public function reposListReleases(string $owner, string $repo, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/repos/{owner}/{repo}/releases';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Release => $this->hydrator->hydrate(Release::class, (array) $item),
            $data,
        ));
    }

    public function reposGetReleaseAsset(string $owner, string $repo, int $asset_id): ReleaseAsset
    {
        $path = '/repos/{owner}/{repo}/releases/assets/{asset_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{asset_id}', (string) $asset_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ReleaseAsset::class, $data);
    }

    public function reposDeleteReleaseAsset(string $owner, string $repo, int $asset_id): void
    {
        $path = '/repos/{owner}/{repo}/releases/assets/{asset_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{asset_id}', (string) $asset_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposGetLatestRelease(string $owner, string $repo): Release
    {
        $path = '/repos/{owner}/{repo}/releases/latest';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Release::class, $data);
    }

    public function reposGetReleaseByTag(string $owner, string $repo, string $tag): Release
    {
        $path = '/repos/{owner}/{repo}/releases/tags/{tag}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{tag}', $tag, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Release::class, $data);
    }

    public function reposGetRelease(string $owner, string $repo, int $release_id): Release
    {
        $path = '/repos/{owner}/{repo}/releases/{release_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{release_id}', (string) $release_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Release::class, $data);
    }

    public function reposDeleteRelease(string $owner, string $repo, int $release_id): void
    {
        $path = '/repos/{owner}/{repo}/releases/{release_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{release_id}', (string) $release_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ReleaseAsset>
     */
    public function reposListReleaseAssets(
        string $owner,
        string $repo,
        int $release_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/releases/{release_id}/assets';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{release_id}', (string) $release_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ReleaseAsset => $this->hydrator->hydrate(ReleaseAsset::class, (array) $item),
            $data,
        ));
    }

    /**
     * @psalm-return never
     *
     * TODO(multipart): see task 011 — unsupported body content type
     * Body content-type: application/octet-stream
     */
    public function reposUploadReleaseAsset(
        string $owner,
        string $repo,
        int $release_id,
        string $name,
        ?string $label = null,
    ): never {
        throw new \RuntimeException('application/octet-stream not yet supported: operationId \'repos/upload-release-asset\'');
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Reaction>
     */
    public function reactionsListForRelease(
        string $owner,
        string $repo,
        int $release_id,
        ?ReactionsListForReleaseContent $content = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/releases/{release_id}/reactions';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{release_id}', (string) $release_id, $path);
        $query = [];
        if ($content !== null) {
            $query[] = 'content=' . \urlencode($content->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Reaction => $this->hydrator->hydrate(Reaction::class, (array) $item),
            $data,
        ));
    }

    public function reactionsDeleteForRelease(string $owner, string $repo, int $release_id, int $reaction_id): void
    {
        $path = '/repos/{owner}/{repo}/releases/{release_id}/reactions/{reaction_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{release_id}', (string) $release_id, $path);
        $path = \str_replace('{reaction_id}', (string) $reaction_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RepositoryRuleDetailed>
     */
    public function reposGetBranchRules(
        string $owner,
        string $repo,
        string $branch,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/rules/branches/{branch}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{branch}', $branch, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RepositoryRuleDetailed => $this->hydrator->hydrate(RepositoryRuleDetailed::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RepositoryRuleset>
     */
    public function reposGetRepoRulesets(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
        ?bool $includes_parents = null,
        ?string $targets = null,
    ): array {
        $path = '/repos/{owner}/{repo}/rulesets';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($includes_parents !== null) {
            $query[] = 'includes_parents=' . \urlencode((string) $includes_parents);
        }
        if ($targets !== null) {
            $query[] = 'targets=' . \urlencode($targets);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RepositoryRuleset => $this->hydrator->hydrate(RepositoryRuleset::class, (array) $item),
            $data,
        ));
    }

    public function reposGetRepoRuleSuites(
        string $owner,
        string $repo,
        ?string $ref = null,
        ?ReposGetRepoRuleSuitesTimePeriod $time_period = null,
        ?string $actor_name = null,
        ?ReposGetRepoRuleSuitesRuleSuiteResult $rule_suite_result = null,
        ?int $per_page = null,
        ?int $page = null,
    ): RuleSuites {
        $path = '/repos/{owner}/{repo}/rulesets/rule-suites';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($ref !== null) {
            $query[] = 'ref=' . \urlencode($ref);
        }
        if ($time_period !== null) {
            $query[] = 'time_period=' . \urlencode($time_period->value);
        }
        if ($actor_name !== null) {
            $query[] = 'actor_name=' . \urlencode($actor_name);
        }
        if ($rule_suite_result !== null) {
            $query[] = 'rule_suite_result=' . \urlencode($rule_suite_result->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RuleSuites::class, $data);
    }

    public function reposGetRepoRuleSuite(string $owner, string $repo, int $rule_suite_id): RuleSuite
    {
        $path = '/repos/{owner}/{repo}/rulesets/rule-suites/{rule_suite_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{rule_suite_id}', (string) $rule_suite_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RuleSuite::class, $data);
    }

    public function reposGetRepoRuleset(
        string $owner,
        string $repo,
        int $ruleset_id,
        ?bool $includes_parents = null,
    ): RepositoryRuleset {
        $path = '/repos/{owner}/{repo}/rulesets/{ruleset_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ruleset_id}', (string) $ruleset_id, $path);
        $query = [];
        if ($includes_parents !== null) {
            $query[] = 'includes_parents=' . \urlencode((string) $includes_parents);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepositoryRuleset::class, $data);
    }

    public function reposDeleteRepoRuleset(string $owner, string $repo, int $ruleset_id): void
    {
        $path = '/repos/{owner}/{repo}/rulesets/{ruleset_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ruleset_id}', (string) $ruleset_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RulesetVersion>
     */
    public function reposGetRepoRulesetHistory(
        string $owner,
        string $repo,
        int $ruleset_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/rulesets/{ruleset_id}/history';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ruleset_id}', (string) $ruleset_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RulesetVersion => $this->hydrator->hydrate(RulesetVersion::class, (array) $item),
            $data,
        ));
    }

    public function reposGetRepoRulesetVersion(
        string $owner,
        string $repo,
        int $ruleset_id,
        int $version_id,
    ): RulesetVersionWithState {
        $path = '/repos/{owner}/{repo}/rulesets/{ruleset_id}/history/{version_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ruleset_id}', (string) $ruleset_id, $path);
        $path = \str_replace('{version_id}', (string) $version_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RulesetVersionWithState::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SecretScanningAlert>
     */
    public function secretScanningListAlertsForRepo(
        string $owner,
        string $repo,
        ?SecretScanningListAlertsForRepoState $state = null,
        ?string $secret_type = null,
        ?string $exclude_secret_types = null,
        ?string $exclude_providers = null,
        ?string $providers = null,
        ?string $resolution = null,
        ?string $assignee = null,
        ?SecretScanningListAlertsForRepoSort $sort = null,
        ?SecretScanningListAlertsForRepoDirection $direction = null,
        ?int $page = null,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $validity = null,
        ?bool $is_publicly_leaked = null,
        ?bool $is_multi_repo = null,
        ?bool $hide_secret = null,
    ): array {
        $path = '/repos/{owner}/{repo}/secret-scanning/alerts';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($secret_type !== null) {
            $query[] = 'secret_type=' . \urlencode($secret_type);
        }
        if ($exclude_secret_types !== null) {
            $query[] = 'exclude_secret_types=' . \urlencode($exclude_secret_types);
        }
        if ($exclude_providers !== null) {
            $query[] = 'exclude_providers=' . \urlencode($exclude_providers);
        }
        if ($providers !== null) {
            $query[] = 'providers=' . \urlencode($providers);
        }
        if ($resolution !== null) {
            $query[] = 'resolution=' . \urlencode($resolution);
        }
        if ($assignee !== null) {
            $query[] = 'assignee=' . \urlencode($assignee);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($validity !== null) {
            $query[] = 'validity=' . \urlencode($validity);
        }
        if ($is_publicly_leaked !== null) {
            $query[] = 'is_publicly_leaked=' . \urlencode((string) $is_publicly_leaked);
        }
        if ($is_multi_repo !== null) {
            $query[] = 'is_multi_repo=' . \urlencode((string) $is_multi_repo);
        }
        if ($hide_secret !== null) {
            $query[] = 'hide_secret=' . \urlencode((string) $hide_secret);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SecretScanningAlert => $this->hydrator->hydrate(SecretScanningAlert::class, (array) $item),
            $data,
        ));
    }

    public function secretScanningGetAlert(
        string $owner,
        string $repo,
        AlertNumber $alert_number,
        ?bool $hide_secret = null,
    ): SecretScanningAlert {
        $path = '/repos/{owner}/{repo}/secret-scanning/alerts/{alert_number}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{alert_number}', (string) $alert_number, $path);
        $query = [];
        if ($hide_secret !== null) {
            $query[] = 'hide_secret=' . \urlencode((string) $hide_secret);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SecretScanningAlert::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SecretScanningLocation>
     */
    public function secretScanningListLocationsForAlert(
        string $owner,
        string $repo,
        AlertNumber $alert_number,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/secret-scanning/alerts/{alert_number}/locations';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{alert_number}', (string) $alert_number, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SecretScanningLocation => $this->hydrator->hydrate(SecretScanningLocation::class, (array) $item),
            $data,
        ));
    }

    public function secretScanningGetScanHistory(string $owner, string $repo): SecretScanningScanHistory
    {
        $path = '/repos/{owner}/{repo}/secret-scanning/scan-history';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SecretScanningScanHistory::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RepositoryAdvisory>
     */
    public function securityAdvisoriesListRepositoryAdvisories(
        string $owner,
        string $repo,
        ?SecurityAdvisoriesListRepositoryAdvisoriesDirection $direction = null,
        ?SecurityAdvisoriesListRepositoryAdvisoriesSort $sort = null,
        ?string $before = null,
        ?string $after = null,
        ?int $per_page = null,
        ?SecurityAdvisoriesListRepositoryAdvisoriesState $state = null,
    ): array {
        $path = '/repos/{owner}/{repo}/security-advisories';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RepositoryAdvisory => $this->hydrator->hydrate(RepositoryAdvisory::class, (array) $item),
            $data,
        ));
    }

    public function securityAdvisoriesCreateRepositoryAdvisory(
        string $owner,
        string $repo,
        RepositoryAdvisoryCreate $body,
    ): RepositoryAdvisory {
        $path = '/repos/{owner}/{repo}/security-advisories';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepositoryAdvisory::class, $data);
    }

    public function securityAdvisoriesCreatePrivateVulnerabilityReport(
        string $owner,
        string $repo,
        PrivateVulnerabilityReportCreate $body,
    ): RepositoryAdvisory {
        $path = '/repos/{owner}/{repo}/security-advisories/reports';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepositoryAdvisory::class, $data);
    }

    public function securityAdvisoriesGetRepositoryAdvisory(
        string $owner,
        string $repo,
        string $ghsa_id,
    ): RepositoryAdvisory {
        $path = '/repos/{owner}/{repo}/security-advisories/{ghsa_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ghsa_id}', $ghsa_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepositoryAdvisory::class, $data);
    }

    public function securityAdvisoriesUpdateRepositoryAdvisory(
        string $owner,
        string $repo,
        string $ghsa_id,
        RepositoryAdvisoryUpdate $body,
    ): RepositoryAdvisory {
        $path = '/repos/{owner}/{repo}/security-advisories/{ghsa_id}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ghsa_id}', $ghsa_id, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepositoryAdvisory::class, $data);
    }

    public function securityAdvisoriesCreateRepositoryAdvisoryCveRequest(
        string $owner,
        string $repo,
        string $ghsa_id,
    ): void {
        $path = '/repos/{owner}/{repo}/security-advisories/{ghsa_id}/cve';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ghsa_id}', $ghsa_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function securityAdvisoriesCreateFork(string $owner, string $repo, string $ghsa_id): FullRepository
    {
        $path = '/repos/{owner}/{repo}/security-advisories/{ghsa_id}/forks';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ghsa_id}', $ghsa_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(FullRepository::class, $data);
    }

    public function activityListStargazersForRepo(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/repos/{owner}/{repo}/stargazers';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CodeFrequencyStat>
     */
    public function reposGetCodeFrequencyStats(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/stats/code_frequency';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CodeFrequencyStat => $this->hydrator->hydrate(CodeFrequencyStat::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CommitActivity>
     */
    public function reposGetCommitActivityStats(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/stats/commit_activity';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CommitActivity => $this->hydrator->hydrate(CommitActivity::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ContributorActivity>
     */
    public function reposGetContributorsStats(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/stats/contributors';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ContributorActivity => $this->hydrator->hydrate(ContributorActivity::class, (array) $item),
            $data,
        ));
    }

    public function reposGetParticipationStats(string $owner, string $repo): ParticipationStats
    {
        $path = '/repos/{owner}/{repo}/stats/participation';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ParticipationStats::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\CodeFrequencyStat>
     */
    public function reposGetPunchCardStats(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/stats/punch_card';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): CodeFrequencyStat => $this->hydrator->hydrate(CodeFrequencyStat::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function activityListWatchersForRepo(
        string $owner,
        string $repo,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/repos/{owner}/{repo}/subscribers';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function activityGetRepoSubscription(string $owner, string $repo): RepositorySubscription
    {
        $path = '/repos/{owner}/{repo}/subscription';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(RepositorySubscription::class, $data);
    }

    public function activityDeleteRepoSubscription(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/subscription';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Tag>
     */
    public function reposListTags(string $owner, string $repo, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/repos/{owner}/{repo}/tags';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Tag => $this->hydrator->hydrate(Tag::class, (array) $item),
            $data,
        ));
    }

    public function reposDownloadTarballArchive(string $owner, string $repo, string $ref): void
    {
        $path = '/repos/{owner}/{repo}/tarball/{ref}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Team>
     */
    public function reposListTeams(string $owner, string $repo, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/repos/{owner}/{repo}/teams';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Team => $this->hydrator->hydrate(Team::class, (array) $item),
            $data,
        ));
    }

    public function reposGetAllTopics(string $owner, string $repo, ?int $page = null, ?int $per_page = null): Topic
    {
        $path = '/repos/{owner}/{repo}/topics';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Topic::class, $data);
    }

    public function reposGetClones(string $owner, string $repo, ?ReposGetClonesPer $per = null): CloneTraffic
    {
        $path = '/repos/{owner}/{repo}/traffic/clones';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per !== null) {
            $query[] = 'per=' . \urlencode($per->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CloneTraffic::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ContentTraffic>
     */
    public function reposGetTopPaths(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/traffic/popular/paths';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ContentTraffic => $this->hydrator->hydrate(ContentTraffic::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ReferrerTraffic>
     */
    public function reposGetTopReferrers(string $owner, string $repo): array
    {
        $path = '/repos/{owner}/{repo}/traffic/popular/referrers';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ReferrerTraffic => $this->hydrator->hydrate(ReferrerTraffic::class, (array) $item),
            $data,
        ));
    }

    public function reposGetViews(string $owner, string $repo, ?ReposGetViewsPer $per = null): ViewTraffic
    {
        $path = '/repos/{owner}/{repo}/traffic/views';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $query = [];
        if ($per !== null) {
            $query[] = 'per=' . \urlencode($per->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ViewTraffic::class, $data);
    }

    public function reposCheckVulnerabilityAlerts(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/vulnerability-alerts';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposEnableVulnerabilityAlerts(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/vulnerability-alerts';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposDisableVulnerabilityAlerts(string $owner, string $repo): void
    {
        $path = '/repos/{owner}/{repo}/vulnerability-alerts';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposDownloadZipballArchive(string $owner, string $repo, string $ref): void
    {
        $path = '/repos/{owner}/{repo}/zipball/{ref}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $path = \str_replace('{ref}', $ref, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function reposListPublic(?int $since = null): array
    {
        $path = '/repositories';
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode((string) $since);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    public function issuesDeleteIssueFieldValue(int $repository_id, int $issue_number, int $issue_field_id): void
    {
        $path = '/repositories/{repository_id}/issues/{issue_number}/issue-field-values/{issue_field_id}';
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $path = \str_replace('{issue_number}', (string) $issue_number, $path);
        $path = \str_replace('{issue_field_id}', (string) $issue_field_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function searchCode(
        string $q,
        ?SearchCodeSort $sort = null,
        ?SearchCodeOrder $order = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/search/code';
        $query = [];
        $query[] = 'q=' . \urlencode($q);
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($order !== null) {
            $query[] = 'order=' . \urlencode($order->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function searchCommits(
        string $q,
        ?SearchCommitsSort $sort = null,
        ?SearchCommitsOrder $order = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/search/commits';
        $query = [];
        $query[] = 'q=' . \urlencode($q);
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($order !== null) {
            $query[] = 'order=' . \urlencode($order->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function searchIssuesAndPullRequests(
        string $q,
        ?SearchIssuesAndPullRequestsSort $sort = null,
        ?SearchIssuesAndPullRequestsOrder $order = null,
        ?int $per_page = null,
        ?int $page = null,
        ?string $advanced_search = null,
        ?SearchIssuesAndPullRequestsSearchType $search_type = null,
    ): void {
        $path = '/search/issues';
        $query = [];
        $query[] = 'q=' . \urlencode($q);
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($order !== null) {
            $query[] = 'order=' . \urlencode($order->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($advanced_search !== null) {
            $query[] = 'advanced_search=' . \urlencode($advanced_search);
        }
        if ($search_type !== null) {
            $query[] = 'search_type=' . \urlencode($search_type->value);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function searchLabels(
        int $repository_id,
        string $q,
        ?SearchLabelsSort $sort = null,
        ?SearchLabelsOrder $order = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/search/labels';
        $query = [];
        $query[] = 'repository_id=' . \urlencode((string) $repository_id);
        $query[] = 'q=' . \urlencode($q);
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($order !== null) {
            $query[] = 'order=' . \urlencode($order->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function searchRepos(
        string $q,
        ?SearchReposSort $sort = null,
        ?SearchReposOrder $order = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/search/repositories';
        $query = [];
        $query[] = 'q=' . \urlencode($q);
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($order !== null) {
            $query[] = 'order=' . \urlencode($order->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function searchTopics(string $q, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/search/topics';
        $query = [];
        $query[] = 'q=' . \urlencode($q);
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function searchUsers(
        string $q,
        ?SearchUsersSort $sort = null,
        ?SearchUsersOrder $order = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/search/users';
        $query = [];
        $query[] = 'q=' . \urlencode($q);
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($order !== null) {
            $query[] = 'order=' . \urlencode($order->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function teamsGetLegacy(int $team_id): TeamFull
    {
        $path = '/teams/{team_id}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(TeamFull::class, $data);
    }

    public function teamsDeleteLegacy(int $team_id): void
    {
        $path = '/teams/{team_id}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationInvitation>
     */
    public function teamsListPendingInvitationsLegacy(int $team_id, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/teams/{team_id}/invitations';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationInvitation => $this->hydrator->hydrate(OrganizationInvitation::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function teamsListMembersLegacy(
        int $team_id,
        ?TeamsListMembersLegacyRole $role = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/teams/{team_id}/members';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $query = [];
        if ($role !== null) {
            $query[] = 'role=' . \urlencode($role->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function teamsGetMemberLegacy(int $team_id, string $username): void
    {
        $path = '/teams/{team_id}/members/{username}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function teamsAddMemberLegacy(int $team_id, string $username): void
    {
        $path = '/teams/{team_id}/members/{username}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function teamsRemoveMemberLegacy(int $team_id, string $username): void
    {
        $path = '/teams/{team_id}/members/{username}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function teamsGetMembershipForUserLegacy(int $team_id, string $username): TeamMembership
    {
        $path = '/teams/{team_id}/memberships/{username}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(TeamMembership::class, $data);
    }

    public function teamsRemoveMembershipForUserLegacy(int $team_id, string $username): void
    {
        $path = '/teams/{team_id}/memberships/{username}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function teamsListReposLegacy(int $team_id, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/teams/{team_id}/repos';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    public function teamsCheckPermissionsForRepoLegacy(int $team_id, string $owner, string $repo): TeamRepository
    {
        $path = '/teams/{team_id}/repos/{owner}/{repo}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(TeamRepository::class, $data);
    }

    public function teamsRemoveRepoLegacy(int $team_id, string $owner, string $repo): void
    {
        $path = '/teams/{team_id}/repos/{owner}/{repo}';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Team>
     */
    public function teamsListChildLegacy(int $team_id, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/teams/{team_id}/teams';
        $path = \str_replace('{team_id}', (string) $team_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Team => $this->hydrator->hydrate(Team::class, (array) $item),
            $data,
        ));
    }

    public function usersGetAuthenticated(): void
    {
        $path = '/user';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function usersListBlockedByAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/blocks';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function usersCheckBlocked(string $username): void
    {
        $path = '/user/blocks/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function usersBlock(string $username): void
    {
        $path = '/user/blocks/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function usersUnblock(string $username): void
    {
        $path = '/user/blocks/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesListForAuthenticatedUser(
        ?int $per_page = null,
        ?int $page = null,
        ?int $repository_id = null,
    ): void {
        $path = '/user/codespaces';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($repository_id !== null) {
            $query[] = 'repository_id=' . \urlencode((string) $repository_id);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesListSecretsForAuthenticatedUser(?int $per_page = null, ?int $page = null): void
    {
        $path = '/user/codespaces/secrets';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesGetPublicKeyForAuthenticatedUser(): CodespacesUserPublicKey
    {
        $path = '/user/codespaces/secrets/public-key';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodespacesUserPublicKey::class, $data);
    }

    public function codespacesGetSecretForAuthenticatedUser(string $secret_name): CodespacesSecret
    {
        $path = '/user/codespaces/secrets/{secret_name}';
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodespacesSecret::class, $data);
    }

    public function codespacesDeleteSecretForAuthenticatedUser(string $secret_name): void
    {
        $path = '/user/codespaces/secrets/{secret_name}';
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesListRepositoriesForSecretForAuthenticatedUser(string $secret_name): void
    {
        $path = '/user/codespaces/secrets/{secret_name}/repositories';
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesAddRepositoryForSecretForAuthenticatedUser(
        string $secret_name,
        int $repository_id,
    ): void {
        $path = '/user/codespaces/secrets/{secret_name}/repositories/{repository_id}';
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesRemoveRepositoryForSecretForAuthenticatedUser(
        string $secret_name,
        int $repository_id,
    ): void {
        $path = '/user/codespaces/secrets/{secret_name}/repositories/{repository_id}';
        $path = \str_replace('{secret_name}', $secret_name, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesGetForAuthenticatedUser(string $codespace_name): Codespace
    {
        $path = '/user/codespaces/{codespace_name}';
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Codespace::class, $data);
    }

    public function codespacesDeleteForAuthenticatedUser(string $codespace_name): void
    {
        $path = '/user/codespaces/{codespace_name}';
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesExportForAuthenticatedUser(string $codespace_name): CodespaceExportDetails
    {
        $path = '/user/codespaces/{codespace_name}/exports';
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodespaceExportDetails::class, $data);
    }

    public function codespacesGetExportDetailsForAuthenticatedUser(
        string $codespace_name,
        string $export_id,
    ): CodespaceExportDetails {
        $path = '/user/codespaces/{codespace_name}/exports/{export_id}';
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $path = \str_replace('{export_id}', $export_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CodespaceExportDetails::class, $data);
    }

    public function codespacesCodespaceMachinesForAuthenticatedUser(string $codespace_name): void
    {
        $path = '/user/codespaces/{codespace_name}/machines';
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function codespacesStartForAuthenticatedUser(string $codespace_name): Codespace
    {
        $path = '/user/codespaces/{codespace_name}/start';
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Codespace::class, $data);
    }

    public function codespacesStopForAuthenticatedUser(string $codespace_name): Codespace
    {
        $path = '/user/codespaces/{codespace_name}/stop';
        $path = \str_replace('{codespace_name}', $codespace_name, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Codespace::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Package>
     */
    public function packagesListDockerMigrationConflictingPackagesForAuthenticatedUser(): array
    {
        $path = '/user/docker/conflicts';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Package => $this->hydrator->hydrate(Package::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Email>
     */
    public function usersListEmailsForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/emails';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Email => $this->hydrator->hydrate(Email::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function usersListFollowersForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/followers';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function usersListFollowedByAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/following';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function usersCheckPersonIsFollowedByAuthenticated(string $username): void
    {
        $path = '/user/following/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function usersFollow(string $username): void
    {
        $path = '/user/following/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function usersUnfollow(string $username): void
    {
        $path = '/user/following/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\GpgKey>
     */
    public function usersListGpgKeysForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/gpg_keys';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): GpgKey => $this->hydrator->hydrate(GpgKey::class, (array) $item),
            $data,
        ));
    }

    public function usersGetGpgKeyForAuthenticatedUser(int $gpg_key_id): GpgKey
    {
        $path = '/user/gpg_keys/{gpg_key_id}';
        $path = \str_replace('{gpg_key_id}', (string) $gpg_key_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GpgKey::class, $data);
    }

    public function usersDeleteGpgKeyForAuthenticatedUser(int $gpg_key_id): void
    {
        $path = '/user/gpg_keys/{gpg_key_id}';
        $path = \str_replace('{gpg_key_id}', (string) $gpg_key_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsListInstallationsForAuthenticatedUser(?int $per_page = null, ?int $page = null): void
    {
        $path = '/user/installations';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsListInstallationReposForAuthenticatedUser(
        int $installation_id,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/user/installations/{installation_id}/repositories';
        $path = \str_replace('{installation_id}', (string) $installation_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsAddRepoToInstallationForAuthenticatedUser(int $installation_id, int $repository_id): void
    {
        $path = '/user/installations/{installation_id}/repositories/{repository_id}';
        $path = \str_replace('{installation_id}', (string) $installation_id, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function appsRemoveRepoFromInstallationForAuthenticatedUser(int $installation_id, int $repository_id): void
    {
        $path = '/user/installations/{installation_id}/repositories/{repository_id}';
        $path = \str_replace('{installation_id}', (string) $installation_id, $path);
        $path = \str_replace('{repository_id}', (string) $repository_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function interactionsGetRestrictionsForAuthenticatedUser(): void
    {
        $path = '/user/interaction-limits';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function interactionsSetRestrictionsForAuthenticatedUser(InteractionLimit $body): InteractionLimitResponse
    {
        $path = '/user/interaction-limits';
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(InteractionLimitResponse::class, $data);
    }

    public function interactionsRemoveRestrictionsForAuthenticatedUser(): void
    {
        $path = '/user/interaction-limits';
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Issue>
     */
    public function issuesListForAuthenticatedUser(
        ?IssuesListForAuthenticatedUserFilter $filter = null,
        ?IssuesListForAuthenticatedUserState $state = null,
        ?string $labels = null,
        ?IssuesListForAuthenticatedUserSort $sort = null,
        ?IssuesListForAuthenticatedUserDirection $direction = null,
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/user/issues';
        $query = [];
        if ($filter !== null) {
            $query[] = 'filter=' . \urlencode($filter->value);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($labels !== null) {
            $query[] = 'labels=' . \urlencode($labels);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Issue => $this->hydrator->hydrate(Issue::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Key>
     */
    public function usersListPublicSshKeysForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/keys';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Key => $this->hydrator->hydrate(Key::class, (array) $item),
            $data,
        ));
    }

    public function usersGetPublicSshKeyForAuthenticatedUser(int $key_id): Key
    {
        $path = '/user/keys/{key_id}';
        $path = \str_replace('{key_id}', (string) $key_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Key::class, $data);
    }

    public function usersDeletePublicSshKeyForAuthenticatedUser(int $key_id): void
    {
        $path = '/user/keys/{key_id}';
        $path = \str_replace('{key_id}', (string) $key_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\UserMarketplacePurchase>
     */
    public function appsListSubscriptionsForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/marketplace_purchases';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): UserMarketplacePurchase => $this->hydrator->hydrate(UserMarketplacePurchase::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\UserMarketplacePurchase>
     */
    public function appsListSubscriptionsForAuthenticatedUserStubbed(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/marketplace_purchases/stubbed';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): UserMarketplacePurchase => $this->hydrator->hydrate(UserMarketplacePurchase::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrgMembership>
     */
    public function orgsListMembershipsForAuthenticatedUser(
        ?OrgsListMembershipsForAuthenticatedUserState $state = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/user/memberships/orgs';
        $query = [];
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrgMembership => $this->hydrator->hydrate(OrgMembership::class, (array) $item),
            $data,
        ));
    }

    public function orgsGetMembershipForAuthenticatedUser(string $org): OrgMembership
    {
        $path = '/user/memberships/orgs/{org}';
        $path = \str_replace('{org}', $org, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(OrgMembership::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Migration>
     */
    public function migrationsListForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/migrations';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Migration => $this->hydrator->hydrate(Migration::class, (array) $item),
            $data,
        ));
    }

    /**
     * @param list<string> $exclude
     */
    public function migrationsGetStatusForAuthenticatedUser(int $migration_id, ?array $exclude = null): Migration
    {
        $path = '/user/migrations/{migration_id}';
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $query = [];
        if ($exclude !== null) { foreach ($exclude as $__v) { $query[] = 'exclude=' . \urlencode($__v); } }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Migration::class, $data);
    }

    public function migrationsGetArchiveForAuthenticatedUser(int $migration_id): void
    {
        $path = '/user/migrations/{migration_id}/archive';
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function migrationsDeleteArchiveForAuthenticatedUser(int $migration_id): void
    {
        $path = '/user/migrations/{migration_id}/archive';
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function migrationsUnlockRepoForAuthenticatedUser(int $migration_id, string $repo_name): void
    {
        $path = '/user/migrations/{migration_id}/repos/{repo_name}/lock';
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $path = \str_replace('{repo_name}', $repo_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function migrationsListReposForAuthenticatedUser(
        int $migration_id,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/user/migrations/{migration_id}/repositories';
        $path = \str_replace('{migration_id}', (string) $migration_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationSimple>
     */
    public function orgsListForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/orgs';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationSimple => $this->hydrator->hydrate(OrganizationSimple::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Package>
     */
    public function packagesListPackagesForAuthenticatedUser(
        PackagesListPackagesForAuthenticatedUserPackageType $package_type,
        ?PackagesListPackagesForAuthenticatedUserVisibility $visibility = null,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/user/packages';
        $query = [];
        $query[] = 'package_type=' . \urlencode($package_type->value);
        if ($visibility !== null) {
            $query[] = 'visibility=' . \urlencode($visibility->value);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Package => $this->hydrator->hydrate(Package::class, (array) $item),
            $data,
        ));
    }

    public function packagesGetPackageForAuthenticatedUser(
        PackagesGetPackageForAuthenticatedUserPackageType $package_type,
        string $package_name,
    ): Package {
        $path = '/user/packages/{package_type}/{package_name}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Package::class, $data);
    }

    public function packagesDeletePackageForAuthenticatedUser(
        PackagesDeletePackageForAuthenticatedUserPackageType $package_type,
        string $package_name,
    ): void {
        $path = '/user/packages/{package_type}/{package_name}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function packagesRestorePackageForAuthenticatedUser(
        PackagesRestorePackageForAuthenticatedUserPackageType $package_type,
        string $package_name,
        ?string $token = null,
    ): void {
        $path = '/user/packages/{package_type}/{package_name}/restore';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $query = [];
        if ($token !== null) {
            $query[] = 'token=' . \urlencode($token);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PackageVersion>
     */
    public function packagesGetAllPackageVersionsForPackageOwnedByAuthenticatedUser(
        PackagesGetAllPackageVersionsForPackageOwnedByAuthenticatedUserPackageType $package_type,
        string $package_name,
        ?int $page = null,
        ?int $per_page = null,
        ?PackagesGetAllPackageVersionsForPackageOwnedByAuthenticatedUserState $state = null,
    ): array {
        $path = '/user/packages/{package_type}/{package_name}/versions';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PackageVersion => $this->hydrator->hydrate(PackageVersion::class, (array) $item),
            $data,
        ));
    }

    public function packagesGetPackageVersionForAuthenticatedUser(
        PackagesGetPackageVersionForAuthenticatedUserPackageType $package_type,
        string $package_name,
        int $package_version_id,
    ): PackageVersion {
        $path = '/user/packages/{package_type}/{package_name}/versions/{package_version_id}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PackageVersion::class, $data);
    }

    public function packagesDeletePackageVersionForAuthenticatedUser(
        PackagesDeletePackageVersionForAuthenticatedUserPackageType $package_type,
        string $package_name,
        int $package_version_id,
    ): void {
        $path = '/user/packages/{package_type}/{package_name}/versions/{package_version_id}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function packagesRestorePackageVersionForAuthenticatedUser(
        PackagesRestorePackageVersionForAuthenticatedUserPackageType $package_type,
        string $package_name,
        int $package_version_id,
    ): void {
        $path = '/user/packages/{package_type}/{package_name}/versions/{package_version_id}/restore';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Email>
     */
    public function usersListPublicEmailsForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/public_emails';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Email => $this->hydrator->hydrate(Email::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Repository>
     */
    public function reposListForAuthenticatedUser(
        ?ReposListForAuthenticatedUserVisibility $visibility = null,
        ?string $affiliation = null,
        ?ReposListForAuthenticatedUserType $type = null,
        ?ReposListForAuthenticatedUserSort $sort = null,
        ?ReposListForAuthenticatedUserDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
        ?\DateTimeImmutable $since = null,
        ?\DateTimeImmutable $before = null,
    ): array {
        $path = '/user/repos';
        $query = [];
        if ($visibility !== null) {
            $query[] = 'visibility=' . \urlencode($visibility->value);
        }
        if ($affiliation !== null) {
            $query[] = 'affiliation=' . \urlencode($affiliation);
        }
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type->value);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before->format(\DateTimeInterface::RFC3339));
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Repository => $this->hydrator->hydrate(Repository::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\RepositoryInvitation>
     */
    public function reposListInvitationsForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/repository_invitations';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): RepositoryInvitation => $this->hydrator->hydrate(RepositoryInvitation::class, (array) $item),
            $data,
        ));
    }

    public function reposDeclineInvitationForAuthenticatedUser(int $invitation_id): void
    {
        $path = '/user/repository_invitations/{invitation_id}';
        $path = \str_replace('{invitation_id}', (string) $invitation_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reposAcceptInvitationForAuthenticatedUser(int $invitation_id): void
    {
        $path = '/user/repository_invitations/{invitation_id}';
        $path = \str_replace('{invitation_id}', (string) $invitation_id, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SocialAccount>
     */
    public function usersListSocialAccountsForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/social_accounts';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SocialAccount => $this->hydrator->hydrate(SocialAccount::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SshSigningKey>
     */
    public function usersListSshSigningKeysForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/ssh_signing_keys';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SshSigningKey => $this->hydrator->hydrate(SshSigningKey::class, (array) $item),
            $data,
        ));
    }

    public function usersGetSshSigningKeyForAuthenticatedUser(int $ssh_signing_key_id): SshSigningKey
    {
        $path = '/user/ssh_signing_keys/{ssh_signing_key_id}';
        $path = \str_replace('{ssh_signing_key_id}', (string) $ssh_signing_key_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(SshSigningKey::class, $data);
    }

    public function usersDeleteSshSigningKeyForAuthenticatedUser(int $ssh_signing_key_id): void
    {
        $path = '/user/ssh_signing_keys/{ssh_signing_key_id}';
        $path = \str_replace('{ssh_signing_key_id}', (string) $ssh_signing_key_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Repository>
     */
    public function activityListReposStarredByAuthenticatedUser(
        ?ActivityListReposStarredByAuthenticatedUserSort $sort = null,
        ?ActivityListReposStarredByAuthenticatedUserDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/user/starred';
        $query = [];
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Repository => $this->hydrator->hydrate(Repository::class, (array) $item),
            $data,
        ));
    }

    public function activityCheckRepoIsStarredByAuthenticatedUser(string $owner, string $repo): void
    {
        $path = '/user/starred/{owner}/{repo}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function activityStarRepoForAuthenticatedUser(string $owner, string $repo): void
    {
        $path = '/user/starred/{owner}/{repo}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function activityUnstarRepoForAuthenticatedUser(string $owner, string $repo): void
    {
        $path = '/user/starred/{owner}/{repo}';
        $path = \str_replace('{owner}', $owner, $path);
        $path = \str_replace('{repo}', $repo, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function activityListWatchedReposForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/subscriptions';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\TeamFull>
     */
    public function teamsListForAuthenticatedUser(?int $per_page = null, ?int $page = null): array
    {
        $path = '/user/teams';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): TeamFull => $this->hydrator->hydrate(TeamFull::class, (array) $item),
            $data,
        ));
    }

    public function usersGetById(int $account_id): void
    {
        $path = '/user/{account_id}';
        $path = \str_replace('{account_id}', (string) $account_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function usersList(?int $since = null, ?int $per_page = null): array
    {
        $path = '/users';
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode((string) $since);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function usersGetByUsername(string $username): void
    {
        $path = '/users/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function usersDeleteAttestationsBySubjectDigest(string $username, string $subject_digest): void
    {
        $path = '/users/{username}/attestations/digest/{subject_digest}';
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{subject_digest}', $subject_digest, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function usersDeleteAttestationsById(string $username, int $attestation_id): void
    {
        $path = '/users/{username}/attestations/{attestation_id}';
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{attestation_id}', (string) $attestation_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function usersListAttestations(
        string $username,
        string $subject_digest,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
        ?string $predicate_type = null,
    ): void {
        $path = '/users/{username}/attestations/{subject_digest}';
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{subject_digest}', $subject_digest, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($predicate_type !== null) {
            $query[] = 'predicate_type=' . \urlencode($predicate_type);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Package>
     */
    public function packagesListDockerMigrationConflictingPackagesForUser(string $username): array
    {
        $path = '/users/{username}/docker/conflicts';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Package => $this->hydrator->hydrate(Package::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListEventsForAuthenticatedUser(
        string $username,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/users/{username}/events';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListOrgEventsForAuthenticatedUser(
        string $username,
        string $org,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/users/{username}/events/orgs/{org}';
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{org}', $org, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListPublicEventsForUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/events/public';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function usersListFollowersForUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/followers';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SimpleUser>
     */
    public function usersListFollowingForUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/following';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SimpleUser => $this->hydrator->hydrate(SimpleUser::class, (array) $item),
            $data,
        ));
    }

    public function usersCheckFollowingForUser(string $username, string $target_user): void
    {
        $path = '/users/{username}/following/{target_user}';
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{target_user}', $target_user, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\BaseGist>
     */
    public function gistsListForUser(
        string $username,
        ?\DateTimeImmutable $since = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/users/{username}/gists';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): BaseGist => $this->hydrator->hydrate(BaseGist::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\GpgKey>
     */
    public function usersListGpgKeysForUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/gpg_keys';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): GpgKey => $this->hydrator->hydrate(GpgKey::class, (array) $item),
            $data,
        ));
    }

    public function usersGetContextForUser(
        string $username,
        ?UsersGetContextForUserSubjectType $subject_type = null,
        ?string $subject_id = null,
    ): Hovercard {
        $path = '/users/{username}/hovercard';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($subject_type !== null) {
            $query[] = 'subject_type=' . \urlencode($subject_type->value);
        }
        if ($subject_id !== null) {
            $query[] = 'subject_id=' . \urlencode($subject_id);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Hovercard::class, $data);
    }

    public function appsGetUserInstallation(string $username): Installation
    {
        $path = '/users/{username}/installation';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Installation::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\KeySimple>
     */
    public function usersListPublicKeysForUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/keys';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): KeySimple => $this->hydrator->hydrate(KeySimple::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\OrganizationSimple>
     */
    public function orgsListForUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/orgs';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): OrganizationSimple => $this->hydrator->hydrate(OrganizationSimple::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Package>
     */
    public function packagesListPackagesForUser(
        string $username,
        PackagesListPackagesForUserPackageType $package_type,
        ?PackagesListPackagesForUserVisibility $visibility = null,
        ?int $page = null,
        ?int $per_page = null,
    ): array {
        $path = '/users/{username}/packages';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        $query[] = 'package_type=' . \urlencode($package_type->value);
        if ($visibility !== null) {
            $query[] = 'visibility=' . \urlencode($visibility->value);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Package => $this->hydrator->hydrate(Package::class, (array) $item),
            $data,
        ));
    }

    public function packagesGetPackageForUser(
        PackagesGetPackageForUserPackageType $package_type,
        string $package_name,
        string $username,
    ): Package {
        $path = '/users/{username}/packages/{package_type}/{package_name}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Package::class, $data);
    }

    public function packagesDeletePackageForUser(
        PackagesDeletePackageForUserPackageType $package_type,
        string $package_name,
        string $username,
    ): void {
        $path = '/users/{username}/packages/{package_type}/{package_name}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function packagesRestorePackageForUser(
        PackagesRestorePackageForUserPackageType $package_type,
        string $package_name,
        string $username,
        ?string $token = null,
    ): void {
        $path = '/users/{username}/packages/{package_type}/{package_name}/restore';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($token !== null) {
            $query[] = 'token=' . \urlencode($token);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\PackageVersion>
     */
    public function packagesGetAllPackageVersionsForPackageOwnedByUser(
        PackagesGetAllPackageVersionsForPackageOwnedByUserPackageType $package_type,
        string $package_name,
        string $username,
    ): array {
        $path = '/users/{username}/packages/{package_type}/{package_name}/versions';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): PackageVersion => $this->hydrator->hydrate(PackageVersion::class, (array) $item),
            $data,
        ));
    }

    public function packagesGetPackageVersionForUser(
        PackagesGetPackageVersionForUserPackageType $package_type,
        string $package_name,
        int $package_version_id,
        string $username,
    ): PackageVersion {
        $path = '/users/{username}/packages/{package_type}/{package_name}/versions/{package_version_id}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(PackageVersion::class, $data);
    }

    public function packagesDeletePackageVersionForUser(
        PackagesDeletePackageVersionForUserPackageType $package_type,
        string $package_name,
        string $username,
        int $package_version_id,
    ): void {
        $path = '/users/{username}/packages/{package_type}/{package_name}/versions/{package_version_id}';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function packagesRestorePackageVersionForUser(
        PackagesRestorePackageVersionForUserPackageType $package_type,
        string $package_name,
        string $username,
        int $package_version_id,
    ): void {
        $path = '/users/{username}/packages/{package_type}/{package_name}/versions/{package_version_id}/restore';
        $path = \str_replace('{package_type}', $package_type->value, $path);
        $path = \str_replace('{package_name}', $package_name, $path);
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{package_version_id}', (string) $package_version_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ProjectsV2>
     */
    public function projectsListForUser(
        string $username,
        ?string $q = null,
        ?string $before = null,
        ?string $after = null,
        ?int $per_page = null,
    ): array {
        $path = '/users/{username}/projectsV2';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($q !== null) {
            $query[] = 'q=' . \urlencode($q);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ProjectsV2 => $this->hydrator->hydrate(ProjectsV2::class, (array) $item),
            $data,
        ));
    }

    public function projectsGetForUser(int $project_number, string $username): ProjectsV2
    {
        $path = '/users/{username}/projectsV2/{project_number}';
        $path = \str_replace('{project_number}', (string) $project_number, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProjectsV2::class, $data);
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\ProjectsV2Field>
     */
    public function projectsListFieldsForUser(
        int $project_number,
        string $username,
        ?int $per_page = null,
        ?string $before = null,
        ?string $after = null,
    ): array {
        $path = '/users/{username}/projectsV2/{project_number}/fields';
        $path = \str_replace('{project_number}', (string) $project_number, $path);
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($before !== null) {
            $query[] = 'before=' . \urlencode($before);
        }
        if ($after !== null) {
            $query[] = 'after=' . \urlencode($after);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): ProjectsV2Field => $this->hydrator->hydrate(ProjectsV2Field::class, (array) $item),
            $data,
        ));
    }

    public function projectsGetFieldForUser(int $project_number, int $field_id, string $username): ProjectsV2Field
    {
        $path = '/users/{username}/projectsV2/{project_number}/fields/{field_id}';
        $path = \str_replace('{project_number}', (string) $project_number, $path);
        $path = \str_replace('{field_id}', (string) $field_id, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ProjectsV2Field::class, $data);
    }

    public function projectsDeleteItemForUser(int $project_number, string $username, int $item_id): void
    {
        $path = '/users/{username}/projectsV2/{project_number}/items/{item_id}';
        $path = \str_replace('{project_number}', (string) $project_number, $path);
        $path = \str_replace('{username}', $username, $path);
        $path = \str_replace('{item_id}', (string) $item_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListReceivedEventsForUser(
        string $username,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/users/{username}/received_events';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\Event>
     */
    public function activityListReceivedPublicEventsForUser(
        string $username,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/users/{username}/received_events/public';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Event => $this->hydrator->hydrate(Event::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function reposListForUser(
        string $username,
        ?ReposListForUserType $type = null,
        ?ReposListForUserSort $sort = null,
        ?ReposListForUserDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
    ): array {
        $path = '/users/{username}/repos';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type->value);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    public function billingGetGithubBillingPremiumRequestUsageReportUser(
        string $username,
        ?int $year = null,
        ?int $month = null,
        ?int $day = null,
        ?string $model = null,
        ?string $product = null,
    ): void {
        $path = '/users/{username}/settings/billing/premium_request/usage';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($year !== null) {
            $query[] = 'year=' . \urlencode((string) $year);
        }
        if ($month !== null) {
            $query[] = 'month=' . \urlencode((string) $month);
        }
        if ($day !== null) {
            $query[] = 'day=' . \urlencode((string) $day);
        }
        if ($model !== null) {
            $query[] = 'model=' . \urlencode($model);
        }
        if ($product !== null) {
            $query[] = 'product=' . \urlencode($product);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingGetGithubBillingUsageReportUser(
        string $username,
        ?int $year = null,
        ?int $month = null,
        ?int $day = null,
    ): void {
        $path = '/users/{username}/settings/billing/usage';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($year !== null) {
            $query[] = 'year=' . \urlencode((string) $year);
        }
        if ($month !== null) {
            $query[] = 'month=' . \urlencode((string) $month);
        }
        if ($day !== null) {
            $query[] = 'day=' . \urlencode((string) $day);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingGetGithubBillingUsageSummaryReportUser(
        string $username,
        ?int $year = null,
        ?int $month = null,
        ?int $day = null,
        ?string $repository = null,
        ?string $product = null,
        ?string $sku = null,
    ): void {
        $path = '/users/{username}/settings/billing/usage/summary';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($year !== null) {
            $query[] = 'year=' . \urlencode((string) $year);
        }
        if ($month !== null) {
            $query[] = 'month=' . \urlencode((string) $month);
        }
        if ($day !== null) {
            $query[] = 'day=' . \urlencode((string) $day);
        }
        if ($repository !== null) {
            $query[] = 'repository=' . \urlencode($repository);
        }
        if ($product !== null) {
            $query[] = 'product=' . \urlencode($product);
        }
        if ($sku !== null) {
            $query[] = 'sku=' . \urlencode($sku);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SocialAccount>
     */
    public function usersListSocialAccountsForUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/social_accounts';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SocialAccount => $this->hydrator->hydrate(SocialAccount::class, (array) $item),
            $data,
        ));
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\SshSigningKey>
     */
    public function usersListSshSigningKeysForUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/ssh_signing_keys';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): SshSigningKey => $this->hydrator->hydrate(SshSigningKey::class, (array) $item),
            $data,
        ));
    }

    public function activityListReposStarredByUser(
        string $username,
        ?ActivityListReposStarredByUserSort $sort = null,
        ?ActivityListReposStarredByUserDirection $direction = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/users/{username}/starred';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort->value);
        }
        if ($direction !== null) {
            $query[] = 'direction=' . \urlencode($direction->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @return list<\Acme\GitHub\Generated\Model\MinimalRepository>
     */
    public function activityListReposWatchedByUser(string $username, ?int $per_page = null, ?int $page = null): array
    {
        $path = '/users/{username}/subscriptions';
        $path = \str_replace('{username}', $username, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): MinimalRepository => $this->hydrator->hydrate(MinimalRepository::class, (array) $item),
            $data,
        ));
    }

    public function metaGetAllVersions(): void
    {
        $path = '/versions';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function metaGetZen(): void
    {
        $path = '/zen';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }
}
