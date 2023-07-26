<?php

namespace SprykerSdk\SprykerFeatureRemover\Dto;

class ProcessResult
{
    /**
     * @param string $errorOutput
     * @param bool $isOk
     */
    public function __construct(private string $errorOutput, private bool $isOk = true)
    {
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->isOk;
    }

    /**
     * @return string
     */
    public function getErrorOutput(): string
    {
        return $this->errorOutput;
    }
}
