<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ClusterRead implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'node_pools' => ['node_pools', ['list', \Acme\DigitalOcean\Generated\Model\KubernetesNodePool::class]],
        'region' => ['region', null],
        'version' => ['version', null],
        'amd_gpu_device_metrics_exporter_plugin' => [
            'amd_gpu_device_metrics_exporter_plugin',
            \Acme\DigitalOcean\Generated\Model\AmdGpuDeviceMetricsExporterPlugin::class,
        ],
        'amd_gpu_device_plugin' => ['amd_gpu_device_plugin', \Acme\DigitalOcean\Generated\Model\AmdGpuDevicePlugin::class],
        'auto_upgrade' => ['auto_upgrade', null],
        'cluster_autoscaler_configuration' => [
            'cluster_autoscaler_configuration',
            \Acme\DigitalOcean\Generated\Model\ClusterAutoscalerConfiguration::class,
        ],
        'cluster_subnet' => ['cluster_subnet', null],
        'control_plane_firewall' => [
            'control_plane_firewall',
            \Acme\DigitalOcean\Generated\Model\ControlPlaneFirewall::class,
        ],
        'created_at' => ['created_at', ['datetime', null]],
        'endpoint' => ['endpoint', null],
        'ha' => ['ha', null],
        'id' => ['id', null],
        'ipv4' => ['ipv4', null],
        'maintenance_policy' => ['maintenance_policy', \Acme\DigitalOcean\Generated\Model\MaintenancePolicy::class],
        'nvidia_gpu_device_plugin' => [
            'nvidia_gpu_device_plugin',
            \Acme\DigitalOcean\Generated\Model\NvidiaGpuDevicePlugin::class,
        ],
        'rdma_shared_dev_plugin' => [
            'rdma_shared_dev_plugin',
            \Acme\DigitalOcean\Generated\Model\RdmaSharedDevPlugin::class,
        ],
        'registries' => ['registries', ['list', null]],
        'registry_enabled' => ['registry_enabled', null],
        'routing_agent' => ['routing_agent', \Acme\DigitalOcean\Generated\Model\RoutingAgent::class],
        'service_subnet' => ['service_subnet', null],
        'status' => ['status', \Acme\DigitalOcean\Generated\Model\ClusterReadStatus::class],
        'surge_upgrade' => ['surge_upgrade', null],
        'tags' => ['tags', ['list', null]],
        'updated_at' => ['updated_at', ['datetime', null]],
        'vpc_uuid' => ['vpc_uuid', null],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\KubernetesNodePool> $node_pools
     * @param ?list<string> $registries
     * @param ?list<string> $tags
     */
    public function __construct(
        public string $name,
        public array $node_pools,
        public string $region,
        public string $version,
        public ?AmdGpuDeviceMetricsExporterPlugin $amd_gpu_device_metrics_exporter_plugin = null,
        public ?AmdGpuDevicePlugin $amd_gpu_device_plugin = null,
        public ?bool $auto_upgrade = null,
        public ?ClusterAutoscalerConfiguration $cluster_autoscaler_configuration = null,
        public ?string $cluster_subnet = null,
        public ?ControlPlaneFirewall $control_plane_firewall = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $endpoint = null,
        public ?bool $ha = null,
        public ?string $id = null,
        public ?string $ipv4 = null,
        public ?MaintenancePolicy $maintenance_policy = null,
        public ?NvidiaGpuDevicePlugin $nvidia_gpu_device_plugin = null,
        public ?RdmaSharedDevPlugin $rdma_shared_dev_plugin = null,
        public ?array $registries = null,
        public ?bool $registry_enabled = null,
        public ?RoutingAgent $routing_agent = null,
        public ?string $service_subnet = null,
        public ?ClusterReadStatus $status = null,
        public ?bool $surge_upgrade = null,
        public ?array $tags = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $vpc_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'node_pools' => $this->node_pools,
            'region' => $this->region,
            'version' => $this->version,
            'amd_gpu_device_metrics_exporter_plugin' => $this->amd_gpu_device_metrics_exporter_plugin,
            'amd_gpu_device_plugin' => $this->amd_gpu_device_plugin,
            'auto_upgrade' => $this->auto_upgrade,
            'cluster_autoscaler_configuration' => $this->cluster_autoscaler_configuration,
            'cluster_subnet' => $this->cluster_subnet,
            'control_plane_firewall' => $this->control_plane_firewall,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'endpoint' => $this->endpoint,
            'ha' => $this->ha,
            'id' => $this->id,
            'ipv4' => $this->ipv4,
            'maintenance_policy' => $this->maintenance_policy,
            'nvidia_gpu_device_plugin' => $this->nvidia_gpu_device_plugin,
            'rdma_shared_dev_plugin' => $this->rdma_shared_dev_plugin,
            'registries' => $this->registries,
            'registry_enabled' => $this->registry_enabled,
            'routing_agent' => $this->routing_agent,
            'service_subnet' => $this->service_subnet,
            'status' => $this->status,
            'surge_upgrade' => $this->surge_upgrade,
            'tags' => $this->tags,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'vpc_uuid' => $this->vpc_uuid,
        ];
    }
}
