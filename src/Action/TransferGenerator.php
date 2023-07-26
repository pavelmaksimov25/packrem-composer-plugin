<?php

namespace SprykerSdk\SprykerFeatureRemover\Action;

use SprykerSdk\SprykerFeatureRemover\Adapter\SymfonyProcessAdapter;
use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class TransferGenerator implements ActionInterface
{
    public const COMMAND = 'vendor/bin/console transfer:generate';
    private const GENERATED_TRANSFER_DIR = 'src/Generated/Shared/Transfer';

    public function __construct(private Filesystem $filesystem, private SymfonyProcessAdapter $process)
    {
    }

    public function act(ActionDto $actionDto): void
    {
        $this->removeGeneratedTransfers($actionDto);
        if (!$actionDto->isOk()) {
            return;
        }

        $this->generateTransfers($actionDto);
    }

    private function removeGeneratedTransfers(ActionDto $actionDto): void
    {
        try {
            $this->filesystem->remove(self::GENERATED_TRANSFER_DIR);
        } catch (IOException $exception) {
            $actionDto->addErrorMessage($exception->getMessage());
        }
    }

    private function generateTransfers(ActionDto $actionDto): void
    {
        $resultDto = $this->process->run(self::COMMAND);
        if (!$resultDto->isOk()) {
            $actionDto->addErrorMessage($resultDto->getErrorOutput());
        }
    }
}
