<?php

namespace SprykerSdk\SprykerFeatureRemover\Factory;

use Symfony\Component\Finder\Finder;

class SymfonyFinderFactory
{
    public function createFinder(): Finder
    {
        return new Finder();
    }
}