<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class User extends Base
{
    use Timestamps;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setCustomRepositoryClass('Pages\Repositories\UserRepository');
    }
}