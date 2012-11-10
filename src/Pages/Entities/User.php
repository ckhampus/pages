<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class User
{
    use Timestamps;

    private $id;

    /**
     * Get the user ID.
     *
     * @return integer The user ID.
     */
    public function getId()
    {
        return $this->id;
    }

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