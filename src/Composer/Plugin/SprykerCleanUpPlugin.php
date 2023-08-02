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

        // todo :: load only once
        //   currently it asks each time on each command.
        // todo :: Load project namespace from the projects default config.
//        $value = (string)$this->io->ask('Please set project namespace. Default is `Pyz`.');
//        if (!$value) {
//            $this->io->warning('The incorrect value has been provided. The default one(`Pyz`) will be set.');
//            $this->io->warning('Please, set proper namespace to the `extra` section in the composer.json so `PackRem` works properly.');
//        }

        $extra = $this->composer->getPackage()->getExtra();
        $extra[Config::KEY_PROJECT_NAMESPACE] = 'Pyz'; // stub
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
            foreach ($result->getMessages() as $message) {
                $this->io->error($message);
            }
        }
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}
