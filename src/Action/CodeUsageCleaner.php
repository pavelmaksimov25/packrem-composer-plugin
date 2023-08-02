<?php

namespace SprykerSdk\SprykerFeatureRemover\Action;

use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use SprykerSdk\SprykerFeatureRemover\Finder\SprykerFinder;
use SprykerSdk\SprykerFeatureRemover\Helper\SprykerPath;
use SprykerSdk\SprykerFeatureRemover\PluginRemover\PluginRemover;

class CodeUsageCleaner implements ActionInterface
{
    public function __construct(private SprykerPath $sprykerPath, private SprykerFinder $finder, private PluginRemover $pluginRemover)
    {
    }

    public function act(ActionDto $actionDto): void
    {
        foreach ($actionDto->getModuleNames() as $moduleName) {
            $moduleNamespaces = $this->sprykerPath->getModuleNamespaces($moduleName);
            $affectedFiles = $this->findAffectedFiles($moduleNamespaces);

            foreach ($affectedFiles as $affectedFile) {
                if ($affectedFile === 'src/Generated/Shared/Transfer/AbstractTransfer.php') {
                    continue;
                }

                $this->removeUnusedCode($affectedFile, $moduleNamespaces);
            }
        }
    }

    private function findAffectedFiles(array $moduleNamespaces): array
    {
        $affectedFiles = $this->finder->findAffectedFiles($moduleNamespaces);

        return $this->finder->filterDependencyProvider($affectedFiles);
    }

    private function removeUnusedCode(string $file, array $moduleNamespaces): void
    {
        $fileContent = file_get_contents($file);
        if (!$fileContent) {
            return;
        }
        $fileContent = $this->removeUnusedUseStatements($fileContent, $moduleNamespaces);
        $fileContent = $this->removeUnusedClassConstants($fileContent, $moduleNamespaces);

        file_put_contents($file, $fileContent);

        // based on the use block entrances define classes
        // search
    }

    private function removeUnusedUseStatements(string $fileContent, array $moduleNamespaces): string
    {
        $useRegs = [];
        foreach ($moduleNamespaces as $moduleNamespace) {
            $useRegs[] = "/use $moduleNamespace;+/";
            $useRegs[] = "/^use $moduleNamespace\\+/";
        }

        $useRegs = array_unique($useRegs);

        foreach ($useRegs as $useReg) {
            $fileContent = preg_replace($useReg, '', $fileContent);
        }

        return $fileContent;
    }

    private function removeUnusedClassConstants(string $fileContent, array $moduleNamespaces): string
    {
//        $this->pluginRemover->unwirePlugin();

        return '';
    }
}