<?php

namespace Pages\Doctrine\Behaviours;

/**
 * Adds basic behaviour for createdAt and updatedAt timestamps.
 */
trait Timestamps
{
    private $createdAt;

    private $updatedAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function updateTimestamps()
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime('now');
        }

        $this->updatedAt = new \DateTime('now');
    }
}
