<?php

namespace SprykerSdkTests\Adapter;

use Composer\Package\Link;
use Composer\Package\Package;
use Composer\Semver\Constraint\Constraint;
use SprykerSdk\SprykerFeatureRemover\Adapter\ComposerAdapter;
use PHPUnit\Framework\TestCase;

class ComposerAdapterTest extends TestCase
{

    public function testGetListOfPackageDependenciesReturnsListOfSprykerPackagesForMetaPackage(): void
    {
        $dummyFeaturePackage = new Package(
            'spryker-feature/dummy-metapackage',
            '10.0.0',
            '10.0.0',
        );

        $requirements = [
            'spryker/dummy-pack-1' => new Link('spryker-feature/dummy-metapackage', 'spryker/dummy-pack-1', new Constraint('>=', '1.2.3')),
            'spryker/dummy-pack-2' => new Link('spryker-feature/dummy-metapackage', 'spryker/dummy-pack-2', new Constraint('>=', '2.0.1')),
            'spryker-shop/dummy-shop-pack-1' => new Link('spryker-feature/dummy-metapackage', 'dummy-shop-pack-1', new Constraint('>=', '2.0.1')),
            'spryker-eco/dummy-eco-pack-1' => new Link('spryker-feature/dummy-metapackage', 'spryker-eco/dummy-eco-pack-1', new Constraint('>=', '2.0.1')),
            'symfony/yaml' => new Link('spryker-feature/dummy-metapackage', 'symfony/yaml', new Constraint('>=', '6.0')),
            'php' => new Link('spryker-feature/dummy-metapackage', 'php', new Constraint('>=', '8.0')),
        ];

        $devRequirements = [
            'spryker/dummy-pack-4' => new Link('spryker-feature/dummy-metapackage', 'spryker/dummy-pack-4', new Constraint('>=', '0.21.0')),
            'spryker-sdk/dummy-sdk-pack-1' => new Link('spryker-feature/dummy-metapackage', 'spryker-sdk/dummy-sdk-pack-1', new Constraint('>=', '0.21.0')),
            'phpstan/phpstan' => new Link('spryker-feature/dummy-metapackage', 'phpstan/phpstan', new Constraint('>=', '1.19.0')),
        ];
        $dummyFeaturePackage->setRequires($requirements);
        $dummyFeaturePackage->setDevRequires($devRequirements);


        $composerAdapter = new ComposerAdapter();
        $result = $composerAdapter->getListOfPackageDependencies($dummyFeaturePackage);

        $this->assertSame(
            [
                'spryker/dummy-pack-1',
                'spryker/dummy-pack-2',
                'spryker-shop/dummy-shop-pack-1',
                'spryker-eco/dummy-eco-pack-1',
                'spryker/dummy-pack-4',
                'spryker-sdk/dummy-sdk-pack-1',
            ],
            array_values($result),
        );
    }

    public function testGetListOfPackageDependenciesReturnsListOfSprykerPackagesForRegularPackage(): void
    {
        $taxFeaturePackage = new Package(
            'spryker/dummy',
            '10.0.0',
            '10.0.0',
        );

        $requirements = [
            'spryker/dummy-pack-1' => new Link('spryker-feature/dummy-metapackage', 'spryker/dummy-pack-1', new Constraint('>=', '1.2.3')),
            'spryker/dummy-pack-2' => new Link('spryker-feature/dummy-metapackage', 'spryker/dummy-pack-2', new Constraint('>=', '2.0.1')),
            'spryker-shop/dummy-shop-pack-1' => new Link('spryker-feature/dummy-metapackage', 'dummy-shop-pack-1', new Constraint('>=', '2.0.1')),
            'spryker-eco/dummy-eco-pack-1' => new Link('spryker-feature/dummy-metapackage', 'spryker-eco/dummy-eco-pack-1', new Constraint('>=', '2.0.1')),
            'symfony/yaml' => new Link('spryker-feature/dummy-metapackage', 'symfony/yaml', new Constraint('>=', '6.0')),
            'php' => new Link('spryker-feature/dummy-metapackage', 'php', new Constraint('>=', '8.0')),
        ];

        $devRequirements = [
            'spryker/dummy-pack-4' => new Link('spryker-feature/dummy-metapackage', 'spryker/dummy-pack-4', new Constraint('>=', '0.21.0')),
            'spryker-sdk/dummy-sdk-pack-1' => new Link('spryker-feature/dummy-metapackage', 'spryker-sdk/dummy-sdk-pack-1', new Constraint('>=', '0.21.0')),
            'phpstan/phpstan' => new Link('spryker-feature/dummy-metapackage', 'phpstan/phpstan', new Constraint('>=', '1.19.0')),
        ];
        $taxFeaturePackage->setRequires($requirements);
        $taxFeaturePackage->setDevRequires($devRequirements);


        $composerAdapter = new ComposerAdapter();
        $result = $composerAdapter->getListOfPackageDependencies($taxFeaturePackage);

        $this->assertSame(
            [
                'spryker/dummy-pack-1',
                'spryker/dummy-pack-2',
                'spryker-shop/dummy-shop-pack-1',
                'spryker-eco/dummy-eco-pack-1',
                'spryker/dummy-pack-4',
                'spryker-sdk/dummy-sdk-pack-1',
            ],
            array_values($result),
        );
    }

    public function testGetListOfPackageDependenciesReturnsEmptyArrayIfPackageDoesntHaveSprykerPackagesInDependencies(): void
    {
        $taxFeaturePackage = new Package(
            'spryker-feature/dummy-metapackage',
            '10.0.0',
            '10.0.0',
        );

        $composerAdapter = new ComposerAdapter();
        $result = $composerAdapter->getListOfPackageDependencies($taxFeaturePackage);

        $this->assertSame([], $result);
    }
}
