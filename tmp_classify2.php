<?php
require __DIR__ . "/vendor/autoload.php";
use Symfony\Component\Yaml\Yaml;

function pascal(string $raw): string {
    $parts = preg_split('/[^a-zA-Z0-9]+/', $raw);
    return implode('', array_map('ucfirst', array_filter($parts, fn($p) => $p !== '')));
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

foreach ($schemaFiles as $label => $path) {
    $y = Yaml::parseFile($path);
    $schemas = $y["components"]["schemas"] ?? [];
    foreach ($schemas as $name => $s) {
        $p = pascal($name);
        if (!isset($map[$p])) continue;
        $type = $s["type"] ?? null;
        if ($type === "object") echo sprintf("%s %-60s  %s  props=%d\n", $label, $p, "object", count($s["properties"] ?? []));
    }
}
