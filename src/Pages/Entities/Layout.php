<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;
use Pages\Doctrine\Behaviours\Versioning;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class Layout extends Base
{
    use Timestamps, Versioning;

    private $columns;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->columns = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add columns
     *
     * @param \Pages\Entities\Column $columns
     * @return Layout
     */
    public function addColumn(\Pages\Entities\Column $columns)
    {
        $this->columns[] = $columns;
    
        return $this;
    }

    /**
     * Remove columns
     *
     * @param \Pages\Entities\Column $columns
     */
    public function removeColumn(\Pages\Entities\Column $columns)
    {
        $this->columns->removeElement($columns);
    }

    /**
     * Get columns
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getColumns()
    {
        return $this->columns;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->createOneToMany('columns', 'Pages\Entities\Column')
                ->mappedBy('layout')
                ->build();

        $builder->setCustomRepositoryClass('Pages\Repositories\LayoutRepository');
    }
}