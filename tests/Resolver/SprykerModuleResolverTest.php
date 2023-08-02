<?php

namespace SprykerSdkTests\Resolver;

use Composer\Package\Link;
use Composer\Package\Package;
use Composer\Semver\Constraint\Constraint;
use SprykerSdk\SprykerFeatureRemover\Adapter\ComposerAdapter;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveDto;
use SprykerSdk\SprykerFeatureRemover\Resolver\SprykerModuleResolver;
use PHPUnit\Framework\TestCase;

class SprykerModuleResolverTest extends TestCase
{

    public function testExpandWithFeatureModuleNames()
    {
        $dummyFeaturePackage = new Package(
            'spryker-feature/dummy-metapackage',
            '10.0.0',
            '10.0.0',
        );

        $requirements = [
            'spryker/dummy-pack-1' => new Link('spryker-feature/dummy-metapackage', 'spryker/dummy-pack-1', new Constraint('>=', '1.2.3')),
            'spryker-feature/dummy-pack-2' => new Link('spryker-feature/dummy-metapackage', 'spryker-feature/dummy-pack-2', new Constraint('>=', '2.0.1')),
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


        $composerAdapter = $this->createMock(ComposerAdapter::class);
        $composerAdapter->expects($this->once())
            ->method('getListOfPackageDependencies')
            ->with($dummyFeaturePackage)
            ->willReturn([
                'spryker/dummy-pack-1',
                'spryker-shop/dummy-shop-pack-1',
                'spryker-eco/dummy-eco-pack-1',
                'spryker/dummy-pack-4',
                'spryker-sdk/dummy-sdk-pack-1',
            ]);

        $dto = new PackageRemoveDto();
        $dto->addPackage($dummyFeaturePackage);

        $moduleResolver = new SprykerModuleResolver($composerAdapter);
        $moduleResolver->expandWithFeatureModuleNames($dto);

        $this->assertSame(
            ['DummyPack1', 'DummyShopPack1', 'DummyEcoPack1', 'DummyPack4', 'DummySdkPack1',],
            $dto->getModuleNames(),
        );
    }
}
