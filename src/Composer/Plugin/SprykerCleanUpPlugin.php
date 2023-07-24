<?php

namespace SprykerSdk\SprykerFeatureRemover\Composer\Plugin;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PreCommandRunEvent;
use SprykerSdk\SprykerFeatureRemover\Factory\PackRemFactory;
use SprykerSdk\SprykerFeatureRemover\PackageRemover\PackageRemover;
use SprykerSdk\SprykerFeatureRemover\PackageRemover\PackageRemoverFactory;
use SprykerSdk\SprykerFeatureRemover\Validator\PackageValidator;

class SprykerCleanUpPlugin implements PluginInterface
{
    public const ACCEPTED_COMMAND = 'remove';

    /** @var IOInterface */
    private IOInterface $io;

    /**
     * @var Composer
     */
    private Composer $composer;

    private PackageRemover $packageRemover;

    private PackageValidator $packageValidator;

    /**
     * Activate the plugin.
     *
     * @param Composer $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;

        $this->packageRemover = (new PackRemFactory())->createPackageRemover();
        $this->packageValidator = new PackageValidator();
    }

    /**
     * Get subscribed events.
     *
     * @return array<string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'pre-command' => 'preCommand',
        ];
    }

    /**
     * Event handler for the 'pre-command' event.
     *
     * @param PreCommandRunEvent $event
     *
     * @return void
     */
    public function preCommand(PreCommandRunEvent $event): void
    {
        $command = $event->getCommand();
        if ($command !== self::ACCEPTED_COMMAND) {
            return;
        }

        $pkgStr = str_replace(self::ACCEPTED_COMMAND, '', $command);
        $packages = explode(' ', $pkgStr);
        if (count($packages) === 0) {
            return;
        }

        $packageValidationResult = $this->packageValidator->isValidListOfPackages($packages);
        if (!$packageValidationResult->isOk()) {
            throw new \RuntimeException(
                $packageValidationResult->getMessage() . PHP_EOL
                . 'Please, run composer remove --no-spryker-packrem-plugin <package1_name,...,packageN_name> to uninstall packages in regular mode.'
            );
        }

        if (str_contains($command, '--namespace')) {
            putenv(Confg::PROJECT_NAMESPACE . '=Pyz'); // todo :: set passed project namespace. So far this is a stub.
        }

        $result = $this->packageRemover->removePackages($packages);
        if (!$result->isOk()) {
            $this->io->error('Unable to remove spryker data.');
            foreach ($result->getMessages() as $message) {
                $this->io->error($message);
            }

            throw new \RuntimeException(
                $packageValidationResult->getMessage() . PHP_EOL
                . 'Please, run composer remove --no-spryker-packrem-plugin <package1_name,...,packageN_name> to uninstall packages in regular mode.'
            );
        }

        $this->io->info('Spryker packages data is removed.');
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}
