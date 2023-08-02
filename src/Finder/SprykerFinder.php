<?php

namespace SprykerSdk\SprykerFeatureRemover\Finder;

use SprykerSdk\SprykerFeatureRemover\Config\Config;
use SprykerSdk\SprykerFeatureRemover\Factory\SymfonyFinderFactory;

class SprykerFinder
{
    public function __construct(private SymfonyFinderFactory $symfonyFinderFactory, private Config $config)
    {
    }

    public function findAffectedFiles(array $namespaces): array
    {
        $patterns = [];
        foreach ($namespaces as $namespace) {
            $patterns[] = "use $namespace;";
            $patterns[] = "use $namespace/";
        }

        $finder = $this->symfonyFinderFactory
            ->createFinder()
            ->files()
            ->in(__DIR__ .DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $this->config->getProjectNamespace())
            ->filter(fn(\SplFileInfo $file) => $file->getExtension() === '.php')
            ->contains($patterns);

        return array_map(
            fn(\SplFileInfo $file): string => $file->getPath(),
            iterator_to_array($finder->getIterator())
        );
    }

    /**
     * @param array $phpFiles
     * @return array<string>
     */
    public function filterDependencyProvider(array $phpFiles): array
    {
        return array_filter(
            $phpFiles,
            fn(string $fileName): bool => str_contains($fileName, 'DependencyProvider.php')
        );
    }
}