<?php

namespace SprykerSdkTests\Resolver;

use SprykerSdk\SprykerFeatureRemover\Finder\SprykerFinder;
use SprykerSdk\SprykerFeatureRemover\Helper\SprykerPath;
use SprykerSdk\SprykerFeatureRemover\Resolver\ModuleUseResolver;
use PHPUnit\Framework\TestCase;

class ModuleUseResolverTest extends TestCase
{
    public function testResolvePluginsUse(): void
    {
        $namespaces = [
            'Pyz\\Zed\\Product',
            'Pyz\\Client\\Product',
            'Pyz\\Shared\\Product',
            'Pyz\\Glue\\Product',
        ];

        $affectedFiles = [
            'Pyz\\Client\\Product\\ProductDependencyProvider.php',
            'Pyz\\Glue\\Product\\ProductConfig.php',
            'Pyz\\Shared\\Product\\ProductConfig.php',
            'Pyz\\Zed\\Product\\Config\\ProductConfig.php',
            'Pyz\\Zed\\Product\\ProductDependencyProvider.php',
            'Pyz\\Zed\\Product\\Business\\ProductFacade.php',
            'Pyz\\Zed\\Product\\Business\\ProductBusinessFactory.php',
            'Pyz\\Zed\\Product\\Business\\Creator\\ProductCreator.php',
        ];

        $sprykerPathMock = $this->createMock(SprykerPath::class);
        $sprykerPathMock->expects($this->once())
            ->method('getModuleNamespaces')
            ->with('Product')
            ->willReturn($namespaces);

        $finderMock = $this->createMock(SprykerFinder::class);
        $finderMock->expects($this->once())
            ->method('findAffectedFiles')
            ->with($namespaces)
            ->willReturn($affectedFiles);

        $finderMock->expects($this->once())
            ->method('filterDependencyProvider')
            ->with($affectedFiles)
            ->willReturn([
                'Pyz\\Client\\Product\\ProductDependencyProvider.php',
                'Pyz\\Zed\\Product\\ProductDependencyProvider.php',
            ]);


        $resolver = new ModuleUseResolver($sprykerPathMock, $finderMock);
        $affectedDependencyProviders = $resolver->resolvePluginsUse('Product');

        $this->assertSame(
            $affectedDependencyProviders,
            [
                'Pyz\\Client\\Product\\ProductDependencyProvider.php',
                'Pyz\\Zed\\Product\\ProductDependencyProvider.php',
            ],
        );
    }
}
