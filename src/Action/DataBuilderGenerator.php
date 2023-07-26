<?php

namespace SprykerSdk\SprykerFeatureRemover\Action;

use SprykerSdk\SprykerFeatureRemover\Adapter\SymfonyProcessAdapter;
use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

final class DataBuilderGenerator implements ActionInterface
{
    public const COMMAND = 'vendor/bin/console transfer:databuilder:generate';
    private const GENERATED_DATA_BUILDER_DIR = 'src/Generated/Shared/DataBuilder';

    public function __construct(private Filesystem $filesystem, private SymfonyProcessAdapter $process)
    {
    }

    final public function act(ActionDto $actionDto): void
    {
        $this->removeGeneratedFiles($actionDto);
        if (!$actionDto->isOk()) {
            return;
        }

        $this->generateFiles($actionDto);
    }

    private function removeGeneratedFiles(ActionDto $actionDto): void
    {
        try {
            $this->filesystem->remove(self::GENERATED_DATA_BUILDER_DIR);
        } catch (IOException $exception) {
            $actionDto->addErrorMessage($exception->getMessage());
        }
    }

    private function generateFiles(ActionDto $actionDto): void
    {
        $result = $this->process->run(self::COMMAND);
        if (!$result->isOk()) {
            $actionDto->addErrorMessage('`' . self::COMMAND . '` command execution failed. Please run manually.');
            $actionDto->addErrorMessage($result->getErrorOutput());
        }
    }
}
