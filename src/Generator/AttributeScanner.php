<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use Composer\Autoload\ClassLoader;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use SplFileInfo;

use function strlen;

use const DIRECTORY_SEPARATOR;

/**
 * Walks PSR-4 directories that overlap with the Profile's `discoverIn`
 * namespaces, reflects each class, and collects user-declared bindings — the
 * document-wide `#[BindsFormat]` attributes discovered this way, plus
 * `Profile::$formats` and `Profile::$propertyFormats`, which need no
 * discovery at all: they name their class directly, so they ride straight
 * through onto {@see Bindings} (bind-a-format-per-property).
 */
final readonly class AttributeScanner
{
    public function __construct(private ClassLoader $loader) {}

    public function scan(Profile $profile): Bindings
    {
        $formats = [];

        foreach ($this->classesIn($profile->discoverIn) as $fqcn) {
            $reflection = new ReflectionClass($fqcn);

            foreach ($reflection->getAttributes(Attribute\BindsFormat::class) as $attribute) {
                /** @var Attribute\BindsFormat $instance */
                $instance = $attribute->newInstance();
                $formats[$instance->format] = $fqcn;
            }
        }

        return new Bindings($formats, $profile->formats, $profile->propertyFormats);
    }

    /**
     * @param  list<string>          $discoverIn
     * @return iterable<class-string>
     */
    private function classesIn(array $discoverIn): iterable
    {
        $psr4 = $this->loader->getPrefixesPsr4();

        foreach ($discoverIn as $namespace) {
            $namespace = trim($namespace, '\\');

            foreach ($psr4 as $prefix => $dirs) {
                $prefixTrimmed = rtrim($prefix, '\\');
                if ($prefixTrimmed === '') {
                    continue;
                }
                if (!str_starts_with($namespace . '\\', $prefixTrimmed . '\\')) {
                    continue;
                }

                $relative = substr($namespace, strlen($prefixTrimmed));
                $subPath = str_replace('\\', DIRECTORY_SEPARATOR, ltrim($relative, '\\'));

                foreach ($dirs as $dir) {
                    $root = $dir . ($subPath !== '' ? DIRECTORY_SEPARATOR . $subPath : '');

                    if (!is_dir($root)) {
                        continue;
                    }

                    yield from $this->scanDirectory($root, $namespace);
                }
            }
        }
    }

    /**
     * @return iterable<class-string>
     */
    private function scanDirectory(string $root, string $namespace): iterable
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
        );

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }
            if ($file->getExtension() !== 'php') {
                continue;
            }
            $relativePath = substr($file->getPathname(), strlen($root) + 1, -strlen('.php'));
            $classSuffix = str_replace(DIRECTORY_SEPARATOR, '\\', $relativePath);
            $fqcn = $namespace . '\\' . $classSuffix;

            if (class_exists($fqcn)) {
                /** @var class-string $fqcn */
                yield $fqcn;
            }
        }
    }
}
