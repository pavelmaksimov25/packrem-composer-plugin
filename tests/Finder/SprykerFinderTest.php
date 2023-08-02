<?php

namespace SprykerSdkTests\Finder;

use SprykerSdk\SprykerFeatureRemover\Config\Config;
use SprykerSdk\SprykerFeatureRemover\Factory\SymfonyFinderFactory;
use SprykerSdk\SprykerFeatureRemover\Finder\SprykerFinder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;

class SprykerFinderTest extends TestCase
{
    public function testFilterDependencyProvider()
    {
        $files = [
            'Pyz\\Client\\Product\\ProductDependencyProvider.php',
            'Pyz\\Glue\\Product\\ProductConfig.php',
            'Pyz\\Shared\\Product\\ProductConfig.php',
            'Pyz\\Zed\\Product\\Config\\ProductConfig.php',
            'Pyz\\Zed\\Product\\ProductDependencyProvider.php',
            'Pyz\\Zed\\Product\\Business\\ProductFacade.php',
            'Pyz\\Zed\\Product\\Business\\ProductBusinessFactory.php',
            'Pyz\\Zed\\Product\\Business\\Creator\\ProductCreator.php',
        ];

        $finder = new SprykerFinder(new SymfonyFinderFactory(), new Config('Pyz'));
        $result = $finder->filterDependencyProvider($files);

        $this->assertSame(
            [
                'Pyz\\Client\\Product\\ProductDependencyProvider.php',
                'Pyz\\Zed\\Product\\ProductDependencyProvider.php',
            ],
            array_values($result),
        );
    }

    public function testFindAffectedFiles(): void
    {
        $this->markTestSkipped('This test is not working as expected. Needs to be fixed.');
        $expectedFile = 'src\\Pyz\\Zed\\ProductStore\\ProductStoreDependencyProvider.php';
        $dummyIterator = new \ArrayIterator([new \SplFileInfo($expectedFile)]);
        $finderMock = $this->createMock(Finder::class);
        $finderMock->expects($this->once())
            ->method('getIterator')
            ->willReturn($dummyIterator);

        $symfonyFinderFactoryMock = $this->createMock(SymfonyFinderFactory::class);
        $symfonyFinderFactoryMock->expects($this->once())
            ->method('createFinder')
            ->willReturn($finderMock);

        $sprykerFinder = new SprykerFinder($symfonyFinderFactoryMock, new Config('Pyz'));
        $affectedFiles = $sprykerFinder->findAffectedFiles(['Pyz\\Zed\\Product\\Communication\\Plugin\\ProductAbstractTransferExpanderPlugin']);

        $this->assertCount($dummyIterator->count(), $affectedFiles);
        $this->assertContains($expectedFile, $affectedFiles);
    }
}
