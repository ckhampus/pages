<?php

namespace Pages\Entities;

use Pages\Database\Behaviour\Timestamps;
use Pages\Database\Behaviour\Versioning;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class Page
{
    use Timestamps, Versioning;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->createField('id', 'integer')
                ->isPrimaryKey()
                ->generatedValue()
                ->build();
    }
}