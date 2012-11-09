<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class User
{
    use Timestamps;

    private $id;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->createField('id', 'integer')
                ->isPrimaryKey()
                ->generatedValue()
                ->build();

        $builder->setCustomRepositoryClass('Pages\Repositories\UserRepository');
    }
}