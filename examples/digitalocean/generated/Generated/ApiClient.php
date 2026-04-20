<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated;

use Acme\DigitalOcean\Generated\Enum\AppsGetEventLogsType;
use Acme\DigitalOcean\Generated\Enum\AppsGetJobInvocationLogsType;
use Acme\DigitalOcean\Generated\Enum\AppsGetLogsActiveDeploymentAggregateType;
use Acme\DigitalOcean\Generated\Enum\AppsGetLogsActiveDeploymentType;
use Acme\DigitalOcean\Generated\Enum\AppsGetLogsAggregateType;
use Acme\DigitalOcean\Generated\Enum\AppsGetLogsType;
use Acme\DigitalOcean\Generated\Enum\DedicatedInferencesListRegion;
use Acme\DigitalOcean\Generated\Enum\DomainsListRecordsType;
use Acme\DigitalOcean\Generated\Enum\DropletsListType;
use Acme\DigitalOcean\Generated\Enum\ImagesListType;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDatabaseMysqlCpuUsageAggregate;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDatabaseMysqlDiskUsageAggregate;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDatabaseMysqlLoadAggregate;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDatabaseMysqlLoadMetric;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDatabaseMysqlMemoryUsageAggregate;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDatabaseMysqlOpRatesMetric;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDatabaseMysqlSchemaLatencyMetric;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDatabaseMysqlSchemaThroughputMetric;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDropletBandwidthMetricsDirection;
use Acme\DigitalOcean\Generated\Enum\MonitoringGetDropletBandwidthMetricsInterface;
use Acme\DigitalOcean\Generated\Enum\OneClicksListType;
use Acme\DigitalOcean\Generated\Enum\SecurityGetLatestScanSeverity;
use Acme\DigitalOcean\Generated\Enum\SecurityGetScanSeverity;
use Acme\DigitalOcean\Generated\Enum\SnapshotsListResourceType;
use Acme\DigitalOcean\Generated\Enum\VpcnatgatewaysListRegion;
use Acme\DigitalOcean\Generated\Enum\VpcnatgatewaysListState;
use Acme\DigitalOcean\Generated\Enum\VpcnatgatewaysListType;
use Acme\DigitalOcean\Generated\Model\AccessKeyCreateRequest;
use Acme\DigitalOcean\Generated\Model\AlertPolicyRequest;
use Acme\DigitalOcean\Generated\Model\ApiCancelKnowledgeBaseIndexingJobInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCancelKnowledgeBaseIndexingJobOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateAgentApikeyInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateAgentApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateAgentInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateAgentOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateAnthropicApikeyInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateAnthropicApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateDataSourceFileUploadPresignedUrlsInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateDataSourceFileUploadPresignedUrlsOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateEvaluationDatasetInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateEvaluationDatasetOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateEvaluationTestCaseInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateEvaluationTestCaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateKnowledgeBaseDataSourceInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateKnowledgeBaseDataSourceOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateKnowledgeBaseInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateKnowledgeBaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateModelApikeyInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateModelApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateOpenAiapikeyInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateOpenAiapikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateScheduledIndexingInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateScheduledIndexingOutput;
use Acme\DigitalOcean\Generated\Model\ApiCreateWorkspaceInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiCreateWorkspaceOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteAgentApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteAgentOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteAnthropicApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteKnowledgeBaseDataSourceOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteKnowledgeBaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteModelApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteOpenAiapikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteScheduledIndexingOutput;
use Acme\DigitalOcean\Generated\Model\ApiDeleteWorkspaceOutput;
use Acme\DigitalOcean\Generated\Model\ApiDropboxOauth2GetTokensInput;
use Acme\DigitalOcean\Generated\Model\ApiDropboxOauth2GetTokensOutput;
use Acme\DigitalOcean\Generated\Model\ApiGenerateOauth2Urloutput;
use Acme\DigitalOcean\Generated\Model\ApiGetAgentOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetAgentUsageOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetAnthropicApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetChildrenOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetEvaluationRunOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetEvaluationRunPromptResultsOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetEvaluationRunResultsOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetEvaluationTestCaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetIndexingJobDetailsSignedUrloutput;
use Acme\DigitalOcean\Generated\Model\ApiGetKnowledgeBaseIndexingJobOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetKnowledgeBaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetOpenAiapikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetScheduledIndexingOutput;
use Acme\DigitalOcean\Generated\Model\ApiGetWorkspaceOutput;
use Acme\DigitalOcean\Generated\Model\ApiLinkAgentFunctionInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiLinkAgentFunctionOutput;
use Acme\DigitalOcean\Generated\Model\ApiLinkAgentGuardrailOutput;
use Acme\DigitalOcean\Generated\Model\ApiLinkAgentGuardrailsInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiLinkAgentInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiLinkAgentOutput;
use Acme\DigitalOcean\Generated\Model\ApiLinkKnowledgeBaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiListAgentApikeysOutput;
use Acme\DigitalOcean\Generated\Model\ApiListAgentVersionsOutput;
use Acme\DigitalOcean\Generated\Model\ApiListAgentsByAnthropicKeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiListAgentsByOpenAikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiListAgentsByWorkspaceOutput;
use Acme\DigitalOcean\Generated\Model\ApiListAgentsOutputPublic;
use Acme\DigitalOcean\Generated\Model\ApiListAnthropicApikeysOutput;
use Acme\DigitalOcean\Generated\Model\ApiListEvaluationMetricsOutput;
use Acme\DigitalOcean\Generated\Model\ApiListEvaluationRunsByTestCaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiListEvaluationTestCasesByWorkspaceOutput;
use Acme\DigitalOcean\Generated\Model\ApiListEvaluationTestCasesOutput;
use Acme\DigitalOcean\Generated\Model\ApiListIndexingJobDataSourcesOutput;
use Acme\DigitalOcean\Generated\Model\ApiListKnowledgeBaseDataSourcesOutput;
use Acme\DigitalOcean\Generated\Model\ApiListKnowledgeBaseIndexingJobsOutput;
use Acme\DigitalOcean\Generated\Model\ApiListKnowledgeBasesOutput;
use Acme\DigitalOcean\Generated\Model\ApiListModelApikeysOutput;
use Acme\DigitalOcean\Generated\Model\ApiListModelsOutputPublic;
use Acme\DigitalOcean\Generated\Model\ApiListOpenAiapikeysOutput;
use Acme\DigitalOcean\Generated\Model\ApiListRegionsOutput;
use Acme\DigitalOcean\Generated\Model\ApiListWorkspacesOutput;
use Acme\DigitalOcean\Generated\Model\ApiMoveAgentsToWorkspaceInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiMoveAgentsToWorkspaceOutput;
use Acme\DigitalOcean\Generated\Model\ApiRegenerateAgentApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiRegenerateModelApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiRollbackToAgentVersionInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiRollbackToAgentVersionOutput;
use Acme\DigitalOcean\Generated\Model\ApiRunEvaluationTestCaseInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiRunEvaluationTestCaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiStartKnowledgeBaseIndexingJobInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiStartKnowledgeBaseIndexingJobOutput;
use Acme\DigitalOcean\Generated\Model\ApiUnlinkAgentFunctionOutput;
use Acme\DigitalOcean\Generated\Model\ApiUnlinkAgentGuardrailOutput;
use Acme\DigitalOcean\Generated\Model\ApiUnlinkAgentOutput;
use Acme\DigitalOcean\Generated\Model\ApiUnlinkKnowledgeBaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAgentApikeyInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAgentApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAgentDeploymentVisbilityOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAgentDeploymentVisibilityInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAgentFunctionInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAgentFunctionOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAgentInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAgentOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAnthropicApikeyInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateAnthropicApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateEvaluationTestCaseInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateEvaluationTestCaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateKnowledgeBaseDataSourceInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateKnowledgeBaseDataSourceOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateKnowledgeBaseInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateKnowledgeBaseOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateLinkedAgentInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateLinkedAgentOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateModelApikeyInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateModelApikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateOpenAiapikeyInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateOpenAiapikeyOutput;
use Acme\DigitalOcean\Generated\Model\ApiUpdateWorkspaceInputPublic;
use Acme\DigitalOcean\Generated\Model\ApiUpdateWorkspaceOutput;
use Acme\DigitalOcean\Generated\Model\AppMetricsBandwidthUsageRequest;
use Acme\DigitalOcean\Generated\Model\AppPropose;
use Acme\DigitalOcean\Generated\Model\AppsAssignAppAlertDestinationsRequest;
use Acme\DigitalOcean\Generated\Model\AppsCreateDeploymentRequest;
use Acme\DigitalOcean\Generated\Model\AppsRestartRequest;
use Acme\DigitalOcean\Generated\Model\AppsRollbackAppRequest;
use Acme\DigitalOcean\Generated\Model\AppsUpdateAppRequest;
use Acme\DigitalOcean\Generated\Model\AsyncInvokeRequest;
use Acme\DigitalOcean\Generated\Model\AsyncInvokeResponse;
use Acme\DigitalOcean\Generated\Model\AutoscalePoolCreate;
use Acme\DigitalOcean\Generated\Model\ByoipPrefixCreate;
use Acme\DigitalOcean\Generated\Model\ByoipPrefixUpdate;
use Acme\DigitalOcean\Generated\Model\CdnEndpoint;
use Acme\DigitalOcean\Generated\Model\ChatCompletionRequest;
use Acme\DigitalOcean\Generated\Model\ChatCompletionResponse;
use Acme\DigitalOcean\Generated\Model\Cluster;
use Acme\DigitalOcean\Generated\Model\ClusterRegistries;
use Acme\DigitalOcean\Generated\Model\ClusterRegistry;
use Acme\DigitalOcean\Generated\Model\ClusterUpdate;
use Acme\DigitalOcean\Generated\Model\ClusterlintRequest;
use Acme\DigitalOcean\Generated\Model\ConnectionPool;
use Acme\DigitalOcean\Generated\Model\ConnectionPoolUpdate;
use Acme\DigitalOcean\Generated\Model\CreateImageRequest;
use Acme\DigitalOcean\Generated\Model\CreateNamespace;
use Acme\DigitalOcean\Generated\Model\CreateResponseRequest;
use Acme\DigitalOcean\Generated\Model\CreateResponseResponse;
use Acme\DigitalOcean\Generated\Model\CreateTrigger;
use Acme\DigitalOcean\Generated\Model\Database;
use Acme\DigitalOcean\Generated\Model\DatabaseAutoscaleParams;
use Acme\DigitalOcean\Generated\Model\DatabaseClusterResize;
use Acme\DigitalOcean\Generated\Model\DatabaseConfig;
use Acme\DigitalOcean\Generated\Model\DatabaseMaintenanceWindow;
use Acme\DigitalOcean\Generated\Model\DedicatedInferenceAccelerator;
use Acme\DigitalOcean\Generated\Model\DedicatedInferenceCreateRequest;
use Acme\DigitalOcean\Generated\Model\DedicatedInferenceGpuModelConfigsResponse;
use Acme\DigitalOcean\Generated\Model\DedicatedInferenceSizesResponse;
use Acme\DigitalOcean\Generated\Model\DedicatedInferenceTokenCreateRequest;
use Acme\DigitalOcean\Generated\Model\DedicatedInferenceUpdateRequest;
use Acme\DigitalOcean\Generated\Model\DestinationRequest;
use Acme\DigitalOcean\Generated\Model\DestroyAssociatedKubernetesResources;
use Acme\DigitalOcean\Generated\Model\Domain;
use Acme\DigitalOcean\Generated\Model\DomainRecord;
use Acme\DigitalOcean\Generated\Model\FloatingIpCreate;
use Acme\DigitalOcean\Generated\Model\ImageNewCustom;
use Acme\DigitalOcean\Generated\Model\ImageUpdate;
use Acme\DigitalOcean\Generated\Model\ImagesPostAccountTransferAccept;
use Acme\DigitalOcean\Generated\Model\ImagesPostAccountTransferCancel;
use Acme\DigitalOcean\Generated\Model\ImagesPostAccountTransferCreate;
use Acme\DigitalOcean\Generated\Model\ImagesPostAccountTransferDecline;
use Acme\DigitalOcean\Generated\Model\ImagesResponse;
use Acme\DigitalOcean\Generated\Model\Key;
use Acme\DigitalOcean\Generated\Model\KubernetesNodePool;
use Acme\DigitalOcean\Generated\Model\KubernetesNodePoolUpdate;
use Acme\DigitalOcean\Generated\Model\ListModelsResponse;
use Acme\DigitalOcean\Generated\Model\LoadBalancerCreate;
use Acme\DigitalOcean\Generated\Model\LogsinkUpdate;
use Acme\DigitalOcean\Generated\Model\MultiregistryCreate;
use Acme\DigitalOcean\Generated\Model\NfsRequest;
use Acme\DigitalOcean\Generated\Model\OneClicksCreate;
use Acme\DigitalOcean\Generated\Model\PartnerAttachmentUpdatable;
use Acme\DigitalOcean\Generated\Model\PartnerAttachmentWritable;
use Acme\DigitalOcean\Generated\Model\Project;
use Acme\DigitalOcean\Generated\Model\ProjectAssignment;
use Acme\DigitalOcean\Generated\Model\PurgeCache;
use Acme\DigitalOcean\Generated\Model\RegistryCreate;
use Acme\DigitalOcean\Generated\Model\RegistryRunGc;
use Acme\DigitalOcean\Generated\Model\ReservedIpCreate;
use Acme\DigitalOcean\Generated\Model\ReservedIpv6Create;
use Acme\DigitalOcean\Generated\Model\SelectiveDestroyAssociatedResource;
use Acme\DigitalOcean\Generated\Model\SourceDatabase;
use Acme\DigitalOcean\Generated\Model\SqlMode;
use Acme\DigitalOcean\Generated\Model\SshKeyFingerprint;
use Acme\DigitalOcean\Generated\Model\SshKeyId;
use Acme\DigitalOcean\Generated\Model\SshKeys;
use Acme\DigitalOcean\Generated\Model\Tags;
use Acme\DigitalOcean\Generated\Model\TagsResource;
use Acme\DigitalOcean\Generated\Model\UpdateEndpoint;
use Acme\DigitalOcean\Generated\Model\UpdateRegistry;
use Acme\DigitalOcean\Generated\Model\UpdateTrigger;
use Acme\DigitalOcean\Generated\Model\ValidateRegistry;
use Acme\DigitalOcean\Generated\Model\Version2;
use Acme\DigitalOcean\Generated\Model\VpcNatGatewayCreate;
use Acme\DigitalOcean\Generated\Model\VpcNatGatewayUpdate;
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
        private string $bearerToken,
        private Hydrator $hydrator = new Hydrator(),
        private Marshaller $marshaller = new Marshaller(),
    ) {
    }

    public function agentInference_create_chat_completion(
        bool $agent,
        ChatCompletionRequest $body,
    ): ChatCompletionResponse {
        $path = '/api/v1/chat/completions';
        $query = [];
        $query[] = 'agent=' . \urlencode((string) $agent);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ChatCompletionResponse::class, $data);
    }

    public function inference_create_async_invoke(AsyncInvokeRequest $body): AsyncInvokeResponse
    {
        $path = '/v1/async-invoke';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(AsyncInvokeResponse::class, $data);
    }

    public function inference_create_chat_completion(ChatCompletionRequest $body): ChatCompletionResponse
    {
        $path = '/v1/chat/completions';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ChatCompletionResponse::class, $data);
    }

    public function inference_create_image(CreateImageRequest $body): ImagesResponse
    {
        $path = '/v1/images/generations';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ImagesResponse::class, $data);
    }

    public function inference_list_models(): ListModelsResponse
    {
        $path = '/v1/models';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ListModelsResponse::class, $data);
    }

    public function inference_create_response(CreateResponseRequest $body): CreateResponseResponse
    {
        $path = '/v1/responses';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(CreateResponseResponse::class, $data);
    }

    public function oneClicks_list(?OneClicksListType $type = null): void
    {
        $path = '/v2/1-clicks';
        $query = [];
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function oneClicks_install_kubernetes(OneClicksCreate $body): void
    {
        $path = '/v2/1-clicks/kubernetes';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function account_get(): void
    {
        $path = '/v2/account';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function sshKeys_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/account/keys';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function sshKeys_create(SshKeys $body): void
    {
        $path = '/v2/account/keys';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function sshKeys_get(SshKeyId|SshKeyFingerprint $ssh_key_identifier): void
    {
        $path = '/v2/account/keys/{ssh_key_identifier}';
        $path = \str_replace('{ssh_key_identifier}', (string) $ssh_key_identifier, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function sshKeys_delete(SshKeyId|SshKeyFingerprint $ssh_key_identifier): void
    {
        $path = '/v2/account/keys/{ssh_key_identifier}';
        $path = \str_replace('{ssh_key_identifier}', (string) $ssh_key_identifier, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actions_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/actions';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function actions_get(int $action_id): void
    {
        $path = '/v2/actions/{action_id}';
        $path = \str_replace('{action_id}', (string) $action_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function addons_get_app(): void
    {
        $path = '/v2/add-ons/apps';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function addons_get_app_metadata(string $app_slug): void
    {
        $path = '/v2/add-ons/apps/{app_slug}/metadata';
        $path = \str_replace('{app_slug}', $app_slug, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function addons_list(): void
    {
        $path = '/v2/add-ons/saas';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function addons_get(string $resource_uuid): void
    {
        $path = '/v2/add-ons/saas/{resource_uuid}';
        $path = \str_replace('{resource_uuid}', $resource_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function addons_delete(string $resource_uuid): void
    {
        $path = '/v2/add-ons/saas/{resource_uuid}';
        $path = \str_replace('{resource_uuid}', $resource_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_list(?int $page = null, ?int $per_page = null, ?bool $with_projects = null): void
    {
        $path = '/v2/apps';
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($with_projects !== null) {
            $query[] = 'with_projects=' . \urlencode((string) $with_projects);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_list_metrics_bandwidth_daily(AppMetricsBandwidthUsageRequest $body): void
    {
        $path = '/v2/apps/metrics/bandwidth_daily';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_validate_appSpec(AppPropose $body): void
    {
        $path = '/v2/apps/propose';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_list_regions(): void
    {
        $path = '/v2/apps/regions';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_list_instanceSizes(): void
    {
        $path = '/v2/apps/tiers/instance_sizes';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_instanceSize(string $slug): void
    {
        $path = '/v2/apps/tiers/instance_sizes/{slug}';
        $path = \str_replace('{slug}', $slug, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_list_alerts(string $app_id): void
    {
        $path = '/v2/apps/{app_id}/alerts';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_assign_alertDestinations(
        string $app_id,
        string $alert_id,
        AppsAssignAppAlertDestinationsRequest $body,
    ): void {
        $path = '/v2/apps/{app_id}/alerts/{alert_id}/destinations';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{alert_id}', $alert_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_exec_active_deployment(
        string $app_id,
        string $component_name,
        ?string $instance_name = null,
    ): void {
        $path = '/v2/apps/{app_id}/components/{component_name}/exec';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{component_name}', $component_name, $path);
        $query = [];
        if ($instance_name !== null) {
            $query[] = 'instance_name=' . \urlencode($instance_name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_logs_active_deployment(
        string $app_id,
        string $component_name,
        AppsGetLogsActiveDeploymentType $type,
        ?bool $follow = null,
        ?string $pod_connection_timeout = null,
    ): void {
        $path = '/v2/apps/{app_id}/components/{component_name}/logs';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{component_name}', $component_name, $path);
        $query = [];
        if ($follow !== null) {
            $query[] = 'follow=' . \urlencode((string) $follow);
        }
        $query[] = 'type=' . \urlencode($type->value);
        if ($pod_connection_timeout !== null) {
            $query[] = 'pod_connection_timeout=' . \urlencode($pod_connection_timeout);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @param list<string> $deployment_types
     */
    public function apps_list_deployments(
        string $app_id,
        ?int $page = null,
        ?int $per_page = null,
        ?array $deployment_types = null,
    ): void {
        $path = '/v2/apps/{app_id}/deployments';
        $path = \str_replace('{app_id}', $app_id, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($deployment_types !== null) { foreach ($deployment_types as $__v) { $query[] = 'deployment_types=' . \urlencode($__v->value); } }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_create_deployment(string $app_id, AppsCreateDeploymentRequest $body): void
    {
        $path = '/v2/apps/{app_id}/deployments';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_deployment(string $app_id, string $deployment_id): void
    {
        $path = '/v2/apps/{app_id}/deployments/{deployment_id}';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{deployment_id}', $deployment_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_cancel_deployment(string $app_id, string $deployment_id): void
    {
        $path = '/v2/apps/{app_id}/deployments/{deployment_id}/cancel';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{deployment_id}', $deployment_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_exec(
        string $app_id,
        string $deployment_id,
        string $component_name,
        ?string $instance_name = null,
    ): void {
        $path = '/v2/apps/{app_id}/deployments/{deployment_id}/components/{component_name}/exec';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{deployment_id}', $deployment_id, $path);
        $path = \str_replace('{component_name}', $component_name, $path);
        $query = [];
        if ($instance_name !== null) {
            $query[] = 'instance_name=' . \urlencode($instance_name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_logs(
        string $app_id,
        string $deployment_id,
        string $component_name,
        AppsGetLogsType $type,
        ?bool $follow = null,
        ?string $pod_connection_timeout = null,
    ): void {
        $path = '/v2/apps/{app_id}/deployments/{deployment_id}/components/{component_name}/logs';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{deployment_id}', $deployment_id, $path);
        $path = \str_replace('{component_name}', $component_name, $path);
        $query = [];
        if ($follow !== null) {
            $query[] = 'follow=' . \urlencode((string) $follow);
        }
        $query[] = 'type=' . \urlencode($type->value);
        if ($pod_connection_timeout !== null) {
            $query[] = 'pod_connection_timeout=' . \urlencode($pod_connection_timeout);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_logs_aggregate(
        string $app_id,
        string $deployment_id,
        AppsGetLogsAggregateType $type,
        ?bool $follow = null,
        ?string $pod_connection_timeout = null,
    ): void {
        $path = '/v2/apps/{app_id}/deployments/{deployment_id}/logs';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{deployment_id}', $deployment_id, $path);
        $query = [];
        if ($follow !== null) {
            $query[] = 'follow=' . \urlencode((string) $follow);
        }
        $query[] = 'type=' . \urlencode($type->value);
        if ($pod_connection_timeout !== null) {
            $query[] = 'pod_connection_timeout=' . \urlencode($pod_connection_timeout);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @param list<string> $event_types
     */
    public function apps_list_events(
        string $app_id,
        ?int $page = null,
        ?int $per_page = null,
        ?array $event_types = null,
    ): void {
        $path = '/v2/apps/{app_id}/events';
        $path = \str_replace('{app_id}', $app_id, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($event_types !== null) { foreach ($event_types as $__v) { $query[] = 'event_types=' . \urlencode($__v->value); } }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_event(string $app_id, string $event_id): void
    {
        $path = '/v2/apps/{app_id}/events/{event_id}';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{event_id}', $event_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_cancel_event(string $app_id, string $event_id): void
    {
        $path = '/v2/apps/{app_id}/events/{event_id}/cancel';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{event_id}', $event_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_event_logs(
        string $app_id,
        string $event_id,
        AppsGetEventLogsType $type,
        ?bool $follow = null,
        ?string $pod_connection_timeout = null,
    ): void {
        $path = '/v2/apps/{app_id}/events/{event_id}/logs';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{event_id}', $event_id, $path);
        $query = [];
        if ($follow !== null) {
            $query[] = 'follow=' . \urlencode((string) $follow);
        }
        $query[] = 'type=' . \urlencode($type->value);
        if ($pod_connection_timeout !== null) {
            $query[] = 'pod_connection_timeout=' . \urlencode($pod_connection_timeout);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_health(string $app_id): void
    {
        $path = '/v2/apps/{app_id}/health';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_instances(string $app_id): void
    {
        $path = '/v2/apps/{app_id}/instances';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_job_invocation(string $app_id, string $job_invocation_id, ?string $job_name = null): void
    {
        $path = '/v2/apps/{app_id}/job-invocations/{job_invocation_id}';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{job_invocation_id}', $job_invocation_id, $path);
        $query = [];
        if ($job_name !== null) {
            $query[] = 'job_name=' . \urlencode($job_name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_cancel_job_invocation(
        string $app_id,
        string $job_invocation_id,
        ?string $job_name = null,
    ): void {
        $path = '/v2/apps/{app_id}/job-invocations/{job_invocation_id}/cancel';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{job_invocation_id}', $job_invocation_id, $path);
        $query = [];
        if ($job_name !== null) {
            $query[] = 'job_name=' . \urlencode($job_name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_job_invocation_logs(
        string $app_id,
        string $job_name,
        string $job_invocation_id,
        AppsGetJobInvocationLogsType $type,
        ?string $deployment_id = null,
        ?bool $follow = null,
        ?string $pod_connection_timeout = null,
        ?string $tail_lines = null,
    ): void {
        $path = '/v2/apps/{app_id}/jobs/{job_name}/invocations/{job_invocation_id}/logs';
        $path = \str_replace('{app_id}', $app_id, $path);
        $path = \str_replace('{job_name}', $job_name, $path);
        $path = \str_replace('{job_invocation_id}', $job_invocation_id, $path);
        $query = [];
        if ($deployment_id !== null) {
            $query[] = 'deployment_id=' . \urlencode($deployment_id);
        }
        if ($follow !== null) {
            $query[] = 'follow=' . \urlencode((string) $follow);
        }
        $query[] = 'type=' . \urlencode($type->value);
        if ($pod_connection_timeout !== null) {
            $query[] = 'pod_connection_timeout=' . \urlencode($pod_connection_timeout);
        }
        if ($tail_lines !== null) {
            $query[] = 'tail_lines=' . \urlencode($tail_lines);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_logs_active_deployment_aggregate(
        string $app_id,
        AppsGetLogsActiveDeploymentAggregateType $type,
        ?bool $follow = null,
        ?string $pod_connection_timeout = null,
    ): void {
        $path = '/v2/apps/{app_id}/logs';
        $path = \str_replace('{app_id}', $app_id, $path);
        $query = [];
        if ($follow !== null) {
            $query[] = 'follow=' . \urlencode((string) $follow);
        }
        $query[] = 'type=' . \urlencode($type->value);
        if ($pod_connection_timeout !== null) {
            $query[] = 'pod_connection_timeout=' . \urlencode($pod_connection_timeout);
        }
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get_metrics_bandwidth_daily(string $app_id, ?\DateTimeImmutable $date = null): void
    {
        $path = '/v2/apps/{app_id}/metrics/bandwidth_daily';
        $path = \str_replace('{app_id}', $app_id, $path);
        $query = [];
        if ($date !== null) {
            $query[] = 'date=' . \urlencode($date->format(\DateTimeInterface::RFC3339));
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_restart(string $app_id, AppsRestartRequest $body): void
    {
        $path = '/v2/apps/{app_id}/restart';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_create_rollback(string $app_id, AppsRollbackAppRequest $body): void
    {
        $path = '/v2/apps/{app_id}/rollback';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_commit_rollback(string $app_id): void
    {
        $path = '/v2/apps/{app_id}/rollback/commit';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_revert_rollback(string $app_id): void
    {
        $path = '/v2/apps/{app_id}/rollback/revert';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_validate_rollback(string $app_id, AppsRollbackAppRequest $body): void
    {
        $path = '/v2/apps/{app_id}/rollback/validate';
        $path = \str_replace('{app_id}', $app_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_get(string $id, ?string $name = null): void
    {
        $path = '/v2/apps/{id}';
        $path = \str_replace('{id}', $id, $path);
        $query = [];
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_update(string $id, AppsUpdateAppRequest $body): void
    {
        $path = '/v2/apps/{id}';
        $path = \str_replace('{id}', $id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function apps_delete(string $id): void
    {
        $path = '/v2/apps/{id}';
        $path = \str_replace('{id}', $id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingInsights_list(
        string $account_urn,
        \DateTimeImmutable $start_date,
        \DateTimeImmutable $end_date,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/billing/{account_urn}/insights/{start_date}/{end_date}';
        $path = \str_replace('{account_urn}', $account_urn, $path);
        $path = \str_replace('{start_date}', $start_date->format('Y-m-d'), $path);
        $path = \str_replace('{end_date}', $end_date->format('Y-m-d'), $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function byoipPrefixes_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/byoip_prefixes';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function byoipPrefixes_create(ByoipPrefixCreate $body): void
    {
        $path = '/v2/byoip_prefixes';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function byoipPrefixes_get(string $byoip_prefix_uuid): void
    {
        $path = '/v2/byoip_prefixes/{byoip_prefix_uuid}';
        $path = \str_replace('{byoip_prefix_uuid}', $byoip_prefix_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function byoipPrefixes_delete(string $byoip_prefix_uuid): void
    {
        $path = '/v2/byoip_prefixes/{byoip_prefix_uuid}';
        $path = \str_replace('{byoip_prefix_uuid}', $byoip_prefix_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function byoipPrefixes_patch(string $byoip_prefix_uuid, ByoipPrefixUpdate $body): void
    {
        $path = '/v2/byoip_prefixes/{byoip_prefix_uuid}';
        $path = \str_replace('{byoip_prefix_uuid}', $byoip_prefix_uuid, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function byoipPrefixes_list_resources(
        string $byoip_prefix_uuid,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/byoip_prefixes/{byoip_prefix_uuid}/ips';
        $path = \str_replace('{byoip_prefix_uuid}', $byoip_prefix_uuid, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function cdn_list_endpoints(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/cdn/endpoints';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function cdn_create_endpoint(CdnEndpoint $body): void
    {
        $path = '/v2/cdn/endpoints';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function cdn_get_endpoint(string $cdn_id): void
    {
        $path = '/v2/cdn/endpoints/{cdn_id}';
        $path = \str_replace('{cdn_id}', $cdn_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function cdn_update_endpoints(string $cdn_id, UpdateEndpoint $body): void
    {
        $path = '/v2/cdn/endpoints/{cdn_id}';
        $path = \str_replace('{cdn_id}', $cdn_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function cdn_delete_endpoint(string $cdn_id): void
    {
        $path = '/v2/cdn/endpoints/{cdn_id}';
        $path = \str_replace('{cdn_id}', $cdn_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function cdn_purge_cache(string $cdn_id, PurgeCache $body): void
    {
        $path = '/v2/cdn/endpoints/{cdn_id}/cache';
        $path = \str_replace('{cdn_id}', $cdn_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function certificates_list(?int $per_page = null, ?int $page = null, ?string $name = null): void
    {
        $path = '/v2/certificates';
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
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function certificates_get(string $certificate_id): void
    {
        $path = '/v2/certificates/{certificate_id}';
        $path = \str_replace('{certificate_id}', $certificate_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function certificates_delete(string $certificate_id): void
    {
        $path = '/v2/certificates/{certificate_id}';
        $path = \str_replace('{certificate_id}', $certificate_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function balance_get(): void
    {
        $path = '/v2/customers/my/balance';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function billingHistory_list(): void
    {
        $path = '/v2/customers/my/billing_history';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function invoices_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/customers/my/invoices';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function invoices_get_byUUID(string $invoice_uuid, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/customers/my/invoices/{invoice_uuid}';
        $path = \str_replace('{invoice_uuid}', $invoice_uuid, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function invoices_get_csvByUUID(string $invoice_uuid): void
    {
        $path = '/v2/customers/my/invoices/{invoice_uuid}/csv';
        $path = \str_replace('{invoice_uuid}', $invoice_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function invoices_get_pdfByUUID(string $invoice_uuid): void
    {
        $path = '/v2/customers/my/invoices/{invoice_uuid}/pdf';
        $path = \str_replace('{invoice_uuid}', $invoice_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function invoices_get_summaryByUUID(string $invoice_uuid): void
    {
        $path = '/v2/customers/my/invoices/{invoice_uuid}/summary';
        $path = \str_replace('{invoice_uuid}', $invoice_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_clusters(?string $tag_name = null): void
    {
        $path = '/v2/databases';
        $query = [];
        if ($tag_name !== null) {
            $query[] = 'tag_name=' . \urlencode($tag_name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_cluster_metrics_credentials(): void
    {
        $path = '/v2/databases/metrics/credentials';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_options(): void
    {
        $path = '/v2/databases/options';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_cluster(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_destroy_cluster(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_autoscale(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/autoscale';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_update_autoscale(string $database_cluster_uuid, DatabaseAutoscaleParams $body): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/autoscale';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_backups(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/backups';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_ca(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/ca';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_config(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/config';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_patch_config(string $database_cluster_uuid, DatabaseConfig $body): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/config';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/dbs';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_add(string $database_cluster_uuid, Database $body): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/dbs';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get(string $database_cluster_uuid, string $database_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/dbs/{database_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{database_name}', $database_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_delete(string $database_cluster_uuid, string $database_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/dbs/{database_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{database_name}', $database_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_events_logs(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/events';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_evictionPolicy(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/eviction_policy';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_firewall_rules(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/firewall';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_opeasearch_indexes(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/indexes';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_delete_opensearch_index(string $database_cluster_uuid, string $index_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/indexes/{index_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{index_name}', $index_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_install_update(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/install_update';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_logsink(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/logsink';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_logsink(string $database_cluster_uuid, string $logsink_id): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/logsink/{logsink_id}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{logsink_id}', $logsink_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_update_logsink(
        string $database_cluster_uuid,
        string $logsink_id,
        LogsinkUpdate $body,
    ): void {
        $path = '/v2/databases/{database_cluster_uuid}/logsink/{logsink_id}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{logsink_id}', $logsink_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_delete_logsink(string $database_cluster_uuid, string $logsink_id): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/logsink/{logsink_id}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{logsink_id}', $logsink_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_update_maintenanceWindow(
        string $database_cluster_uuid,
        DatabaseMaintenanceWindow $body,
    ): void {
        $path = '/v2/databases/{database_cluster_uuid}/maintenance';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_migrationStatus(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/online-migration';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_update_onlineMigration(string $database_cluster_uuid, SourceDatabase $body): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/online-migration';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_delete_onlineMigration(string $database_cluster_uuid, string $migration_id): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/online-migration/{migration_id}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{migration_id}', $migration_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_connectionPools(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/pools';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_add_connectionPool(string $database_cluster_uuid, ConnectionPool $body): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/pools';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_connectionPool(string $database_cluster_uuid, string $pool_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/pools/{pool_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{pool_name}', $pool_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_update_connectionPool(
        string $database_cluster_uuid,
        string $pool_name,
        ConnectionPoolUpdate $body,
    ): void {
        $path = '/v2/databases/{database_cluster_uuid}/pools/{pool_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{pool_name}', $pool_name, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_delete_connectionPool(string $database_cluster_uuid, string $pool_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/pools/{pool_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{pool_name}', $pool_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_replicas(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/replicas';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_replica(string $database_cluster_uuid, string $replica_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/replicas/{replica_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{replica_name}', $replica_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_destroy_replica(string $database_cluster_uuid, string $replica_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/replicas/{replica_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{replica_name}', $replica_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_promote_replica(string $database_cluster_uuid, string $replica_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/replicas/{replica_name}/promote';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{replica_name}', $replica_name, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_update_clusterSize(string $database_cluster_uuid, DatabaseClusterResize $body): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/resize';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_kafka_schemas(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/schema-registry';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_kafka_schema_config(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/schema-registry/config';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_kafka_schema_subject_config(
        string $database_cluster_uuid,
        string $subject_name,
    ): void {
        $path = '/v2/databases/{database_cluster_uuid}/schema-registry/config/{subject_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{subject_name}', $subject_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_kafka_schema(string $database_cluster_uuid, string $subject_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/schema-registry/{subject_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{subject_name}', $subject_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_delete_kafka_schema(string $database_cluster_uuid, string $subject_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/schema-registry/{subject_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{subject_name}', $subject_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_kafka_schema_version(
        string $database_cluster_uuid,
        string $subject_name,
        string $version,
    ): void {
        $path = '/v2/databases/{database_cluster_uuid}/schema-registry/{subject_name}/versions/{version}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{subject_name}', $subject_name, $path);
        $path = \str_replace('{version}', $version, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_sql_mode(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/sql_mode';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_update_sql_mode(string $database_cluster_uuid, SqlMode $body): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/sql_mode';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_kafka_topics(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/topics';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_kafka_topic(string $database_cluster_uuid, string $topic_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/topics/{topic_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{topic_name}', $topic_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_delete_kafka_topic(string $database_cluster_uuid, string $topic_name): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/topics/{topic_name}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{topic_name}', $topic_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_update_major_version(string $database_cluster_uuid, Version2 $body): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/upgrade';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_list_users(string $database_cluster_uuid): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/users';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_get_user(string $database_cluster_uuid, string $username): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/users/{username}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function databases_delete_user(string $database_cluster_uuid, string $username): void
    {
        $path = '/v2/databases/{database_cluster_uuid}/users/{username}';
        $path = \str_replace('{database_cluster_uuid}', $database_cluster_uuid, $path);
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_list(
        ?int $per_page = null,
        ?int $page = null,
        ?DedicatedInferencesListRegion $region = null,
    ): void {
        $path = '/v2/dedicated-inferences';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($region !== null) {
            $query[] = 'region=' . \urlencode($region->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_create(DedicatedInferenceCreateRequest $body): void
    {
        $path = '/v2/dedicated-inferences';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_get_gpu_model_config(): DedicatedInferenceGpuModelConfigsResponse
    {
        $path = '/v2/dedicated-inferences/gpu-model-config';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DedicatedInferenceGpuModelConfigsResponse::class, $data);
    }

    public function dedicatedInferences_list_sizes(): DedicatedInferenceSizesResponse
    {
        $path = '/v2/dedicated-inferences/sizes';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DedicatedInferenceSizesResponse::class, $data);
    }

    public function dedicatedInferences_get(string $dedicated_inference_id): void
    {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_delete(string $dedicated_inference_id): void
    {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_patch(
        string $dedicated_inference_id,
        DedicatedInferenceUpdateRequest $body,
    ): void {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_list_accelerators(
        string $dedicated_inference_id,
        ?int $per_page = null,
        ?int $page = null,
        ?string $slug = null,
    ): void {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}/accelerators';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($slug !== null) {
            $query[] = 'slug=' . \urlencode($slug);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_get_accelerator(
        string $dedicated_inference_id,
        string $accelerator_id,
    ): DedicatedInferenceAccelerator {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}/accelerators/{accelerator_id}';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $path = \str_replace('{accelerator_id}', $accelerator_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(DedicatedInferenceAccelerator::class, $data);
    }

    public function dedicatedInferences_get_ca(string $dedicated_inference_id): void
    {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}/ca';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_list_tokens(
        string $dedicated_inference_id,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}/tokens';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_create_tokens(
        string $dedicated_inference_id,
        DedicatedInferenceTokenCreateRequest $body,
    ): void {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}/tokens';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dedicatedInferences_delete_tokens(string $dedicated_inference_id, string $token_id): void
    {
        $path = '/v2/dedicated-inferences/{dedicated_inference_id}/tokens/{token_id}';
        $path = \str_replace('{dedicated_inference_id}', $dedicated_inference_id, $path);
        $path = \str_replace('{token_id}', $token_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/domains';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_create(Domain $body): void
    {
        $path = '/v2/domains';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_get(string $domain_name): void
    {
        $path = '/v2/domains/{domain_name}';
        $path = \str_replace('{domain_name}', $domain_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_delete(string $domain_name): void
    {
        $path = '/v2/domains/{domain_name}';
        $path = \str_replace('{domain_name}', $domain_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_list_records(
        string $domain_name,
        ?string $name = null,
        ?DomainsListRecordsType $type = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/domains/{domain_name}/records';
        $path = \str_replace('{domain_name}', $domain_name, $path);
        $query = [];
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_get_record(string $domain_name, int $domain_record_id): void
    {
        $path = '/v2/domains/{domain_name}/records/{domain_record_id}';
        $path = \str_replace('{domain_name}', $domain_name, $path);
        $path = \str_replace('{domain_record_id}', (string) $domain_record_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_update_record(string $domain_name, int $domain_record_id, DomainRecord $body): void
    {
        $path = '/v2/domains/{domain_name}/records/{domain_record_id}';
        $path = \str_replace('{domain_name}', $domain_name, $path);
        $path = \str_replace('{domain_record_id}', (string) $domain_record_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_delete_record(string $domain_name, int $domain_record_id): void
    {
        $path = '/v2/domains/{domain_name}/records/{domain_record_id}';
        $path = \str_replace('{domain_name}', $domain_name, $path);
        $path = \str_replace('{domain_record_id}', (string) $domain_record_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function domains_patch_record(string $domain_name, int $domain_record_id, DomainRecord $body): void
    {
        $path = '/v2/domains/{domain_name}/records/{domain_record_id}';
        $path = \str_replace('{domain_name}', $domain_name, $path);
        $path = \str_replace('{domain_record_id}', (string) $domain_record_id, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list(
        ?int $per_page = null,
        ?int $page = null,
        ?string $tag_name = null,
        ?string $name = null,
        ?DropletsListType $type = null,
    ): void {
        $path = '/v2/droplets';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($tag_name !== null) {
            $query[] = 'tag_name=' . \urlencode($tag_name);
        }
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_destroy_byTag(string $tag_name): void
    {
        $path = '/v2/droplets';
        $query = [];
        $query[] = 'tag_name=' . \urlencode($tag_name);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function autoscalepools_list(?int $per_page = null, ?int $page = null, ?string $name = null): void
    {
        $path = '/v2/droplets/autoscale';
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
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function autoscalepools_create(AutoscalePoolCreate $body): void
    {
        $path = '/v2/droplets/autoscale';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function autoscalepools_get(string $autoscale_pool_id): void
    {
        $path = '/v2/droplets/autoscale/{autoscale_pool_id}';
        $path = \str_replace('{autoscale_pool_id}', $autoscale_pool_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function autoscalepools_update(string $autoscale_pool_id, AutoscalePoolCreate $body): void
    {
        $path = '/v2/droplets/autoscale/{autoscale_pool_id}';
        $path = \str_replace('{autoscale_pool_id}', $autoscale_pool_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function autoscalepools_delete(string $autoscale_pool_id): void
    {
        $path = '/v2/droplets/autoscale/{autoscale_pool_id}';
        $path = \str_replace('{autoscale_pool_id}', $autoscale_pool_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function autoscalepools_list_history(
        string $autoscale_pool_id,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/droplets/autoscale/{autoscale_pool_id}/history';
        $path = \str_replace('{autoscale_pool_id}', $autoscale_pool_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function autoscalepools_list_members(
        string $autoscale_pool_id,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/droplets/autoscale/{autoscale_pool_id}/members';
        $path = \str_replace('{autoscale_pool_id}', $autoscale_pool_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_backup_policies(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/droplets/backups/policies';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_supported_backup_policies(): void
    {
        $path = '/v2/droplets/backups/supported_policies';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_get(int $droplet_id): void
    {
        $path = '/v2/droplets/{droplet_id}';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_destroy(int $droplet_id): void
    {
        $path = '/v2/droplets/{droplet_id}';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dropletActions_list(int $droplet_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/droplets/{droplet_id}/actions';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function dropletActions_get(int $droplet_id, int $action_id): void
    {
        $path = '/v2/droplets/{droplet_id}/actions/{action_id}';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $path = \str_replace('{action_id}', (string) $action_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_backups(int $droplet_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/droplets/{droplet_id}/backups';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_get_backup_policy(int $droplet_id): void
    {
        $path = '/v2/droplets/{droplet_id}/backups/policy';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_associatedResources(int $droplet_id): void
    {
        $path = '/v2/droplets/{droplet_id}/destroy_with_associated_resources';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_destroy_retryWithAssociatedResources(int $droplet_id): void
    {
        $path = '/v2/droplets/{droplet_id}/destroy_with_associated_resources/retry';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_destroy_withAssociatedResourcesSelective(
        int $droplet_id,
        SelectiveDestroyAssociatedResource $body,
    ): void {
        $path = '/v2/droplets/{droplet_id}/destroy_with_associated_resources/selective';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_get_DestroyAssociatedResourcesStatus(int $droplet_id): void
    {
        $path = '/v2/droplets/{droplet_id}/destroy_with_associated_resources/status';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_firewalls(int $droplet_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/droplets/{droplet_id}/firewalls';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_kernels(int $droplet_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/droplets/{droplet_id}/kernels';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_neighbors(int $droplet_id): void
    {
        $path = '/v2/droplets/{droplet_id}/neighbors';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_snapshots(int $droplet_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/droplets/{droplet_id}/snapshots';
        $path = \str_replace('{droplet_id}', (string) $droplet_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function firewalls_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/firewalls';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function firewalls_get(string $firewall_id): void
    {
        $path = '/v2/firewalls/{firewall_id}';
        $path = \str_replace('{firewall_id}', $firewall_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function firewalls_delete(string $firewall_id): void
    {
        $path = '/v2/firewalls/{firewall_id}';
        $path = \str_replace('{firewall_id}', $firewall_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function floatingIPs_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/floating_ips';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function floatingIPs_create(FloatingIpCreate $body): void
    {
        $path = '/v2/floating_ips';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function floatingIPs_get(string $floating_ip): void
    {
        $path = '/v2/floating_ips/{floating_ip}';
        $path = \str_replace('{floating_ip}', $floating_ip, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function floatingIPs_delete(string $floating_ip): void
    {
        $path = '/v2/floating_ips/{floating_ip}';
        $path = \str_replace('{floating_ip}', $floating_ip, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function floatingIPsAction_list(string $floating_ip): void
    {
        $path = '/v2/floating_ips/{floating_ip}/actions';
        $path = \str_replace('{floating_ip}', $floating_ip, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function floatingIPsAction_get(string $floating_ip, int $action_id): void
    {
        $path = '/v2/floating_ips/{floating_ip}/actions/{action_id}';
        $path = \str_replace('{floating_ip}', $floating_ip, $path);
        $path = \str_replace('{action_id}', (string) $action_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_list_namespaces(): void
    {
        $path = '/v2/functions/namespaces';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_create_namespace(CreateNamespace $body): void
    {
        $path = '/v2/functions/namespaces';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_get_namespace(string $namespace_id): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_delete_namespace(string $namespace_id): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functionsAccessKey_list(string $namespace_id): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}/keys';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functionsAccessKey_create(string $namespace_id, AccessKeyCreateRequest $body): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}/keys';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functionsAccessKey_delete(string $namespace_id, string $key_id): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}/keys/{key_id}';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $path = \str_replace('{key_id}', $key_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_list_triggers(string $namespace_id): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}/triggers';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_create_trigger(string $namespace_id, CreateTrigger $body): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}/triggers';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_get_trigger(string $namespace_id, string $trigger_name): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}/triggers/{trigger_name}';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $path = \str_replace('{trigger_name}', $trigger_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_update_trigger(string $namespace_id, string $trigger_name, UpdateTrigger $body): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}/triggers/{trigger_name}';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $path = \str_replace('{trigger_name}', $trigger_name, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function functions_delete_trigger(string $namespace_id, string $trigger_name): void
    {
        $path = '/v2/functions/namespaces/{namespace_id}/triggers/{trigger_name}';
        $path = \str_replace('{namespace_id}', $namespace_id, $path);
        $path = \str_replace('{trigger_name}', $trigger_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function genai_list_agents(
        ?bool $only_deployed = null,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListAgentsOutputPublic {
        $path = '/v2/gen-ai/agents';
        $query = [];
        if ($only_deployed !== null) {
            $query[] = 'only_deployed=' . \urlencode((string) $only_deployed);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListAgentsOutputPublic::class, $data);
    }

    public function genai_create_agent(ApiCreateAgentInputPublic $body): ApiCreateAgentOutput
    {
        $path = '/v2/gen-ai/agents';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateAgentOutput::class, $data);
    }

    public function genai_list_agent_api_keys(
        string $agent_uuid,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListAgentApikeysOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/api_keys';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListAgentApikeysOutput::class, $data);
    }

    public function genai_create_agent_api_key(
        string $agent_uuid,
        ApiCreateAgentApikeyInputPublic $body,
    ): ApiCreateAgentApikeyOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/api_keys';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateAgentApikeyOutput::class, $data);
    }

    public function genai_update_agent_api_key(
        string $agent_uuid,
        string $api_key_uuid,
        ApiUpdateAgentApikeyInputPublic $body,
    ): ApiUpdateAgentApikeyOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/api_keys/{api_key_uuid}';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateAgentApikeyOutput::class, $data);
    }

    public function genai_delete_agent_api_key(string $agent_uuid, string $api_key_uuid): ApiDeleteAgentApikeyOutput
    {
        $path = '/v2/gen-ai/agents/{agent_uuid}/api_keys/{api_key_uuid}';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteAgentApikeyOutput::class, $data);
    }

    public function genai_regenerate_agent_api_key(
        string $agent_uuid,
        string $api_key_uuid,
    ): ApiRegenerateAgentApikeyOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/api_keys/{api_key_uuid}/regenerate';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiRegenerateAgentApikeyOutput::class, $data);
    }

    public function genai_attach_agent_function(
        string $agent_uuid,
        ApiLinkAgentFunctionInputPublic $body,
    ): ApiLinkAgentFunctionOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/functions';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiLinkAgentFunctionOutput::class, $data);
    }

    public function genai_update_agent_function(
        string $agent_uuid,
        string $function_uuid,
        ApiUpdateAgentFunctionInputPublic $body,
    ): ApiUpdateAgentFunctionOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/functions/{function_uuid}';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $path = \str_replace('{function_uuid}', $function_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateAgentFunctionOutput::class, $data);
    }

    public function genai_detach_agent_function(
        string $agent_uuid,
        string $function_uuid,
    ): ApiUnlinkAgentFunctionOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/functions/{function_uuid}';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $path = \str_replace('{function_uuid}', $function_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUnlinkAgentFunctionOutput::class, $data);
    }

    public function genai_attach_agent_guardrails(
        string $agent_uuid,
        ApiLinkAgentGuardrailsInputPublic $body,
    ): ApiLinkAgentGuardrailOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/guardrails';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiLinkAgentGuardrailOutput::class, $data);
    }

    public function genai_detach_agent_guardrail(
        string $agent_uuid,
        string $guardrail_uuid,
    ): ApiUnlinkAgentGuardrailOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/guardrails/{guardrail_uuid}';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $path = \str_replace('{guardrail_uuid}', $guardrail_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUnlinkAgentGuardrailOutput::class, $data);
    }

    public function genai_attach_knowledge_bases(string $agent_uuid): ApiLinkKnowledgeBaseOutput
    {
        $path = '/v2/gen-ai/agents/{agent_uuid}/knowledge_bases';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiLinkKnowledgeBaseOutput::class, $data);
    }

    public function genai_attach_knowledge_base(
        string $agent_uuid,
        string $knowledge_base_uuid,
    ): ApiLinkKnowledgeBaseOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/knowledge_bases/{knowledge_base_uuid}';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $path = \str_replace('{knowledge_base_uuid}', $knowledge_base_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiLinkKnowledgeBaseOutput::class, $data);
    }

    public function genai_detach_knowledge_base(
        string $agent_uuid,
        string $knowledge_base_uuid,
    ): ApiUnlinkKnowledgeBaseOutput {
        $path = '/v2/gen-ai/agents/{agent_uuid}/knowledge_bases/{knowledge_base_uuid}';
        $path = \str_replace('{agent_uuid}', $agent_uuid, $path);
        $path = \str_replace('{knowledge_base_uuid}', $knowledge_base_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUnlinkKnowledgeBaseOutput::class, $data);
    }

    public function genai_update_attached_agent(
        string $parent_agent_uuid,
        string $child_agent_uuid,
        ApiUpdateLinkedAgentInputPublic $body,
    ): ApiUpdateLinkedAgentOutput {
        $path = '/v2/gen-ai/agents/{parent_agent_uuid}/child_agents/{child_agent_uuid}';
        $path = \str_replace('{parent_agent_uuid}', $parent_agent_uuid, $path);
        $path = \str_replace('{child_agent_uuid}', $child_agent_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateLinkedAgentOutput::class, $data);
    }

    public function genai_attach_agent(
        string $parent_agent_uuid,
        string $child_agent_uuid,
        ApiLinkAgentInputPublic $body,
    ): ApiLinkAgentOutput {
        $path = '/v2/gen-ai/agents/{parent_agent_uuid}/child_agents/{child_agent_uuid}';
        $path = \str_replace('{parent_agent_uuid}', $parent_agent_uuid, $path);
        $path = \str_replace('{child_agent_uuid}', $child_agent_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiLinkAgentOutput::class, $data);
    }

    public function genai_detach_agent(string $parent_agent_uuid, string $child_agent_uuid): ApiUnlinkAgentOutput
    {
        $path = '/v2/gen-ai/agents/{parent_agent_uuid}/child_agents/{child_agent_uuid}';
        $path = \str_replace('{parent_agent_uuid}', $parent_agent_uuid, $path);
        $path = \str_replace('{child_agent_uuid}', $child_agent_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUnlinkAgentOutput::class, $data);
    }

    public function genai_get_agent(string $uuid): ApiGetAgentOutput
    {
        $path = '/v2/gen-ai/agents/{uuid}';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetAgentOutput::class, $data);
    }

    public function genai_update_agent(string $uuid, ApiUpdateAgentInputPublic $body): ApiUpdateAgentOutput
    {
        $path = '/v2/gen-ai/agents/{uuid}';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateAgentOutput::class, $data);
    }

    public function genai_delete_agent(string $uuid): ApiDeleteAgentOutput
    {
        $path = '/v2/gen-ai/agents/{uuid}';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteAgentOutput::class, $data);
    }

    public function genai_get_agent_children(string $uuid): ApiGetChildrenOutput
    {
        $path = '/v2/gen-ai/agents/{uuid}/child_agents';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetChildrenOutput::class, $data);
    }

    public function genai_update_agent_deployment_visibility(
        string $uuid,
        ApiUpdateAgentDeploymentVisibilityInputPublic $body,
    ): ApiUpdateAgentDeploymentVisbilityOutput {
        $path = '/v2/gen-ai/agents/{uuid}/deployment_visibility';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateAgentDeploymentVisbilityOutput::class, $data);
    }

    public function genai_get_agent_usage(
        string $uuid,
        ?string $start = null,
        ?string $stop = null,
    ): ApiGetAgentUsageOutput {
        $path = '/v2/gen-ai/agents/{uuid}/usage';
        $path = \str_replace('{uuid}', $uuid, $path);
        $query = [];
        if ($start !== null) {
            $query[] = 'start=' . \urlencode($start);
        }
        if ($stop !== null) {
            $query[] = 'stop=' . \urlencode($stop);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetAgentUsageOutput::class, $data);
    }

    public function genai_list_agent_versions(
        string $uuid,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListAgentVersionsOutput {
        $path = '/v2/gen-ai/agents/{uuid}/versions';
        $path = \str_replace('{uuid}', $uuid, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListAgentVersionsOutput::class, $data);
    }

    public function genai_rollback_to_agent_version(
        string $uuid,
        ApiRollbackToAgentVersionInputPublic $body,
    ): ApiRollbackToAgentVersionOutput {
        $path = '/v2/gen-ai/agents/{uuid}/versions';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiRollbackToAgentVersionOutput::class, $data);
    }

    public function genai_list_anthropic_api_keys(
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListAnthropicApikeysOutput {
        $path = '/v2/gen-ai/anthropic/keys';
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListAnthropicApikeysOutput::class, $data);
    }

    public function genai_create_anthropic_api_key(
        ApiCreateAnthropicApikeyInputPublic $body,
    ): ApiCreateAnthropicApikeyOutput {
        $path = '/v2/gen-ai/anthropic/keys';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateAnthropicApikeyOutput::class, $data);
    }

    public function genai_get_anthropic_api_key(string $api_key_uuid): ApiGetAnthropicApikeyOutput
    {
        $path = '/v2/gen-ai/anthropic/keys/{api_key_uuid}';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetAnthropicApikeyOutput::class, $data);
    }

    public function genai_update_anthropic_api_key(
        string $api_key_uuid,
        ApiUpdateAnthropicApikeyInputPublic $body,
    ): ApiUpdateAnthropicApikeyOutput {
        $path = '/v2/gen-ai/anthropic/keys/{api_key_uuid}';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateAnthropicApikeyOutput::class, $data);
    }

    public function genai_delete_anthropic_api_key(string $api_key_uuid): ApiDeleteAnthropicApikeyOutput
    {
        $path = '/v2/gen-ai/anthropic/keys/{api_key_uuid}';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteAnthropicApikeyOutput::class, $data);
    }

    public function genai_list_agents_by_anthropic_key(
        string $uuid,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListAgentsByAnthropicKeyOutput {
        $path = '/v2/gen-ai/anthropic/keys/{uuid}/agents';
        $path = \str_replace('{uuid}', $uuid, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListAgentsByAnthropicKeyOutput::class, $data);
    }

    public function genai_create_evaluation_dataset(
        ApiCreateEvaluationDatasetInputPublic $body,
    ): ApiCreateEvaluationDatasetOutput {
        $path = '/v2/gen-ai/evaluation_datasets';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateEvaluationDatasetOutput::class, $data);
    }

    public function genai_create_evaluation_dataset_file_upload_presigned_urls(
        ApiCreateDataSourceFileUploadPresignedUrlsInputPublic $body,
    ): ApiCreateDataSourceFileUploadPresignedUrlsOutput {
        $path = '/v2/gen-ai/evaluation_datasets/file_upload_presigned_urls';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateDataSourceFileUploadPresignedUrlsOutput::class, $data);
    }

    public function genai_list_evaluation_metrics(): ApiListEvaluationMetricsOutput
    {
        $path = '/v2/gen-ai/evaluation_metrics';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListEvaluationMetricsOutput::class, $data);
    }

    public function genai_run_evaluation_test_case(
        ApiRunEvaluationTestCaseInputPublic $body,
    ): ApiRunEvaluationTestCaseOutput {
        $path = '/v2/gen-ai/evaluation_runs';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiRunEvaluationTestCaseOutput::class, $data);
    }

    public function genai_get_evaluation_run(string $evaluation_run_uuid): ApiGetEvaluationRunOutput
    {
        $path = '/v2/gen-ai/evaluation_runs/{evaluation_run_uuid}';
        $path = \str_replace('{evaluation_run_uuid}', $evaluation_run_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetEvaluationRunOutput::class, $data);
    }

    public function genai_get_evaluation_run_results(
        string $evaluation_run_uuid,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiGetEvaluationRunResultsOutput {
        $path = '/v2/gen-ai/evaluation_runs/{evaluation_run_uuid}/results';
        $path = \str_replace('{evaluation_run_uuid}', $evaluation_run_uuid, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetEvaluationRunResultsOutput::class, $data);
    }

    public function genai_get_evaluation_run_prompt_results(
        string $evaluation_run_uuid,
        int $prompt_id,
    ): ApiGetEvaluationRunPromptResultsOutput {
        $path = '/v2/gen-ai/evaluation_runs/{evaluation_run_uuid}/results/{prompt_id}';
        $path = \str_replace('{evaluation_run_uuid}', $evaluation_run_uuid, $path);
        $path = \str_replace('{prompt_id}', (string) $prompt_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetEvaluationRunPromptResultsOutput::class, $data);
    }

    public function genai_list_evaluation_test_cases(): ApiListEvaluationTestCasesOutput
    {
        $path = '/v2/gen-ai/evaluation_test_cases';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListEvaluationTestCasesOutput::class, $data);
    }

    public function genai_create_evaluation_test_case(
        ApiCreateEvaluationTestCaseInputPublic $body,
    ): ApiCreateEvaluationTestCaseOutput {
        $path = '/v2/gen-ai/evaluation_test_cases';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateEvaluationTestCaseOutput::class, $data);
    }

    public function genai_list_evaluation_runs_by_test_case(
        string $evaluation_test_case_uuid,
        ?int $evaluation_test_case_version = null,
    ): ApiListEvaluationRunsByTestCaseOutput {
        $path = '/v2/gen-ai/evaluation_test_cases/{evaluation_test_case_uuid}/evaluation_runs';
        $path = \str_replace('{evaluation_test_case_uuid}', $evaluation_test_case_uuid, $path);
        $query = [];
        if ($evaluation_test_case_version !== null) {
            $query[] = 'evaluation_test_case_version=' . \urlencode((string) $evaluation_test_case_version);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListEvaluationRunsByTestCaseOutput::class, $data);
    }

    public function genai_get_evaluation_test_case(
        string $test_case_uuid,
        ?int $evaluation_test_case_version = null,
    ): ApiGetEvaluationTestCaseOutput {
        $path = '/v2/gen-ai/evaluation_test_cases/{test_case_uuid}';
        $path = \str_replace('{test_case_uuid}', $test_case_uuid, $path);
        $query = [];
        if ($evaluation_test_case_version !== null) {
            $query[] = 'evaluation_test_case_version=' . \urlencode((string) $evaluation_test_case_version);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetEvaluationTestCaseOutput::class, $data);
    }

    public function genai_update_evaluation_test_case(
        string $test_case_uuid,
        ApiUpdateEvaluationTestCaseInputPublic $body,
    ): ApiUpdateEvaluationTestCaseOutput {
        $path = '/v2/gen-ai/evaluation_test_cases/{test_case_uuid}';
        $path = \str_replace('{test_case_uuid}', $test_case_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateEvaluationTestCaseOutput::class, $data);
    }

    public function genai_list_indexing_jobs(
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListKnowledgeBaseIndexingJobsOutput {
        $path = '/v2/gen-ai/indexing_jobs';
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListKnowledgeBaseIndexingJobsOutput::class, $data);
    }

    public function genai_create_indexing_job(
        ApiStartKnowledgeBaseIndexingJobInputPublic $body,
    ): ApiStartKnowledgeBaseIndexingJobOutput {
        $path = '/v2/gen-ai/indexing_jobs';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiStartKnowledgeBaseIndexingJobOutput::class, $data);
    }

    public function genai_list_indexing_job_data_sources(
        string $indexing_job_uuid,
    ): ApiListIndexingJobDataSourcesOutput {
        $path = '/v2/gen-ai/indexing_jobs/{indexing_job_uuid}/data_sources';
        $path = \str_replace('{indexing_job_uuid}', $indexing_job_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListIndexingJobDataSourcesOutput::class, $data);
    }

    public function genai_get_indexing_job_details_signed_url(
        string $indexing_job_uuid,
    ): ApiGetIndexingJobDetailsSignedUrloutput {
        $path = '/v2/gen-ai/indexing_jobs/{indexing_job_uuid}/details_signed_url';
        $path = \str_replace('{indexing_job_uuid}', $indexing_job_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetIndexingJobDetailsSignedUrloutput::class, $data);
    }

    public function genai_get_indexing_job(string $uuid): ApiGetKnowledgeBaseIndexingJobOutput
    {
        $path = '/v2/gen-ai/indexing_jobs/{uuid}';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetKnowledgeBaseIndexingJobOutput::class, $data);
    }

    public function genai_cancel_indexing_job(
        string $uuid,
        ApiCancelKnowledgeBaseIndexingJobInputPublic $body,
    ): ApiCancelKnowledgeBaseIndexingJobOutput {
        $path = '/v2/gen-ai/indexing_jobs/{uuid}/cancel';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCancelKnowledgeBaseIndexingJobOutput::class, $data);
    }

    public function genai_list_knowledge_bases(?int $page = null, ?int $per_page = null): ApiListKnowledgeBasesOutput
    {
        $path = '/v2/gen-ai/knowledge_bases';
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListKnowledgeBasesOutput::class, $data);
    }

    public function genai_create_knowledge_base(ApiCreateKnowledgeBaseInputPublic $body): ApiCreateKnowledgeBaseOutput
    {
        $path = '/v2/gen-ai/knowledge_bases';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateKnowledgeBaseOutput::class, $data);
    }

    public function genai_create_data_source_file_upload_presigned_urls(
        ApiCreateDataSourceFileUploadPresignedUrlsInputPublic $body,
    ): ApiCreateDataSourceFileUploadPresignedUrlsOutput {
        $path = '/v2/gen-ai/knowledge_bases/data_sources/file_upload_presigned_urls';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateDataSourceFileUploadPresignedUrlsOutput::class, $data);
    }

    public function genai_list_knowledge_base_data_sources(
        string $knowledge_base_uuid,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListKnowledgeBaseDataSourcesOutput {
        $path = '/v2/gen-ai/knowledge_bases/{knowledge_base_uuid}/data_sources';
        $path = \str_replace('{knowledge_base_uuid}', $knowledge_base_uuid, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListKnowledgeBaseDataSourcesOutput::class, $data);
    }

    public function genai_create_knowledge_base_data_source(
        string $knowledge_base_uuid,
        ApiCreateKnowledgeBaseDataSourceInputPublic $body,
    ): ApiCreateKnowledgeBaseDataSourceOutput {
        $path = '/v2/gen-ai/knowledge_bases/{knowledge_base_uuid}/data_sources';
        $path = \str_replace('{knowledge_base_uuid}', $knowledge_base_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateKnowledgeBaseDataSourceOutput::class, $data);
    }

    public function genai_update_knowledge_base_data_source(
        string $knowledge_base_uuid,
        string $data_source_uuid,
        ApiUpdateKnowledgeBaseDataSourceInputPublic $body,
    ): ApiUpdateKnowledgeBaseDataSourceOutput {
        $path = '/v2/gen-ai/knowledge_bases/{knowledge_base_uuid}/data_sources/{data_source_uuid}';
        $path = \str_replace('{knowledge_base_uuid}', $knowledge_base_uuid, $path);
        $path = \str_replace('{data_source_uuid}', $data_source_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateKnowledgeBaseDataSourceOutput::class, $data);
    }

    public function genai_delete_knowledge_base_data_source(
        string $knowledge_base_uuid,
        string $data_source_uuid,
    ): ApiDeleteKnowledgeBaseDataSourceOutput {
        $path = '/v2/gen-ai/knowledge_bases/{knowledge_base_uuid}/data_sources/{data_source_uuid}';
        $path = \str_replace('{knowledge_base_uuid}', $knowledge_base_uuid, $path);
        $path = \str_replace('{data_source_uuid}', $data_source_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteKnowledgeBaseDataSourceOutput::class, $data);
    }

    public function genai_list_indexing_jobs_by_knowledge_base(
        string $knowledge_base_uuid,
    ): ApiListKnowledgeBaseIndexingJobsOutput {
        $path = '/v2/gen-ai/knowledge_bases/{knowledge_base_uuid}/indexing_jobs';
        $path = \str_replace('{knowledge_base_uuid}', $knowledge_base_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListKnowledgeBaseIndexingJobsOutput::class, $data);
    }

    public function genai_get_knowledge_base(string $uuid): ApiGetKnowledgeBaseOutput
    {
        $path = '/v2/gen-ai/knowledge_bases/{uuid}';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetKnowledgeBaseOutput::class, $data);
    }

    public function genai_update_knowledge_base(
        string $uuid,
        ApiUpdateKnowledgeBaseInputPublic $body,
    ): ApiUpdateKnowledgeBaseOutput {
        $path = '/v2/gen-ai/knowledge_bases/{uuid}';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateKnowledgeBaseOutput::class, $data);
    }

    public function genai_delete_knowledge_base(string $uuid): ApiDeleteKnowledgeBaseOutput
    {
        $path = '/v2/gen-ai/knowledge_bases/{uuid}';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteKnowledgeBaseOutput::class, $data);
    }

    /**
     * @param list<string> $usecases
     */
    public function genai_list_models(
        ?array $usecases = null,
        ?bool $public_only = null,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListModelsOutputPublic {
        $path = '/v2/gen-ai/models';
        $query = [];
        if ($usecases !== null) { foreach ($usecases as $__v) { $query[] = 'usecases=' . \urlencode($__v->value); } }
        if ($public_only !== null) {
            $query[] = 'public_only=' . \urlencode((string) $public_only);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListModelsOutputPublic::class, $data);
    }

    public function genai_list_model_api_keys(?int $page = null, ?int $per_page = null): ApiListModelApikeysOutput
    {
        $path = '/v2/gen-ai/models/api_keys';
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListModelApikeysOutput::class, $data);
    }

    public function genai_create_model_api_key(ApiCreateModelApikeyInputPublic $body): ApiCreateModelApikeyOutput
    {
        $path = '/v2/gen-ai/models/api_keys';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateModelApikeyOutput::class, $data);
    }

    public function genai_update_model_api_key(
        string $api_key_uuid,
        ApiUpdateModelApikeyInputPublic $body,
    ): ApiUpdateModelApikeyOutput {
        $path = '/v2/gen-ai/models/api_keys/{api_key_uuid}';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateModelApikeyOutput::class, $data);
    }

    public function genai_delete_model_api_key(string $api_key_uuid): ApiDeleteModelApikeyOutput
    {
        $path = '/v2/gen-ai/models/api_keys/{api_key_uuid}';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteModelApikeyOutput::class, $data);
    }

    public function genai_regenerate_model_api_key(string $api_key_uuid): ApiRegenerateModelApikeyOutput
    {
        $path = '/v2/gen-ai/models/api_keys/{api_key_uuid}/regenerate';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiRegenerateModelApikeyOutput::class, $data);
    }

    public function genai_create_oauth2_dropbox_tokens(
        ApiDropboxOauth2GetTokensInput $body,
    ): ApiDropboxOauth2GetTokensOutput {
        $path = '/v2/gen-ai/oauth2/dropbox/tokens';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDropboxOauth2GetTokensOutput::class, $data);
    }

    public function genai_get_oauth2_url(
        ?string $type = null,
        ?string $redirect_url = null,
    ): ApiGenerateOauth2Urloutput {
        $path = '/v2/gen-ai/oauth2/url';
        $query = [];
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type);
        }
        if ($redirect_url !== null) {
            $query[] = 'redirect_url=' . \urlencode($redirect_url);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGenerateOauth2Urloutput::class, $data);
    }

    public function genai_list_openai_api_keys(?int $page = null, ?int $per_page = null): ApiListOpenAiapikeysOutput
    {
        $path = '/v2/gen-ai/openai/keys';
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListOpenAiapikeysOutput::class, $data);
    }

    public function genai_create_openai_api_key(ApiCreateOpenAiapikeyInputPublic $body): ApiCreateOpenAiapikeyOutput
    {
        $path = '/v2/gen-ai/openai/keys';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateOpenAiapikeyOutput::class, $data);
    }

    public function genai_get_openai_api_key(string $api_key_uuid): ApiGetOpenAiapikeyOutput
    {
        $path = '/v2/gen-ai/openai/keys/{api_key_uuid}';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetOpenAiapikeyOutput::class, $data);
    }

    public function genai_update_openai_api_key(
        string $api_key_uuid,
        ApiUpdateOpenAiapikeyInputPublic $body,
    ): ApiUpdateOpenAiapikeyOutput {
        $path = '/v2/gen-ai/openai/keys/{api_key_uuid}';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateOpenAiapikeyOutput::class, $data);
    }

    public function genai_delete_openai_api_key(string $api_key_uuid): ApiDeleteOpenAiapikeyOutput
    {
        $path = '/v2/gen-ai/openai/keys/{api_key_uuid}';
        $path = \str_replace('{api_key_uuid}', $api_key_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteOpenAiapikeyOutput::class, $data);
    }

    public function genai_list_agents_by_openai_key(
        string $uuid,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListAgentsByOpenAikeyOutput {
        $path = '/v2/gen-ai/openai/keys/{uuid}/agents';
        $path = \str_replace('{uuid}', $uuid, $path);
        $query = [];
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListAgentsByOpenAikeyOutput::class, $data);
    }

    public function genai_list_datacenter_regions(
        ?bool $serves_inference = null,
        ?bool $serves_batch = null,
    ): ApiListRegionsOutput {
        $path = '/v2/gen-ai/regions';
        $query = [];
        if ($serves_inference !== null) {
            $query[] = 'serves_inference=' . \urlencode((string) $serves_inference);
        }
        if ($serves_batch !== null) {
            $query[] = 'serves_batch=' . \urlencode((string) $serves_batch);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListRegionsOutput::class, $data);
    }

    public function genai_create_scheduled_indexing(
        ApiCreateScheduledIndexingInputPublic $body,
    ): ApiCreateScheduledIndexingOutput {
        $path = '/v2/gen-ai/scheduled-indexing';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateScheduledIndexingOutput::class, $data);
    }

    public function genai_get_scheduled_indexing(string $knowledge_base_uuid): ApiGetScheduledIndexingOutput
    {
        $path = '/v2/gen-ai/scheduled-indexing/knowledge-base/{knowledge_base_uuid}';
        $path = \str_replace('{knowledge_base_uuid}', $knowledge_base_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetScheduledIndexingOutput::class, $data);
    }

    public function genai_delete_scheduled_indexing(string $uuid): ApiDeleteScheduledIndexingOutput
    {
        $path = '/v2/gen-ai/scheduled-indexing/{uuid}';
        $path = \str_replace('{uuid}', $uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteScheduledIndexingOutput::class, $data);
    }

    public function genai_list_workspaces(): ApiListWorkspacesOutput
    {
        $path = '/v2/gen-ai/workspaces';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListWorkspacesOutput::class, $data);
    }

    public function genai_create_workspace(ApiCreateWorkspaceInputPublic $body): ApiCreateWorkspaceOutput
    {
        $path = '/v2/gen-ai/workspaces';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiCreateWorkspaceOutput::class, $data);
    }

    public function genai_get_workspace(string $workspace_uuid): ApiGetWorkspaceOutput
    {
        $path = '/v2/gen-ai/workspaces/{workspace_uuid}';
        $path = \str_replace('{workspace_uuid}', $workspace_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiGetWorkspaceOutput::class, $data);
    }

    public function genai_update_workspace(
        string $workspace_uuid,
        ApiUpdateWorkspaceInputPublic $body,
    ): ApiUpdateWorkspaceOutput {
        $path = '/v2/gen-ai/workspaces/{workspace_uuid}';
        $path = \str_replace('{workspace_uuid}', $workspace_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiUpdateWorkspaceOutput::class, $data);
    }

    public function genai_delete_workspace(string $workspace_uuid): ApiDeleteWorkspaceOutput
    {
        $path = '/v2/gen-ai/workspaces/{workspace_uuid}';
        $path = \str_replace('{workspace_uuid}', $workspace_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiDeleteWorkspaceOutput::class, $data);
    }

    public function genai_list_agents_by_workspace(
        string $workspace_uuid,
        ?bool $only_deployed = null,
        ?int $page = null,
        ?int $per_page = null,
    ): ApiListAgentsByWorkspaceOutput {
        $path = '/v2/gen-ai/workspaces/{workspace_uuid}/agents';
        $path = \str_replace('{workspace_uuid}', $workspace_uuid, $path);
        $query = [];
        if ($only_deployed !== null) {
            $query[] = 'only_deployed=' . \urlencode((string) $only_deployed);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListAgentsByWorkspaceOutput::class, $data);
    }

    public function genai_update_agents_workspace(
        string $workspace_uuid,
        ApiMoveAgentsToWorkspaceInputPublic $body,
    ): ApiMoveAgentsToWorkspaceOutput {
        $path = '/v2/gen-ai/workspaces/{workspace_uuid}/agents';
        $path = \str_replace('{workspace_uuid}', $workspace_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiMoveAgentsToWorkspaceOutput::class, $data);
    }

    public function genai_list_evaluation_test_cases_by_workspace(
        string $workspace_uuid,
    ): ApiListEvaluationTestCasesByWorkspaceOutput {
        $path = '/v2/gen-ai/workspaces/{workspace_uuid}/evaluation_test_cases';
        $path = \str_replace('{workspace_uuid}', $workspace_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(ApiListEvaluationTestCasesByWorkspaceOutput::class, $data);
    }

    public function images_list(
        ?ImagesListType $type = null,
        ?bool $private = null,
        ?string $tag_name = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/images';
        $query = [];
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type->value);
        }
        if ($private !== null) {
            $query[] = 'private=' . \urlencode((string) $private);
        }
        if ($tag_name !== null) {
            $query[] = 'tag_name=' . \urlencode($tag_name);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function images_create_custom(ImageNewCustom $body): void
    {
        $path = '/v2/images';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function images_get($image_id): void
    {
        $path = '/v2/images/{image_id}';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function images_update(int $image_id, ImageUpdate $body): void
    {
        $path = '/v2/images/{image_id}';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function images_delete(int $image_id): void
    {
        $path = '/v2/images/{image_id}';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function images_post_account_transfer_create(int $image_id, ImagesPostAccountTransferCreate $body): void
    {
        $path = '/v2/images/{image_id}/account_transfer';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function images_post_account_transfer_accept(int $image_id, ImagesPostAccountTransferAccept $body): void
    {
        $path = '/v2/images/{image_id}/account_transfer/accept';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function images_post_account_transfer_cancel(int $image_id, ImagesPostAccountTransferCancel $body): void
    {
        $path = '/v2/images/{image_id}/account_transfer/cancel';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function images_post_account_transfer_decline(int $image_id, ImagesPostAccountTransferDecline $body): void
    {
        $path = '/v2/images/{image_id}/account_transfer/decline';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function imageActions_list(int $image_id): void
    {
        $path = '/v2/images/{image_id}/actions';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function imageActions_get(int $image_id, int $action_id): void
    {
        $path = '/v2/images/{image_id}/actions/{action_id}';
        $path = \str_replace('{image_id}', (string) $image_id, $path);
        $path = \str_replace('{action_id}', (string) $action_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_list_clusters(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/kubernetes/clusters';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_create_cluster(Cluster $body): void
    {
        $path = '/v2/kubernetes/clusters';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_get_cluster(string $cluster_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_update_cluster(string $cluster_id, ClusterUpdate $body): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_delete_cluster(string $cluster_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_get_clusterLintResults(string $cluster_id, ?string $run_id = null): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/clusterlint';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $query = [];
        if ($run_id !== null) {
            $query[] = 'run_id=' . \urlencode($run_id);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_run_clusterLint(string $cluster_id, ClusterlintRequest $body): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/clusterlint';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_get_credentials(string $cluster_id, ?int $expiry_seconds = null): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/credentials';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $query = [];
        if ($expiry_seconds !== null) {
            $query[] = 'expiry_seconds=' . \urlencode((string) $expiry_seconds);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_list_associatedResources(string $cluster_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/destroy_with_associated_resources';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_destroy_associatedResourcesDangerous(string $cluster_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/destroy_with_associated_resources/dangerous';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_destroy_associatedResourcesSelective(
        string $cluster_id,
        DestroyAssociatedKubernetesResources $body,
    ): void {
        $path = '/v2/kubernetes/clusters/{cluster_id}/destroy_with_associated_resources/selective';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_get_kubeconfig(string $cluster_id, ?int $expiry_seconds = null): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/kubeconfig';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $query = [];
        if ($expiry_seconds !== null) {
            $query[] = 'expiry_seconds=' . \urlencode((string) $expiry_seconds);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_list_nodePools(string $cluster_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/node_pools';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_add_nodePool(string $cluster_id, KubernetesNodePool $body): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/node_pools';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_get_nodePool(string $cluster_id, string $node_pool_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/node_pools/{node_pool_id}';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $path = \str_replace('{node_pool_id}', $node_pool_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_update_nodePool(
        string $cluster_id,
        string $node_pool_id,
        KubernetesNodePoolUpdate $body,
    ): void {
        $path = '/v2/kubernetes/clusters/{cluster_id}/node_pools/{node_pool_id}';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $path = \str_replace('{node_pool_id}', $node_pool_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_delete_nodePool(string $cluster_id, string $node_pool_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/node_pools/{node_pool_id}';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $path = \str_replace('{node_pool_id}', $node_pool_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_delete_node(
        string $cluster_id,
        string $node_pool_id,
        string $node_id,
        ?int $skip_drain = null,
        ?int $replace = null,
    ): void {
        $path = '/v2/kubernetes/clusters/{cluster_id}/node_pools/{node_pool_id}/nodes/{node_id}';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $path = \str_replace('{node_pool_id}', $node_pool_id, $path);
        $path = \str_replace('{node_id}', $node_id, $path);
        $query = [];
        if ($skip_drain !== null) {
            $query[] = 'skip_drain=' . \urlencode((string) $skip_drain);
        }
        if ($replace !== null) {
            $query[] = 'replace=' . \urlencode((string) $replace);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_get_status_messages(string $cluster_id, ?\DateTimeImmutable $since = null): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/status_messages';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $query = [];
        if ($since !== null) {
            $query[] = 'since=' . \urlencode($since->format(\DateTimeInterface::RFC3339));
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_get_availableUpgrades(string $cluster_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/upgrades';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_get_clusterUser(string $cluster_id): void
    {
        $path = '/v2/kubernetes/clusters/{cluster_id}/user';
        $path = \str_replace('{cluster_id}', $cluster_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_list_options(): void
    {
        $path = '/v2/kubernetes/options';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_add_registries(ClusterRegistries $body): void
    {
        $path = '/v2/kubernetes/registries';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_remove_registries(ClusterRegistries $body): void
    {
        $path = '/v2/kubernetes/registries';
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_add_registry(ClusterRegistry $body): void
    {
        $path = '/v2/kubernetes/registry';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function kubernetes_remove_registry(ClusterRegistry $body): void
    {
        $path = '/v2/kubernetes/registry';
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function loadBalancers_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/load_balancers';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function loadBalancers_create(LoadBalancerCreate $body): void
    {
        $path = '/v2/load_balancers';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function loadBalancers_get(string $lb_id): void
    {
        $path = '/v2/load_balancers/{lb_id}';
        $path = \str_replace('{lb_id}', $lb_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function loadBalancers_update(string $lb_id, LoadBalancerCreate $body): void
    {
        $path = '/v2/load_balancers/{lb_id}';
        $path = \str_replace('{lb_id}', $lb_id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function loadBalancers_delete(string $lb_id): void
    {
        $path = '/v2/load_balancers/{lb_id}';
        $path = \str_replace('{lb_id}', $lb_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function loadBalancers_delete_cache(string $lb_id): void
    {
        $path = '/v2/load_balancers/{lb_id}/cache';
        $path = \str_replace('{lb_id}', $lb_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_list_alertPolicy(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/monitoring/alerts';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_create_alertPolicy(AlertPolicyRequest $body): void
    {
        $path = '/v2/monitoring/alerts';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_alertPolicy(string $alert_uuid): void
    {
        $path = '/v2/monitoring/alerts/{alert_uuid}';
        $path = \str_replace('{alert_uuid}', $alert_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_update_alertPolicy(string $alert_uuid, AlertPolicyRequest $body): void
    {
        $path = '/v2/monitoring/alerts/{alert_uuid}';
        $path = \str_replace('{alert_uuid}', $alert_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_delete_alertPolicy(string $alert_uuid): void
    {
        $path = '/v2/monitoring/alerts/{alert_uuid}';
        $path = \str_replace('{alert_uuid}', $alert_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_appCPUPercentageMetrics(
        string $app_id,
        string $start,
        string $end,
        ?string $app_component = null,
    ): void {
        $path = '/v2/monitoring/metrics/apps/cpu_percentage';
        $query = [];
        $query[] = 'app_id=' . \urlencode($app_id);
        if ($app_component !== null) {
            $query[] = 'app_component=' . \urlencode($app_component);
        }
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_appMemoryPercentageMetrics(
        string $app_id,
        string $start,
        string $end,
        ?string $app_component = null,
    ): void {
        $path = '/v2/monitoring/metrics/apps/memory_percentage';
        $query = [];
        $query[] = 'app_id=' . \urlencode($app_id);
        if ($app_component !== null) {
            $query[] = 'app_component=' . \urlencode($app_component);
        }
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_cpu_usage(
        string $db_id,
        MonitoringGetDatabaseMysqlCpuUsageAggregate $aggregate,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/cpu_usage';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'aggregate=' . \urlencode($aggregate->value);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_disk_usage(
        string $db_id,
        MonitoringGetDatabaseMysqlDiskUsageAggregate $aggregate,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/disk_usage';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'aggregate=' . \urlencode($aggregate->value);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_index_vs_sequential_reads(
        string $db_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/index_vs_sequential_reads';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_load(
        string $db_id,
        MonitoringGetDatabaseMysqlLoadMetric $metric,
        MonitoringGetDatabaseMysqlLoadAggregate $aggregate,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/load';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'metric=' . \urlencode($metric->value);
        $query[] = 'aggregate=' . \urlencode($aggregate->value);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_memory_usage(
        string $db_id,
        MonitoringGetDatabaseMysqlMemoryUsageAggregate $aggregate,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/memory_usage';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'aggregate=' . \urlencode($aggregate->value);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_op_rates(
        string $db_id,
        MonitoringGetDatabaseMysqlOpRatesMetric $metric,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/op_rates';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'metric=' . \urlencode($metric->value);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_schema_latency(
        string $db_id,
        string $schema,
        MonitoringGetDatabaseMysqlSchemaLatencyMetric $metric,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/schema_latency';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'schema=' . \urlencode($schema);
        $query[] = 'metric=' . \urlencode($metric->value);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_schema_throughput(
        string $db_id,
        string $schema,
        MonitoringGetDatabaseMysqlSchemaThroughputMetric $metric,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/schema_throughput';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'schema=' . \urlencode($schema);
        $query[] = 'metric=' . \urlencode($metric->value);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_threads_active(string $db_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/database/mysql/threads_active';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_threads_connected(string $db_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/database/mysql/threads_connected';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_database_mysql_threads_created_rate(
        string $db_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/database/mysql/threads_created_rate';
        $query = [];
        $query[] = 'db_id=' . \urlencode($db_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletBandwidthMetrics(
        string $host_id,
        MonitoringGetDropletBandwidthMetricsInterface $interface,
        MonitoringGetDropletBandwidthMetricsDirection $direction,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/droplet/bandwidth';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'interface=' . \urlencode($interface->value);
        $query[] = 'direction=' . \urlencode($direction->value);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_DropletCpuMetrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/cpu';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletFilesystemFreeMetrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/filesystem_free';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletFilesystemSizeMetrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/filesystem_size';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletLoad1Metrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/load_1';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletLoad15Metrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/load_15';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletLoad5Metrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/load_5';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletMemoryAvailableMetrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/memory_available';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletMemoryCachedMetrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/memory_cached';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletMemoryFreeMetrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/memory_free';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_dropletMemoryTotalMetrics(string $host_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/droplet/memory_total';
        $query = [];
        $query[] = 'host_id=' . \urlencode($host_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_droplet_autoscale_current_instances(
        string $autoscale_pool_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/droplet_autoscale/current_instances';
        $query = [];
        $query[] = 'autoscale_pool_id=' . \urlencode($autoscale_pool_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_droplet_autoscale_current_memory_utilization(
        string $autoscale_pool_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/droplet_autoscale/current_memory_utilization';
        $query = [];
        $query[] = 'autoscale_pool_id=' . \urlencode($autoscale_pool_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_droplet_autoscale_target_cpu_utilization(
        string $autoscale_pool_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/droplet_autoscale/target_cpu_utilization';
        $query = [];
        $query[] = 'autoscale_pool_id=' . \urlencode($autoscale_pool_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_droplet_autoscale_target_instances(
        string $autoscale_pool_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/droplet_autoscale/target_instances';
        $query = [];
        $query[] = 'autoscale_pool_id=' . \urlencode($autoscale_pool_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_droplet_autoscale_target_memory_utilization(
        string $autoscale_pool_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/droplet_autoscale/target_memory_utilization';
        $query = [];
        $query[] = 'autoscale_pool_id=' . \urlencode($autoscale_pool_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_connections(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_connections';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_downtime(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_downtime';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_health_checks(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_health_checks';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_http_response_time_50p(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_http_response_time_50p';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_http_response_time_95p(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_http_response_time_95p';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_http_response_time_99p(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_http_response_time_99p';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_http_response_time_avg(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_http_response_time_avg';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_http_responses(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_http_responses';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_http_session_duration_50p(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_http_session_duration_50p';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_http_session_duration_95p(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_http_session_duration_95p';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_http_session_duration_avg(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_http_session_duration_avg';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_droplets_queue_size(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/droplets_queue_size';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_connections_current(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_connections_current';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_connections_limit(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_connections_limit';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_cpu_utilization(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_cpu_utilization';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_firewall_dropped_bytes(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_firewall_dropped_bytes';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_firewall_dropped_packets(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_firewall_dropped_packets';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_http_requests_per_second(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_http_requests_per_second';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_http_responses(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_http_responses';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_network_throughput_http(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_network_throughput_http';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_network_throughput_tcp(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_network_throughput_tcp';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_network_throughput_udp(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_network_throughput_udp';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_nlb_tcp_network_throughput(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_nlb_tcp_network_throughput';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_nlb_udp_network_throughput(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_nlb_udp_network_throughput';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_tls_connections_current(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_tls_connections_current';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_tls_connections_exceeding_rate_limit(
        string $lb_id,
        string $start,
        string $end,
    ): void {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_tls_connections_exceeding_rate_limit';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_lb_frontend_tls_connections_limit(string $lb_id, string $start, string $end): void
    {
        $path = '/v2/monitoring/metrics/load_balancer/frontend_tls_connections_limit';
        $query = [];
        $query[] = 'lb_id=' . \urlencode($lb_id);
        $query[] = 'start=' . \urlencode($start);
        $query[] = 'end=' . \urlencode($end);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_list_destinations(): void
    {
        $path = '/v2/monitoring/sinks/destinations';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_create_destination(DestinationRequest $body): void
    {
        $path = '/v2/monitoring/sinks/destinations';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_destination(string $destination_uuid): void
    {
        $path = '/v2/monitoring/sinks/destinations/{destination_uuid}';
        $path = \str_replace('{destination_uuid}', $destination_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_update_destination(string $destination_uuid, DestinationRequest $body): void
    {
        $path = '/v2/monitoring/sinks/destinations/{destination_uuid}';
        $path = \str_replace('{destination_uuid}', $destination_uuid, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_delete_destination(string $destination_uuid): void
    {
        $path = '/v2/monitoring/sinks/destinations/{destination_uuid}';
        $path = \str_replace('{destination_uuid}', $destination_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_get_sink(string $sink_uuid): void
    {
        $path = '/v2/monitoring/sinks/{sink_uuid}';
        $path = \str_replace('{sink_uuid}', $sink_uuid, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function monitoring_delete_sink(string $sink_uuid): void
    {
        $path = '/v2/monitoring/sinks/{sink_uuid}';
        $path = \str_replace('{sink_uuid}', $sink_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function nfs_list(?string $region = null): void
    {
        $path = '/v2/nfs';
        $query = [];
        if ($region !== null) {
            $query[] = 'region=' . \urlencode($region);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function nfs_create(NfsRequest $body): void
    {
        $path = '/v2/nfs';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function nfs_list_snapshot(?string $region = null, ?string $share_id = null): void
    {
        $path = '/v2/nfs/snapshots';
        $query = [];
        if ($region !== null) {
            $query[] = 'region=' . \urlencode($region);
        }
        if ($share_id !== null) {
            $query[] = 'share_id=' . \urlencode($share_id);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function nfs_get_snapshot(string $nfs_snapshot_id, ?string $region = null): void
    {
        $path = '/v2/nfs/snapshots/{nfs_snapshot_id}';
        $path = \str_replace('{nfs_snapshot_id}', $nfs_snapshot_id, $path);
        $query = [];
        if ($region !== null) {
            $query[] = 'region=' . \urlencode($region);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function nfs_delete_snapshot(string $nfs_snapshot_id, ?string $region = null): void
    {
        $path = '/v2/nfs/snapshots/{nfs_snapshot_id}';
        $path = \str_replace('{nfs_snapshot_id}', $nfs_snapshot_id, $path);
        $query = [];
        if ($region !== null) {
            $query[] = 'region=' . \urlencode($region);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function nfs_get(string $nfs_id, ?string $region = null): void
    {
        $path = '/v2/nfs/{nfs_id}';
        $path = \str_replace('{nfs_id}', $nfs_id, $path);
        $query = [];
        if ($region !== null) {
            $query[] = 'region=' . \urlencode($region);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function nfs_delete(string $nfs_id, ?string $region = null): void
    {
        $path = '/v2/nfs/{nfs_id}';
        $path = \str_replace('{nfs_id}', $nfs_id, $path);
        $query = [];
        if ($region !== null) {
            $query[] = 'region=' . \urlencode($region);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/partner_network_connect/attachments';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_create(PartnerAttachmentWritable $body): void
    {
        $path = '/v2/partner_network_connect/attachments';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_get(string $pa_id): void
    {
        $path = '/v2/partner_network_connect/attachments/{pa_id}';
        $path = \str_replace('{pa_id}', $pa_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_delete(string $pa_id): void
    {
        $path = '/v2/partner_network_connect/attachments/{pa_id}';
        $path = \str_replace('{pa_id}', $pa_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_patch(string $pa_id, PartnerAttachmentUpdatable $body): void
    {
        $path = '/v2/partner_network_connect/attachments/{pa_id}';
        $path = \str_replace('{pa_id}', $pa_id, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_get_bgp_auth_key(string $pa_id): void
    {
        $path = '/v2/partner_network_connect/attachments/{pa_id}/bgp_auth_key';
        $path = \str_replace('{pa_id}', $pa_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_list_remote_routes(
        string $pa_id,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/partner_network_connect/attachments/{pa_id}/remote_routes';
        $path = \str_replace('{pa_id}', $pa_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_get_service_key(string $pa_id): void
    {
        $path = '/v2/partner_network_connect/attachments/{pa_id}/service_key';
        $path = \str_replace('{pa_id}', $pa_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function partnerAttachments_create_service_key(string $pa_id): void
    {
        $path = '/v2/partner_network_connect/attachments/{pa_id}/service_key';
        $path = \str_replace('{pa_id}', $pa_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/projects';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_get_default(): void
    {
        $path = '/v2/projects/default';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_patch_default(Project $body): void
    {
        $path = '/v2/projects/default';
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_list_resources_default(): void
    {
        $path = '/v2/projects/default/resources';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_assign_resources_default(ProjectAssignment $body): void
    {
        $path = '/v2/projects/default/resources';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_get(string $project_id): void
    {
        $path = '/v2/projects/{project_id}';
        $path = \str_replace('{project_id}', $project_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_delete(string $project_id): void
    {
        $path = '/v2/projects/{project_id}';
        $path = \str_replace('{project_id}', $project_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_patch(string $project_id, Project $body): void
    {
        $path = '/v2/projects/{project_id}';
        $path = \str_replace('{project_id}', $project_id, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_list_resources(string $project_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/projects/{project_id}/resources';
        $path = \str_replace('{project_id}', $project_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function projects_assign_resources(string $project_id, ProjectAssignment $body): void
    {
        $path = '/v2/projects/{project_id}/resources';
        $path = \str_replace('{project_id}', $project_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function regions_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/regions';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_list(): void
    {
        $path = '/v2/registries';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_create(MultiregistryCreate $body): void
    {
        $path = '/v2/registries';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_get_options(): void
    {
        $path = '/v2/registries/options';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_get_subscription(): void
    {
        $path = '/v2/registries/subscription';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_validate_name(ValidateRegistry $body): void
    {
        $path = '/v2/registries/validate-name';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_get(string $registry_name): void
    {
        $path = '/v2/registries/{registry_name}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_delete(string $registry_name): void
    {
        $path = '/v2/registries/{registry_name}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_get_dockerCredentials(string $registry_name): void
    {
        $path = '/v2/registries/{registry_name}/docker-credentials';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_get_garbageCollection(string $registry_name): void
    {
        $path = '/v2/registries/{registry_name}/garbage-collection';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_run_garbageCollection(string $registry_name): void
    {
        $path = '/v2/registries/{registry_name}/garbage-collection';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_update_garbageCollection(
        string $registry_name,
        string $garbage_collection_uuid,
        UpdateRegistry $body,
    ): void {
        $path = '/v2/registries/{registry_name}/garbage-collection/{garbage_collection_uuid}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{garbage_collection_uuid}', $garbage_collection_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_list_garbageCollections(
        string $registry_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/registries/{registry_name}/garbage-collections';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_delete_repository(string $registry_name, string $repository_name): void
    {
        $path = '/v2/registries/{registry_name}/repositories/{repository_name}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_list_repositoryManifests(
        string $registry_name,
        string $repository_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/registries/{registry_name}/repositories/{repository_name}/digests';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_delete_repositoryManifest(
        string $registry_name,
        string $repository_name,
        string $manifest_digest,
    ): void {
        $path = '/v2/registries/{registry_name}/repositories/{repository_name}/digests/{manifest_digest}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $path = \str_replace('{manifest_digest}', $manifest_digest, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_list_repositoryTags(
        string $registry_name,
        string $repository_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/registries/{registry_name}/repositories/{repository_name}/tags';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_delete_repositoryTag(
        string $registry_name,
        string $repository_name,
        string $repository_tag,
    ): void {
        $path = '/v2/registries/{registry_name}/repositories/{repository_name}/tags/{repository_tag}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $path = \str_replace('{repository_tag}', $repository_tag, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registries_list_repositoriesV2(
        string $registry_name,
        ?int $per_page = null,
        ?int $page = null,
        ?string $page_token = null,
    ): void {
        $path = '/v2/registries/{registry_name}/repositoriesV2';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($page_token !== null) {
            $query[] = 'page_token=' . \urlencode($page_token);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_get(): void
    {
        $path = '/v2/registry';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_create(RegistryCreate $body): void
    {
        $path = '/v2/registry';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_delete(): void
    {
        $path = '/v2/registry';
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_get_dockerCredentials(?int $expiry_seconds = null, ?bool $read_write = null): void
    {
        $path = '/v2/registry/docker-credentials';
        $query = [];
        if ($expiry_seconds !== null) {
            $query[] = 'expiry_seconds=' . \urlencode((string) $expiry_seconds);
        }
        if ($read_write !== null) {
            $query[] = 'read_write=' . \urlencode((string) $read_write);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_get_options(): void
    {
        $path = '/v2/registry/options';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_get_subscription(): void
    {
        $path = '/v2/registry/subscription';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_validate_name(ValidateRegistry $body): void
    {
        $path = '/v2/registry/validate-name';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_get_garbageCollection(string $registry_name): void
    {
        $path = '/v2/registry/{registry_name}/garbage-collection';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_run_garbageCollection(string $registry_name, RegistryRunGc $body): void
    {
        $path = '/v2/registry/{registry_name}/garbage-collection';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_update_garbageCollection(
        string $registry_name,
        string $garbage_collection_uuid,
        UpdateRegistry $body,
    ): void {
        $path = '/v2/registry/{registry_name}/garbage-collection/{garbage_collection_uuid}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{garbage_collection_uuid}', $garbage_collection_uuid, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_list_garbageCollections(
        string $registry_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/registry/{registry_name}/garbage-collections';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_list_repositories(string $registry_name, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/registry/{registry_name}/repositories';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_list_repositoryManifests(
        string $registry_name,
        string $repository_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/registry/{registry_name}/repositories/{repository_name}/digests';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_delete_repositoryManifest(
        string $registry_name,
        string $repository_name,
        string $manifest_digest,
    ): void {
        $path = '/v2/registry/{registry_name}/repositories/{repository_name}/digests/{manifest_digest}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $path = \str_replace('{manifest_digest}', $manifest_digest, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_list_repositoryTags(
        string $registry_name,
        string $repository_name,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/registry/{registry_name}/repositories/{repository_name}/tags';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_delete_repositoryTag(
        string $registry_name,
        string $repository_name,
        string $repository_tag,
    ): void {
        $path = '/v2/registry/{registry_name}/repositories/{repository_name}/tags/{repository_tag}';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $path = \str_replace('{repository_name}', $repository_name, $path);
        $path = \str_replace('{repository_tag}', $repository_tag, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function registry_list_repositoriesV2(
        string $registry_name,
        ?int $per_page = null,
        ?int $page = null,
        ?string $page_token = null,
    ): void {
        $path = '/v2/registry/{registry_name}/repositoriesV2';
        $path = \str_replace('{registry_name}', $registry_name, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($page_token !== null) {
            $query[] = 'page_token=' . \urlencode($page_token);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function droplets_list_neighborsIds(): void
    {
        $path = '/v2/reports/droplet_neighbors_ids';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPs_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/reserved_ips';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPs_create(ReservedIpCreate $body): void
    {
        $path = '/v2/reserved_ips';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPs_get(string $reserved_ip): void
    {
        $path = '/v2/reserved_ips/{reserved_ip}';
        $path = \str_replace('{reserved_ip}', $reserved_ip, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPs_delete(string $reserved_ip): void
    {
        $path = '/v2/reserved_ips/{reserved_ip}';
        $path = \str_replace('{reserved_ip}', $reserved_ip, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPsActions_list(string $reserved_ip): void
    {
        $path = '/v2/reserved_ips/{reserved_ip}/actions';
        $path = \str_replace('{reserved_ip}', $reserved_ip, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPsActions_get(string $reserved_ip, int $action_id): void
    {
        $path = '/v2/reserved_ips/{reserved_ip}/actions/{action_id}';
        $path = \str_replace('{reserved_ip}', $reserved_ip, $path);
        $path = \str_replace('{action_id}', (string) $action_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPv6_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/reserved_ipv6';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPv6_create(ReservedIpv6Create $body): void
    {
        $path = '/v2/reserved_ipv6';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPv6_get(string $reserved_ipv6): void
    {
        $path = '/v2/reserved_ipv6/{reserved_ipv6}';
        $path = \str_replace('{reserved_ipv6}', $reserved_ipv6, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function reservedIPv6_delete(string $reserved_ipv6): void
    {
        $path = '/v2/reserved_ipv6/{reserved_ipv6}';
        $path = \str_replace('{reserved_ipv6}', $reserved_ipv6, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function security_list_scans(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/security/scans';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function security_create_scan(): void
    {
        $path = '/v2/security/scans';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function security_get_latest_scan(
        ?int $per_page = null,
        ?int $page = null,
        ?SecurityGetLatestScanSeverity $severity = null,
        ?string $type = null,
    ): void {
        $path = '/v2/security/scans/latest';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($severity !== null) {
            $query[] = 'severity=' . \urlencode($severity->value);
        }
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function security_get_scan(
        string $scan_id,
        ?SecurityGetScanSeverity $severity = null,
        ?int $per_page = null,
        ?int $page = null,
        ?string $type = null,
    ): void {
        $path = '/v2/security/scans/{scan_id}';
        $path = \str_replace('{scan_id}', $scan_id, $path);
        $query = [];
        if ($severity !== null) {
            $query[] = 'severity=' . \urlencode($severity->value);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function security_list_scan_finding_affected_resources(
        string $scan_id,
        string $finding_uuid,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/security/scans/{scan_id}/findings/{finding_uuid}/affected_resources';
        $path = \str_replace('{scan_id}', $scan_id, $path);
        $path = \str_replace('{finding_uuid}', $finding_uuid, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function security_list_settings(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/security/settings';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function security_delete_suppression(string $suppression_uuid): void
    {
        $path = '/v2/security/settings/suppressions/{suppression_uuid}';
        $path = \str_replace('{suppression_uuid}', $suppression_uuid, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function sizes_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/sizes';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function snapshots_list(
        ?int $per_page = null,
        ?int $page = null,
        ?SnapshotsListResourceType $resource_type = null,
    ): void {
        $path = '/v2/snapshots';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($resource_type !== null) {
            $query[] = 'resource_type=' . \urlencode($resource_type->value);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function snapshots_get($snapshot_id): void
    {
        $path = '/v2/snapshots/{snapshot_id}';
        $path = \str_replace('{snapshot_id}', (string) $snapshot_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function snapshots_delete($snapshot_id): void
    {
        $path = '/v2/snapshots/{snapshot_id}';
        $path = \str_replace('{snapshot_id}', (string) $snapshot_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function spacesKey_list(
        ?int $per_page = null,
        ?int $page = null,
        ?string $sort = null,
        ?string $sort_direction = null,
        ?string $name = null,
        ?string $bucket = null,
        ?string $permission = null,
    ): void {
        $path = '/v2/spaces/keys';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($sort !== null) {
            $query[] = 'sort=' . \urlencode($sort);
        }
        if ($sort_direction !== null) {
            $query[] = 'sort_direction=' . \urlencode($sort_direction);
        }
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($bucket !== null) {
            $query[] = 'bucket=' . \urlencode($bucket);
        }
        if ($permission !== null) {
            $query[] = 'permission=' . \urlencode($permission);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function spacesKey_create(Key $body): void
    {
        $path = '/v2/spaces/keys';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function spacesKey_get(string $access_key): void
    {
        $path = '/v2/spaces/keys/{access_key}';
        $path = \str_replace('{access_key}', $access_key, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function spacesKey_update(string $access_key, Key $body): void
    {
        $path = '/v2/spaces/keys/{access_key}';
        $path = \str_replace('{access_key}', $access_key, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function spacesKey_delete(string $access_key): void
    {
        $path = '/v2/spaces/keys/{access_key}';
        $path = \str_replace('{access_key}', $access_key, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function spacesKey_patch(string $access_key, Key $body): void
    {
        $path = '/v2/spaces/keys/{access_key}';
        $path = \str_replace('{access_key}', $access_key, $path);
        $request = $this->requestFactory->createRequest('PATCH', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function tags_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/tags';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function tags_create(Tags $body): void
    {
        $path = '/v2/tags';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function tags_get(string $tag_id): void
    {
        $path = '/v2/tags/{tag_id}';
        $path = \str_replace('{tag_id}', $tag_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function tags_delete(string $tag_id): void
    {
        $path = '/v2/tags/{tag_id}';
        $path = \str_replace('{tag_id}', $tag_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function tags_assign_resources(string $tag_id, TagsResource $body): void
    {
        $path = '/v2/tags/{tag_id}/resources';
        $path = \str_replace('{tag_id}', $tag_id, $path);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function tags_unassign_resources(string $tag_id, TagsResource $body): void
    {
        $path = '/v2/tags/{tag_id}/resources';
        $path = \str_replace('{tag_id}', $tag_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function uptime_list_checks(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/uptime/checks';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function uptime_get_check(string $check_id): void
    {
        $path = '/v2/uptime/checks/{check_id}';
        $path = \str_replace('{check_id}', $check_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function uptime_delete_check(string $check_id): void
    {
        $path = '/v2/uptime/checks/{check_id}';
        $path = \str_replace('{check_id}', $check_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function uptime_list_alerts(string $check_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/uptime/checks/{check_id}/alerts';
        $path = \str_replace('{check_id}', $check_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function uptime_get_alert(string $check_id, string $alert_id): void
    {
        $path = '/v2/uptime/checks/{check_id}/alerts/{alert_id}';
        $path = \str_replace('{check_id}', $check_id, $path);
        $path = \str_replace('{alert_id}', $alert_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function uptime_delete_alert(string $check_id, string $alert_id): void
    {
        $path = '/v2/uptime/checks/{check_id}/alerts/{alert_id}';
        $path = \str_replace('{check_id}', $check_id, $path);
        $path = \str_replace('{alert_id}', $alert_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function uptime_get_checkState(string $check_id): void
    {
        $path = '/v2/uptime/checks/{check_id}/state';
        $path = \str_replace('{check_id}', $check_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function volumeSnapshots_get_byId(string $snapshot_id): void
    {
        $path = '/v2/volumes/snapshots/{snapshot_id}';
        $path = \str_replace('{snapshot_id}', $snapshot_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function volumeSnapshots_delete_byId(string $snapshot_id): void
    {
        $path = '/v2/volumes/snapshots/{snapshot_id}';
        $path = \str_replace('{snapshot_id}', $snapshot_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function volumes_get(string $volume_id): void
    {
        $path = '/v2/volumes/{volume_id}';
        $path = \str_replace('{volume_id}', $volume_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function volumes_delete(string $volume_id): void
    {
        $path = '/v2/volumes/{volume_id}';
        $path = \str_replace('{volume_id}', $volume_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function volumeActions_list(string $volume_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/volumes/{volume_id}/actions';
        $path = \str_replace('{volume_id}', $volume_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function volumeActions_get(
        string $volume_id,
        int $action_id,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/volumes/{volume_id}/actions/{action_id}';
        $path = \str_replace('{volume_id}', $volume_id, $path);
        $path = \str_replace('{action_id}', (string) $action_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function volumeSnapshots_list(string $volume_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/volumes/{volume_id}/snapshots';
        $path = \str_replace('{volume_id}', $volume_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcnatgateways_list(
        ?int $per_page = null,
        ?int $page = null,
        ?VpcnatgatewaysListState $state = null,
        ?VpcnatgatewaysListRegion $region = null,
        ?VpcnatgatewaysListType $type = null,
        ?string $name = null,
    ): void {
        $path = '/v2/vpc_nat_gateways';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($state !== null) {
            $query[] = 'state=' . \urlencode($state->value);
        }
        if ($region !== null) {
            $query[] = 'region=' . \urlencode($region->value);
        }
        if ($type !== null) {
            $query[] = 'type=' . \urlencode($type->value);
        }
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcnatgateways_create(VpcNatGatewayCreate $body): void
    {
        $path = '/v2/vpc_nat_gateways';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcnatgateways_get(string $id): void
    {
        $path = '/v2/vpc_nat_gateways/{id}';
        $path = \str_replace('{id}', $id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcnatgateways_update(string $id, VpcNatGatewayUpdate $body): void
    {
        $path = '/v2/vpc_nat_gateways/{id}';
        $path = \str_replace('{id}', $id, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcnatgateways_delete(string $id): void
    {
        $path = '/v2/vpc_nat_gateways/{id}';
        $path = \str_replace('{id}', $id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcPeerings_get(string $vpc_peering_id): void
    {
        $path = '/v2/vpc_peerings/{vpc_peering_id}';
        $path = \str_replace('{vpc_peering_id}', $vpc_peering_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcPeerings_delete(string $vpc_peering_id): void
    {
        $path = '/v2/vpc_peerings/{vpc_peering_id}';
        $path = \str_replace('{vpc_peering_id}', $vpc_peering_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcs_list(?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/vpcs';
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcs_get(string $vpc_id): void
    {
        $path = '/v2/vpcs/{vpc_id}';
        $path = \str_replace('{vpc_id}', $vpc_id, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcs_delete(string $vpc_id): void
    {
        $path = '/v2/vpcs/{vpc_id}';
        $path = \str_replace('{vpc_id}', $vpc_id, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcs_list_members(
        string $vpc_id,
        ?string $resource_type = null,
        ?int $per_page = null,
        ?int $page = null,
    ): void {
        $path = '/v2/vpcs/{vpc_id}/members';
        $path = \str_replace('{vpc_id}', $vpc_id, $path);
        $query = [];
        if ($resource_type !== null) {
            $query[] = 'resource_type=' . \urlencode($resource_type);
        }
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function vpcs_list_peerings(string $vpc_id, ?int $per_page = null, ?int $page = null): void
    {
        $path = '/v2/vpcs/{vpc_id}/peerings';
        $path = \str_replace('{vpc_id}', $vpc_id, $path);
        $query = [];
        if ($per_page !== null) {
            $query[] = 'per_page=' . \urlencode((string) $per_page);
        }
        if ($page !== null) {
            $query[] = 'page=' . \urlencode((string) $page);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }
}
