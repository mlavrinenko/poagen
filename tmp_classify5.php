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
    // full-line extraction: capture ALL Model\X occurrences, not just message half
    preg_match_all('#Model\\\\([A-Za-z0-9_]+)#', $line, $ms);
    foreach ($ms[1] as $m) {
        $map[$m] = true;
    }
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
$genDirs = ["DO" => "examples/digitalocean/generated/Generated/Model", "GH" => "examples/github/generated/Generated/Model"];
$counts = [];
$byKind = [];
foreach ($map as $miss => $_) {
    $exists = false;
    foreach ($genDirs as $d) {
        if (file_exists("$d/$miss.php")) { $exists = true; break; }
    }
    if ($exists) continue;
    $entry = $pascalToRaw[$miss] ?? null;
    if ($entry === null) {
        $counts["UNMAPPED"] = ($counts["UNMAPPED"] ?? 0) + 1;
        $byKind["UNMAPPED"][] = $miss;
        continue;
    }
    [$label, $raw, $schema] = $entry;
    $k = classify($schema);
    $counts[$k] = ($counts[$k] ?? 0) + 1;
    $byKind[$k][] = "$label:$raw ($miss)";
}
ksort($counts);
echo "=== counts (truly missing, fixed regex) ===\n";
foreach ($counts as $k => $v) echo sprintf("%5d  %s\n", $v, $k);
foreach ($byKind as $k => $list) {
    echo "\n=== $k (" . count($list) . ") ===\n";
    foreach (array_slice($list, 0, 25) as $x) echo "  $x\n";
    if (count($list) > 25) echo "  ... " . (count($list) - 25) . " more\n";
}
