<?php

namespace SprykerSdk\SprykerFeatureRemover\Action;

use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;

class TransferGenerator implements ActionInterface
{
    private const GENERATED_TRANSFER_DIR = 'src/Generated/Shared/Transfer';

    public function act(ActionDto $actionDto): void
    {
        $this->removeGeneratedTransfers();
        $this->generateTransfers();
    }

    private function removeGeneratedTransfers(): void
    {
        echo 'Removing ' . self::GENERATED_TRANSFER_DIR;
        $result = shell_exec('rm -rf ' . self::GENERATED_TRANSFER_DIR);
        echo $result . PHP_EOL;
    }

    private function generateTransfers(): void
    {
        echo 'Going to execute vendor/bin/console transfer:generate' . PHP_EOL;
        $result = shell_exec('vendor/bin/console transfer:generate');
        if (!$result) {
            echo 'Transfer re-generation failed. Please run manually: ' . PHP_EOL;
            echo 'vendor/bin/console transfer:generate' . PHP_EOL;

            return;
        }

        echo $result . PHP_EOL;
    }
}
