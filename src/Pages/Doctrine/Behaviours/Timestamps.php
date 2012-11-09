<?php

namespace Pages\Doctrine\Behaviours;

/**
 * Adds basic behaviour for createdAt and updatedAt timestamps.
 */
trait Timestamps
{
    private $createdAt;

    private $updatedAt;
}