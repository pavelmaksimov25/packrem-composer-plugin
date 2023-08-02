<?php

namespace SprykerSdkTests\Validator;

use Composer\Package\Package;
use SprykerSdk\SprykerFeatureRemover\Adapter\ComposerAdapter;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveDto;
use SprykerSdk\SprykerFeatureRemover\Validator\PackageValidator;
use PHPUnit\Framework\TestCase;

class PackageValidatorTest extends TestCase
{
    /**
     * @dataProvider provideSprykerPackages
     * @return void
     */
    public function testIsValidListOfPackages(Package $dummyPackage): void
    {
        $composerAdapter = $this->createMock(ComposerAdapter::class);
        $composerAdapter->expects($this->once())
            ->method('isPackageInstalled')
            ->willReturn(true);

        $dto = new PackageRemoveDto();
        $dto->addPackage($dummyPackage);

        $packageValidator = new PackageValidator($composerAdapter);
        $result = $packageValidator->isValidListOfPackages($dto);

        $this->assertTrue($result->isOk());
        $this->assertSame('', $result->getMessage());
    }

    public function testIsValidListOfPackagesFailsValidationIfTrdPartyPackageProvided(): void
    {
        $composerAdapter = $this->createMock(ComposerAdapter::class);
        $composerAdapter->expects($this->never())
            ->method('isPackageInstalled');

        $dummyPackage = new Package('symfony/dummy-spryker-one', '10.0.0', '10.0.0');
        $dto = new PackageRemoveDto();
        $dto->addPackage($dummyPackage);

        $packageValidator = new PackageValidator($composerAdapter);
        $result = $packageValidator->isValidListOfPackages($dto);

        $this->assertFalse($result->isOk());
        $this->assertSame($dummyPackage->getName() . ' is not spryker package.', $result->getMessage());
    }

    /**
     * @dataProvider provideNotInstalledPackages
     *
     * @param Package $dummyPackage
     * @return void
     */
    public function testIsValidListOfPackagesFailsValidationIfNotInstalledPackageIsProvided(Package $dummyPackage): void
    {
        $composerAdapter = $this->createMock(ComposerAdapter::class);
        $composerAdapter->expects($this->once())
            ->method('isPackageInstalled')
            ->willReturn(false);

        $dto = new PackageRemoveDto();
        $dto->addPackage($dummyPackage);

        $packageValidator = new PackageValidator($composerAdapter);
        $result = $packageValidator->isValidListOfPackages($dto);

        $this->assertFalse($result->isOk());
        $this->assertSame($dummyPackage->getName() . ' is not installed.', $result->getMessage());
    }

    public function provideSprykerPackages(): array
    {
        return [
            [new Package('spryker/dummy-metapackage-one', '10.0.0', '10.0.0')],
            [new Package('spryker-feature/dummy-metapackage-two', '202204.p1', '202204.p1')],
            [new Package('spryker-shop/dummy-metapackage-three', '1.45.1', '1.45.1')],
            [new Package('spryker-eco/dummy-metapackage-four', '15.0.1', '15.0.1')],
            [new Package('spryker-sdk/dummy-metapackage-five', '0.44.0', '0.44.0')],
        ];
    }


    public function provideNotInstalledPackages(): array
    {
        return [
            [new Package('spryker/dummy-metapackage-one', '10.0.0', '10.0.0')],
            [new Package('spryker-feature/dummy-metapackage-two', '202204.p1', '202204.p1')],
            [new Package('spryker-shop/dummy-metapackage-three', '1.45.1', '1.45.1')],
            [new Package('spryker-eco/dummy-metapackage-four', '15.0.1', '15.0.1')],
            [new Package('spryker-sdk/dummy-metapackage-five', '0.44.0', '0.44.0')],
        ];
    }
}
