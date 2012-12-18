<?php

namespace Pages\Entities;

use Pages\Doctrine\Behaviours\Timestamps;
use Pages\Doctrine\Behaviours\Versioning;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class DynamicPage extends Page
{
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->addDiscriminatorMapClass('dynamic', __CLASS__);
    }
}
