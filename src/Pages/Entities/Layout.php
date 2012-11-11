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

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->createManyToMany('columns', 'Pages\Entities\Column')
                ->mappedBy('layouts')
                ->build();

        $builder->setCustomRepositoryClass('Pages\Repositories\LayoutRepository');
    }
}