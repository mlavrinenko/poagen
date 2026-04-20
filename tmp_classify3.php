<?php
require __DIR__ . "/vendor/autoload.php";
use Symfony\Component\Yaml\Yaml;

function pascal(string $raw): string {
    $parts = preg_split('/[^a-zA-Z0-9]+/', $raw);
    return implode('', array_map('ucfirst', array_filter($parts, fn($p) => $p !== '')));
}

function classify(array $s): string {
    $type = $s["type"] ?? null;
    if (isset($s["enum"])) return "enum";
    if ($type === "object") return "object";
    if (isset($s["oneOf"])) return "oneOf";
    if (isset($s["anyOf"])) return "anyOf";
    if (isset($s["allOf"])) return "allOf";
    if ($type === "array") return "array";
    if (in_array($type, ["string","integer","number","boolean"], true)) return "scalar:$type";
    return "other(type=" . var_export($type, true) . ")";
}

$missing = file($argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$map = [];
foreach ($missing as $line) {
    if (!preg_match('#Model\\\\([A-Za-z0-9_]+)#', $line, $m)) continue;
    $map[$m[1]] = true;
}

$schemaFiles = [
    "DO" => "examples/digitalocean/schemas/DigitalOcean-public.v2.yaml",
    "GH" => "examples/github/schemas/api.github.com.yaml",
];

$pascalToRaw = [];
foreach ($schemaFiles as $label => $path) {
    $y = Yaml::parseFile($path);
    $schemas = $y["components"]["schemas"] ?? [];
    foreach ($schemas as $name => $s) {
        $p = pascal($name);
        $pascalToRaw[$p] = [$label, $name, $s];
    }
}

$counts = [];
$objects = [];
foreach ($map as $miss => $_) {
    $entry = $pascalToRaw[$miss] ?? null;
    if ($entry === null) {
        $counts["UNMAPPED"] = ($counts["UNMAPPED"] ?? 0) + 1;
        continue;
    }
    [$label, $raw, $schema] = $entry;
    $k = classify($schema);
    $counts[$k] = ($counts[$k] ?? 0) + 1;
    if ($k === "object") $objects[] = "$label $raw ($miss)";
}
ksort($counts);
echo "=== counts ===\n";
foreach ($counts as $k => $v) echo sprintf("%5d  %s\n", $v, $k);
echo "\n=== missing objects (first 30) ===\n";
foreach (array_slice($objects, 0, 30) as $o) echo "  $o\n";
