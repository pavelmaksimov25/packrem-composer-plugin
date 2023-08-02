<?php

namespace SprykerSdkTests\Extractor;

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\DependencyResolver\Operation\MarkAliasInstalledOperation;
use Composer\DependencyResolver\Operation\MarkAliasUninstalledOperation;
use Composer\DependencyResolver\Operation\OperationInterface;
use Composer\DependencyResolver\Operation\UninstallOperation;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\Installer\PackageEvent;
use Composer\IO\NullIO;
use Composer\Package\AliasPackage;
use Composer\Package\Package;
use Composer\Repository\ArrayRepository;
use Composer\Semver\Constraint\Constraint;
use PHPUnit\Framework\TestCase;
use SprykerSdk\SprykerFeatureRemover\Extractor\PackageExtractor;

class PackageExtractorTest extends TestCase
{
    public function testExtractPackagesReturnsPackageIfUninstallOperationsProvided():void
    {
        $expectedPackage = new Package('spryker/tax', '2.1.5', new Constraint('>=', '2.0.0'));

        $uninstallOperation = new UninstallOperation($expectedPackage);
        $packageExtractor = new PackageExtractor();
        $packageEvent = new PackageEvent(
            'uninstall',
            new Composer(),
            new NullIO(),
            'false',
            new ArrayRepository(),
            [],
            $uninstallOperation
        );

        $extracted = $packageExtractor->extractPackages($packageEvent);

        $this->assertSame([$extracted], [$extracted]);
    }

    /**
     * @dataProvider provideInvalidOperations
     * @param array $operations
     * @return void
     */
    public function testExtractPackagesReturnsEmptyArrayIfNoUninstallOperationsProvided(OperationInterface $operation):void
    {
        $packageExtractor = new PackageExtractor();
        $packageEvent = new PackageEvent(
            'uninstall',
            new Composer(),
            new NullIO(),
            'false',
            new ArrayRepository(),
            [],
            $operation
        );


        $result = $packageExtractor->extractPackages($packageEvent);

        $this->assertSame([], $result);
    }

    /**
     * @return array[]
     */
    public function provideInvalidOperations(): array
    {
        return [
            [
                new InstallOperation(new Package('', '', new Constraint('>=', '1.0.0'))),
                new UpdateOperation(
                    new Package('', '', new Constraint('>=', '1.0.0')),
                    new Package('', '', new Constraint('>=', '1.0.0')),
                ),
                new MarkAliasInstalledOperation(new AliasPackage(new Package('', '', new Constraint('>=', '1.0.0')), '', '')),
                new MarkAliasUninstalledOperation(new AliasPackage(new Package('', '', new Constraint('>=', '1.0.0')), '', '')),
            ]
        ];
    }
}
