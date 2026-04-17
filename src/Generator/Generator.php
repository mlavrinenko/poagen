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
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;

/**
 * Orchestrates a single generation run: schema + profile + bindings → files.
 */
final readonly class Generator
{
    public function __construct(
        private AttributeScanner $scanner,
        private ModelEmitter $emitter = new ModelEmitter(),
    ) {}

    public function generate(Profile $profile): void
    {
        $bindings = $this->scanner->scan($profile);

        // Keep $ref nodes as Reference objects so the emitter can resolve them
        // to typed cross-class references.
        $openApi = Reader::readFromYamlFile($profile->schema, OpenApi::class, false);

        $components = $openApi->components;
        if ($components === null) {
            return;
        }

        $modelNamespace = rtrim($profile->namespace, '\\') . '\\Generated\\Model';
        $modelDir = rtrim($profile->output, \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . 'Generated' . \DIRECTORY_SEPARATOR . 'Model';

        if (!is_dir($modelDir) && !mkdir($modelDir, 0o755, true) && !is_dir($modelDir)) {
            throw new \RuntimeException("Could not create output dir: {$modelDir}");
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

            $className = $profile->renames[$rawName] ?? $rawName;
            $code = $this->emitter->emit($modelNamespace, $className, $schema, $bindings);

            $path = $modelDir . \DIRECTORY_SEPARATOR . $className . '.php';
            file_put_contents($path, $code);
        }
    }
}
