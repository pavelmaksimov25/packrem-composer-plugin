<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Dto;

class PackageInputValidationResult
{
    private bool $isOk = true;

    private string $message = '';

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->isOk;
    }

    /**
     * @param bool $isOk
     *
     * @return void
     */
    public function setIsOk(bool $isOk): void
    {
        $this->isOk = $isOk;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
