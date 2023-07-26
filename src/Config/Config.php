<?php

namespace SprykerSdk\SprykerFeatureRemover\Config;

final class Config
{
    public const KEY_PROJECT_NAMESPACE = 'project_namespace';

    public const PROJECT_NAMESPACE_DEFAULT = 'Pyz';

    public function __construct(private string $projectNamespace)
    {
    }

    /**
     * @return string
     */
    public function getProjectNamespace(): string
    {
        return $this->projectNamespace ?? self::PROJECT_NAMESPACE_DEFAULT;
    }
}
