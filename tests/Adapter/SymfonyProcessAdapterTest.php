<?php

namespace SprykerSdkTests\Adapter;

use SprykerSdk\SprykerFeatureRemover\Adapter\SymfonyProcessAdapter;
use PHPUnit\Framework\TestCase;

class SymfonyProcessAdapterTest extends TestCase
{
    public function testRunReturnsSuccessfulResultIfCommandExecutable(): void
    {
        $command = 'ls';

        $processAdapter = new SymfonyProcessAdapter();
        $result = $processAdapter->run($command);

        $this->assertTrue($result->isOk());
        $this->assertSame('', $result->getErrorOutput());
    }

    public function testRunReturnsFailedResultIfCommandIsNotExecutable()
    {
        $command = 'not_existing_command';

        $processAdapter = new SymfonyProcessAdapter();
        $result = $processAdapter->run($command);

        $this->assertFalse($result->isOk());
        $this->assertSame('sh: exec: line 0: not_existing_command: not found', $result->getErrorOutput());
    }
}
