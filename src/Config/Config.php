<?php

namespace SprykerSdk\SprykerFeatureRemover\Config;

final class Config
{
    public const PROJECT_NAMESPACE = 'PROJECT_NAMESPACE';

    final public function getProjectNamespace(): string
    {

        $projectNamespace = (string)getenv(self::PROJECT_NAMESPACE);

        return $projectNamespace ?: 'Pyz';
    }
}
