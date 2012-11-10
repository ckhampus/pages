<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;
use Pages\Doctrine\Behaviours\Versioning;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class Page
{
    use Timestamps, Versioning;

    private $id;

    /**
     * Get the page ID.
     *
     * @return integer The page ID.
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

        $builder->setCustomRepositoryClass('Pages\Repositories\PageRepository');
    }
}