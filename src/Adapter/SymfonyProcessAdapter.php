<?php

namespace SprykerSdk\SprykerFeatureRemover\Adapter;

use SprykerSdk\SprykerFeatureRemover\Dto\ProcessResult;
use Symfony\Component\Process\Process;

class SymfonyProcessAdapter
{
    public function run(string $command): ProcessResult
    {
        $process = new Process(explode(' ', $command));
        $process->run();

        return new ProcessResult(
            $process->getErrorOutput(),
            $process->isSuccessful(),
        );
    }
}
