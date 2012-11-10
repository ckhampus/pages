<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;
use Pages\Doctrine\Behaviours\Versioning;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class Column extends Base
{
    use Timestamps, Versioning;

    private $layout;

    /**
     * Set layout
     *
     * @param \Pages\Entities\Layout $layout
     * @return Column
     */
    public function setLayout(\Pages\Entities\Layout $layout = null)
    {
        $this->layout = $layout;
    
        return $this;
    }

    /**
     * Get layout
     *
     * @return \Pages\Entities\Layout 
     */
    public function getLayout()
    {
        return $this->layout;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->createManyToOne('layout', 'Pages\Entities\Layout')
                ->inversedBy('columns')
                ->build();

        $builder->setCustomRepositoryClass('Pages\Repositories\ColumnRepository');
    }
}