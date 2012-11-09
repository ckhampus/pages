<?php

namespace Pages\Doctrine\Behaviours;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class TimestampsListener implements EventSubscriber
{
    public $preFooInvoked = false;

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $metadata = $eventArgs->getClassMetadata();
        $builder = new ClassMetadataBuilder($metadata);

        if (null === $metadata->reflClass) {
            return;
        }

        if ($this->isEntitySupported($metadata)) {
            $builder->addField('createdAt', 'datetime');
            $builder->addField('updatedAt', 'datetime');
            /*if ($classMetadata->reflClass->hasMethod('updateTimestamps')) {
                $classMetadata->addLifecycleCallback('updateTimestamps', Events::prePersist);
                $classMetadata->addLifecycleCallback('updateTimestamps', Events::preUpdate);
            }*/
        }
    }

    public function getSubscribedEvents()
    {
        return [Events::loadClassMetadata];
    }

    private function isEntitySupported(ClassMetadata $metadata)
    {
        $traitNames = $metadata->reflClass->getTraitNames();

        return in_array('Pages\Doctrine\Behaviours\Timestamps', $traitNames);
    }
}