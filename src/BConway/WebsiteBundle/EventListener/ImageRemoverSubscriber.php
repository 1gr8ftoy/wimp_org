<?php
// src/Acme/SearchBundle/EventListener/SearchIndexerSubscriber.php
namespace BConway\WebsiteBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use BConway\WebsiteBundle\Entity\LostPet,
    BConway\WebsiteBundle\Entity\FoundPet;
use Doctrine\ORM\Events;

class ImageRemoverSubscriber implements EventSubscriber
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::preRemove,
            Events::preUpdate,
        );
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof LostPet || $entity instanceof FoundPet) {
            if ($entity instanceof LostPet) {
                $db_entity = $entityManager->getRepository('BConwayWebsiteBundle:LostPet')->findOneById($entity->getId());
            } elseif ($entity instanceof FoundPet) {
                $db_entity = $entityManager->getRepository('BConwayWebsiteBundle:FoundPet')->findOneById($entity->getId());
            }

            if ($db_entity->getPetImage() && strlen($db_entity->getPetImage()) && $db_entity->getPetImage() != $entity->getPetImage()) {
                if (file_exists($this->container->get('kernel')->getRootDir() . '/../web' . $entity->getPetImage())
                    && is_file($this->container->get('kernel')->getRootDir() . '/../web' . $entity->getPetImage())) {
                    // Remove cached versions
                    $liipCacheManager = $this->container->get('liip_imagine.cache.manager');
                    $liipCacheManager->remove($entity->getPetImage(), 'thumbnail');
                    $liipCacheManager->remove($entity->getPetImage(), 'medium');
                    $liipCacheManager->remove($entity->getPetImage(), 'large');

                    // Remove original file
                    unlink($this->container->get('kernel')->getRootDir() . '/../web' . $entity->getPetImage());
                }
            }
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $this->deletePetImage($args);
    }

    /**
     * Remove petImage from filesystem and db
     */
    public function deletePetImage(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($this->get('kernel')->getEnvironment() != 'test' && ($entity instanceof LostPet || $entity instanceof FoundPet)) {
            if ($entity->getPetImage() && strlen($entity->getPetImage()) > 0) {
                $dir = dirname($this->container->get('kernel')->getRootDir() . '/../web' . $entity->getPetImage());

                if (file_exists($dir) and is_dir($dir)) {
                    $liipCacheManager = $this->container->get('liip_imagine.cache.manager');
                    $liipCacheManager->remove($entity->getPetImage(), 'thumbnail');
                    $liipCacheManager->remove($entity->getPetImage(), 'medium');
                    $liipCacheManager->remove($entity->getPetImage(), 'large');

                    $it = new \RecursiveDirectoryIterator($dir);
                    $files = new \RecursiveIteratorIterator($it,
                        \RecursiveIteratorIterator::CHILD_FIRST);
                    foreach($files as $file) {
                        if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                            continue;
                        }
                        if ($file->isDir()){
                            rmdir($file->getRealPath());
                        } else {
                            chmod($file->getRealPath(), 0777);
                            unlink($file->getRealPath());
                        }
                    }
                    rmdir($dir);

                    $entity->setPetImage(null);
                }
            }
        }
    }
}