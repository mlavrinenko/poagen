<?php
require __DIR__ . "/vendor/autoload.php";
use Symfony\Component\Yaml\Yaml;

function classify(array $s): string {
    $type = $s["type"] ?? null;
    if (is_array($type)) $type = "array_of_types"; // 3.1
    if (isset($s["enum"])) return "enum";
    if ($type === "object") return "object";
    if (isset($s["oneOf"])) return "oneOf";
    if (isset($s["anyOf"])) return "anyOf";
    if (isset($s["allOf"])) return "allOf";
    if ($type === "array") return "array";
    if (in_array($type, ["string","integer","number","boolean"], true)) return "scalar:$type" . (isset($s["format"]) ? "(format={$s['format']})" : "");
    return "other(type=" . var_export($type, true) . ")";
}

function pascal(string $raw): string {
    // cheap mirror of PascalCaseSanitiser
    $parts = preg_split('/[^a-zA-Z0-9]+/', $raw);
    return implode('', array_map('ucfirst', array_filter($parts, fn($p) => $p !== '')));
}

// Read the missing-class list from phpstan output
$missing = file($argv[1] ?? "php://stdin", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$map = [];
foreach ($missing as $line) {
    if (!preg_match('#Model\\\\([A-Za-z0-9_]+)#', $line, $m)) continue;
    $map[$m[1]] = true;
}

$schemaFiles = [
    "DO" => "examples/digitalocean/schemas/DigitalOcean-public.v2.yaml",
    "GH" => "examples/github/schemas/api.github.com.yaml",
];

$counts = [];
foreach ($schemaFiles as $label => $path) {
    $y = Yaml::parseFile($path);
    $schemas = $y["components"]["schemas"] ?? [];
    foreach ($schemas as $name => $s) {
        $p = pascal($name);
        if (!isset($map[$p])) continue;
        $k = classify($s);
        $counts[$k] = ($counts[$k] ?? 0) + 1;
    }
}

ksort($counts);
foreach ($counts as $k => $v) echo sprintf("%5d  %s\n", $v, $k);
