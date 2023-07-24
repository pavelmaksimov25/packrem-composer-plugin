<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Dto;

class ActionDto
{
    private string $moduleName = '';

    /**
     * @var array<string>
     */
    private array $errorMessages = [];

    public function getModuleName(): string
    {
        return $this->moduleName;
    }

    /**
     * @return void
     */
    public function setModuleName(string $moduleName): void
    {
        $this->moduleName = $moduleName;
    }

    /**
     * @return string[]
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
