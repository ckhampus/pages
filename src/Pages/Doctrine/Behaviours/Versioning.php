<?php

namespace Pages\Doctrine\Behaviours;

/**
 * Add simple versioning support.
 */
trait Versioning
{
    /**
     * Get the previous version.
     * @return object The previous version.
     */
    public function getPreviousVersion()
    {

    }

    /**
     * Restore this object and make it HEAD.
     */
    public function restore()
    {

    }
}