<?php

namespace Pages\Doctrine\Behaviours;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class VersioningListener implements EventSubscriber
{
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $metadata = $eventArgs->getClassMetadata();
        $builder = new ClassMetadataBuilder($metadata);

        if (null === $metadata->reflClass) {
            return;
        }

        if ($this->isEntitySupported($metadata)) {
            /*
            $builder->addField('createdAt', 'datetime');
            $builder->addField('updatedAt', 'datetime');
            
            if ($metadata->reflClass->hasMethod('updateTimestamps')) {
                $metadata->addLifecycleCallback('updateTimestamps', Events::prePersist);
                $metadata->addLifecycleCallback('updateTimestamps', Events::preUpdate);
            }
            */
        }
    }

    public function getSubscribedEvents()
    {
        return [Events::loadClassMetadata];
    }

    private function isEntitySupported(ClassMetadata $metadata)
    {
        $traitNames = $metadata->reflClass->getTraitNames();

        return in_array('Pages\Doctrine\Behaviours\Versioning', $traitNames);
    }
}