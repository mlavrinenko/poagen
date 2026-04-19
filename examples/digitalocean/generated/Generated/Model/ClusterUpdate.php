<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ClusterUpdate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
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
        'control_plane_firewall' => [
            'control_plane_firewall',
            \Acme\DigitalOcean\Generated\Model\ControlPlaneFirewall::class,
        ],
        'ha' => ['ha', null],
        'maintenance_policy' => ['maintenance_policy', \Acme\DigitalOcean\Generated\Model\MaintenancePolicy::class],
        'nvidia_gpu_device_plugin' => [
            'nvidia_gpu_device_plugin',
            \Acme\DigitalOcean\Generated\Model\NvidiaGpuDevicePlugin::class,
        ],
        'rdma_shared_dev_plugin' => [
            'rdma_shared_dev_plugin',
            \Acme\DigitalOcean\Generated\Model\RdmaSharedDevPlugin::class,
        ],
        'routing_agent' => ['routing_agent', \Acme\DigitalOcean\Generated\Model\RoutingAgent::class],
        'surge_upgrade' => ['surge_upgrade', null],
        'tags' => ['tags', ['list', null]],
    ];

    /**
     * @param ?list<string> $tags
     */
    public function __construct(
        public string $name,
        public ?AmdGpuDeviceMetricsExporterPlugin $amd_gpu_device_metrics_exporter_plugin = null,
        public ?AmdGpuDevicePlugin $amd_gpu_device_plugin = null,
        public ?bool $auto_upgrade = null,
        public ?ClusterAutoscalerConfiguration $cluster_autoscaler_configuration = null,
        public ?ControlPlaneFirewall $control_plane_firewall = null,
        public ?bool $ha = null,
        public ?MaintenancePolicy $maintenance_policy = null,
        public ?NvidiaGpuDevicePlugin $nvidia_gpu_device_plugin = null,
        public ?RdmaSharedDevPlugin $rdma_shared_dev_plugin = null,
        public ?RoutingAgent $routing_agent = null,
        public ?bool $surge_upgrade = null,
        public ?array $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'amd_gpu_device_metrics_exporter_plugin' => $this->amd_gpu_device_metrics_exporter_plugin,
            'amd_gpu_device_plugin' => $this->amd_gpu_device_plugin,
            'auto_upgrade' => $this->auto_upgrade,
            'cluster_autoscaler_configuration' => $this->cluster_autoscaler_configuration,
            'control_plane_firewall' => $this->control_plane_firewall,
            'ha' => $this->ha,
            'maintenance_policy' => $this->maintenance_policy,
            'nvidia_gpu_device_plugin' => $this->nvidia_gpu_device_plugin,
            'rdma_shared_dev_plugin' => $this->rdma_shared_dev_plugin,
            'routing_agent' => $this->routing_agent,
            'surge_upgrade' => $this->surge_upgrade,
            'tags' => $this->tags,
        ];
    }
}
