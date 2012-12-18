<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;
use Pages\Doctrine\Behaviours\Versioning;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class ListPage extends DynamicPage
{
    private $entity;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->addField('entity', 'string');

        $builder->addDiscriminatorMapClass('list', __CLASS__);
    }
}
