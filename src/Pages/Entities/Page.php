<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;
use Pages\Doctrine\Behaviours\Versioning;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class Page extends Base
{
    use Timestamps, Versioning;

    private $title;

    private $slug;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->addField('title', 'string');
        $builder->addField('slug', 'string');

        $builder->setCustomRepositoryClass('Pages\Repositories\PageRepository');

        $builder->setJoinedTableInheritance();
        $builder->setDiscriminatorColumn('type');
        $builder->addDiscriminatorMapClass('page', __CLASS__);
    }
}
