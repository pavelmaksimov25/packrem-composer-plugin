<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Dto;

class ActionDto
{
    /**
     * @var array<string>
     */
    private array $moduleNames = [];

    /**
     * @var array<string>
     */
    private array $errorMessages = [];

    /**
     * @return array<string>
     */
    public function getModuleNames(): array
    {
        return array_unique($this->moduleNames);
    }

    /**
     * @param array<string> $moduleNames
     *
     * @return void
     */
    public function setModuleNames(array $moduleNames): void
    {
        $this->moduleNames = $moduleNames;
    }

    public function addModuleName(string $moduleName): void
    {
        $this->moduleNames[] = $moduleName;
    }

    /**
     * @return array<string>
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @return void
     */
    public function addErrorMessage(string $errorMessage): void
    {
        $this->errorMessages[] = $errorMessage;
    }
}
