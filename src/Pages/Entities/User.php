<?php

namespace Pages\Entities;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class User
{
    use Timestamps;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->createField('id', 'integer')
                ->isPrimaryKey()
                ->generatedValue()
                ->build();
    }
}