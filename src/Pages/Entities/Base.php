<?php

namespace Pages\Entities;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

/**
 * Base class for all entities.
 */
abstract class Base
{
    private $id;

    /**
     * Get the ID.
     *
     * @return integer The ID.
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

        $builder->setMappedSuperclass();
    }
}
