<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;
use Pages\Doctrine\Behaviours\Versioning;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class Column extends Base
{
    use Timestamps, Versioning;

    private $layouts;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->createManyToMany('layouts', 'Pages\Entities\Layout')
                ->inversedBy('columns')
                ->build();

        $builder->setCustomRepositoryClass('Pages\Repositories\ColumnRepository');
    }
}