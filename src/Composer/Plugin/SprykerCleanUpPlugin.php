<?php

namespace SprykerSdk\SprykerFeatureRemover\Composer\Plugin;

use Composer\Composer;
use Composer\DependencyResolver\Operation\UninstallOperation;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Plugin\PluginInterface;
use SprykerSdk\SprykerFeatureRemover\Application;
use SprykerSdk\SprykerFeatureRemover\Config\Config;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveDto;
use SprykerSdk\SprykerFeatureRemover\Factory\PackRemFactory;
use SprykerSdk\SprykerFeatureRemover\PackageRemover\PackageRemover;
use SprykerSdk\SprykerFeatureRemover\Resolver\SprykerModuleResolver;
use SprykerSdk\SprykerFeatureRemover\Validator\PackageValidator;

class SprykerCleanUpPlugin implements PluginInterface, EventSubscriberInterface
{
    private IOInterface $io;

    private Composer $composer;

    /**
     * Get subscribed events.
     *
     * @return array<string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            PackageEvents::POST_PACKAGE_UNINSTALL => 'preCommand',
        ];
    }

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

        $value = (string)$this->io->ask('Please set project namespace. Deafult is `Pyz`.');
        if (!$value) {
            $this->io->warning('The incorrect value has been provided. The default one(`Pyz`) will be set.');
            $this->io->warning('Please, set proper namespace to the `extra` section in the composer.json so `PackRem` works properly.');
        }

        $extra = $this->composer->getPackage()->getExtra();
        $extra[Config::KEY_PROJECT_NAMESPACE] = $value;
        $this->composer->getPackage()->setExtra($extra);
    }

    /**
     * Event handler for the 'pre-command' event.
     *
     * @param PackageEvent $event
     *
     * @return void
     */
    public function preCommand(PackageEvent $event): void
    {
        $application = new Application($event->getComposer());
        $result = $application->run($event);

        if (!$result->isOk()) {
            $this->io->error($result->getMessage());
        }
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // expected that project namespace value will be removed from the composer.json
        $extra = $this->composer->getPackage()->getExtra();
        unset($extra[Config::KEY_PROJECT_NAMESPACE]);
        $this->composer->getPackage()->setExtra($extra);
    }
}
