<?php

namespace SprykerSdk\SprykerFeatureRemover\Extractor;

use Composer\DependencyResolver\Operation\UninstallOperation;
use Composer\Installer\PackageEvent;
use Composer\Package\PackageInterface;

final class PackageExtractor
{
    /**
     * @param PackageEvent $event
     *
     * @return array<PackageInterface>
     */
    final public function extractPackages(PackageEvent $event): array
    {
        $packages = [];
        foreach ($event->getOperations() as $operation) {
            if ($operation instanceof UninstallOperation) {
                $packages[] = $operation->getPackage();
            }
        }

        return $packages;
    }
}