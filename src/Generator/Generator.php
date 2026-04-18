<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\ClientEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;
use Mlavrinenko\Paogen\Generator\Emit\OperationEmitter;

/**
 * Orchestrates a single generation run: schema + profile + bindings → files.
 */
final readonly class Generator
{
    public function __construct(
        private AttributeScanner $scanner,
        private ModelEmitter $modelEmitter = new ModelEmitter(),
    ) {}

    public function generate(Profile $profile): void
    {
        $bindings = $this->scanner->scan($profile);

        // Keep $ref nodes as Reference objects so the emitter can resolve them
        // to typed cross-class references.
        $openApi = Reader::readFromYamlFile($profile->schema, OpenApi::class, false);

        $rootNamespace = rtrim($profile->namespace, '\\') . '\\Generated';
        $modelNamespace = $rootNamespace . '\\Model';
        $rootDir = rtrim($profile->output, \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . 'Generated';
        $modelDir = $rootDir . \DIRECTORY_SEPARATOR . 'Model';

        $this->ensureDir($modelDir);

        $this->emitModels($openApi, $modelNamespace, $modelDir, $profile->renames, $bindings);
        $this->emitClient($openApi, $rootNamespace, $rootDir, $modelNamespace, $bindings);
    }

    /**
     * @param array<string,string> $renames
     */
    private function emitModels(
        OpenApi $openApi,
        string $modelNamespace,
        string $modelDir,
        array $renames,
        Bindings $bindings,
    ): void {
        $components = $openApi->components;

        if ($components === null) {
            return;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $names = array_keys($schemas);
        sort($names, \SORT_STRING);

        foreach ($names as $rawName) {
            $schema = $schemas[$rawName];

            if (!$schema instanceof Schema) {
                continue;
            }

            if ($schema->type !== 'object') {
                continue;
            }

            $className = $renames[$rawName] ?? $rawName;
            $code = $this->modelEmitter->emit($modelNamespace, $className, $schema, $bindings);

            $path = $modelDir . \DIRECTORY_SEPARATOR . $className . '.php';
            file_put_contents($path, $code);
        }
    }

    private function emitClient(
        OpenApi $openApi,
        string $rootNamespace,
        string $rootDir,
        string $modelNamespace,
        Bindings $bindings,
    ): void {
        if ($openApi->paths === null) {
            return;
        }

        $emitter = new ClientEmitter(new OperationEmitter($modelNamespace));
        $code = $emitter->emit($rootNamespace, 'ApiClient', $openApi, $bindings);

        $path = $rootDir . \DIRECTORY_SEPARATOR . 'ApiClient.php';

        if ($code === null) {
            if (is_file($path)) {
                unlink($path);
            }

            return;
        }

        $this->ensureDir($rootDir);

        file_put_contents($path, $code);
    }

    private function ensureDir(string $dir): void
    {
        if (!is_dir($dir) && !mkdir($dir, 0o755, true) && !is_dir($dir)) {
            throw new \RuntimeException("Could not create output dir: {$dir}");
        }
    }
}
