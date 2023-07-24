<?php

namespace SprykerSdk\SprykerFeatureRemover\Action;

use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;

class DataBuilderGenerator implements ActionInterface
{
    private const GENERATED_DATA_BUILDER_DIR = 'src/Generated/Shared/DataBuilder';

    public function act(ActionDto $actionDto): void
    {
        $this->removeGeneratedFiles();
        $this->generateFiles();
    }

    private function removeGeneratedFiles(): void
    {
        echo 'Removing ' . self::GENERATED_DATA_BUILDER_DIR;
        $result = shell_exec('rm -rf ' . self::GENERATED_DATA_BUILDER_DIR);
        echo $result . PHP_EOL;
    }

    private function generateFiles(): void
    {
        echo 'Going to execute vendor/bin/console transfer:databuilder:generate' . PHP_EOL;
        $result = shell_exec('vendor/bin/console transfer:databuilder:generate');
        if (!$result) {
            echo 'DataBuilder re-generation failed. Please run manually: ' . PHP_EOL;
            echo 'vendor/bin/console transfer:databuilder:generate' . PHP_EOL;

            return;
        }

        echo $result . PHP_EOL;
    }
}
