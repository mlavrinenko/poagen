<?php

declare(strict_types=1);

namespace Poagen\Generator;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;

/**
 * Chooses the OpenAPI reader by file extension, so `validate` and `generate`
 * make one decision instead of two independent copies of it — see
 * `generate-accepts-only-yaml-while-validate-accepts-json-too`.
 *
 * YAML 1.2 is a JSON superset, so `readFromYamlFile` used to eat a `.json`
 * document without complaint and `Generator::plan` relied on that accident
 * unconditionally, while `Cli::validate` already dispatched on extension.
 * The two readers agree on plain JSON but not on everything YAML's grammar
 * tolerates and JSON's does not — duplicate keys, tab indentation, an
 * integer outside YAML's implicit resolver — so the document a document
 * validated against was not always the one that generated its client.
 *
 * poagen accepts JSON and YAML equally: `.json` always goes through the
 * JSON reader, everything else through the YAML reader (which still reads
 * plain JSON, being a superset, exactly as it did before this existed).
 */
final readonly class SchemaReader
{
    /**
     * @param bool $resolveReferences forwarded to the underlying `Reader`
     *                                call. Both current callers pass
     *                                `false` and resolve references
     *                                themselves later.
     */
    public static function read(string $path, bool $resolveReferences = false): OpenApi
    {
        return str_ends_with(strtolower($path), '.json')
            ? Reader::readFromJsonFile($path, OpenApi::class, $resolveReferences)
            : Reader::readFromYamlFile($path, OpenApi::class, $resolveReferences);
    }
}
