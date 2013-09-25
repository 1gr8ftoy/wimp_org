<?php
// src/BConway/WebsiteBundle/EventListener/ImageRemover.php
namespace BConway\WebsiteBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use BConway\WebsiteBundle\Entity\LostPet,
    BConway\WebsiteBundle\Entity\FoundPet;

class SearchIndexer
{
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof LostPet || $entity instanceof FoundPet) {
            $entity_type = '';

            if ($entity instanceof LostPet) {
                $entity_type = 'lost';
            } elseif ($entity instanceof FoundPet) {
                $entity_type = 'found';
            }


        }
    }
}