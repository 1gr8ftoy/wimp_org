<?php
// src/BConway/WebsiteBundle/Service/ImageCacher.php

namespace BConway\WebsiteBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageCacher
{
    const BCONWAY_IMAGE_CACHER_CACHED_FILE = 1;
    const BCONWAY_IMAGE_CACHER_UPLOADED_FILE = 2;
    const BCONWAY_IMAGE_CACHER_PERSISTED_FILE = 3;

    protected $container;

    protected $request;

    protected $kernel;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $this->container->get('request');
        $this->kernel = $this->container->get('kernel');
    }

    /**
     * @param $cacheImage boolean If the form validation failed, pass in true to cache the image and save the data to the session.
     * @param $pet \BConway\WebsiteBundle\Entity\LostPet or \BConway\WebsiteBundle\Entity\FoundPet
     */
    public function uploadPetImage($cacheImage, $pet)
    {
        /* @var array */
        $petClass = explode('\\', get_class($pet));
        $petClass = end($petClass);

        /* @var string */
        $postType = str_replace('pet', '', strtolower($petClass));

        /* @var Request */
        $request = $this->request;

        /* @var Session */
        $session = $request->getSession();

        /* @var UploadedFile */
        $uploadedFile = $request->files->get($postType . '_pet[petImage]', null, true);

        /* @var array */
        $cacheData = $session->get($postType . 'PetImage-cached-data', array());

        if (null !== $uploadedFile && $uploadedFile->isValid()) {
            // Upload is valid

            // Used to designate which file movement method to use
            $fileMode = self::BCONWAY_IMAGE_CACHER_UPLOADED_FILE;

            $session->remove($postType . 'PetImage-cached-data');
            $session->remove($postType . 'PetImage-cached');
        } elseif (
            $session->get($postType . 'PetImage-cached')
            && array_key_exists('saveType', $cacheData)
            && $cacheData['saveType'] !== 'persisted'
        ) {
            // No valid upload found, use cached file

            /* @var array */
            $cacheData = $session->get($postType . 'PetImage-cached-data', array());

            /* @var string */
            $tempFilePath = (array_key_exists('path', $cacheData)) ? $cacheData['path'] : null;

            /* @var string */
            $tempFileName = (array_key_exists('name', $cacheData)) ? $cacheData['name'] : null;

            /* @var integer */
            $tempFileSize = (array_key_exists('size', $cacheData)) ? $cacheData['size'] : null;

            /* @var string */
            $tempFileMimeType = (array_key_exists('mimeType', $cacheData)) ? $cacheData['mimeType'] : null;

            // If a valid image is already cached and needs to be cached again, leave it where it is and exit
            if ($cacheImage && file_exists($this->kernel->getRootDir() . '/../web' . $tempFilePath . $tempFileName)) {

                return;
            }

            /**
             * Create an UploadedFile object from the cached data.
             * This gives us access to the helper methods.
             *
             * @var UploadedFile
             */
            $uploadedFile = new UploadedFile($this->kernel->getRootDir() . '/../web' . $tempFilePath . $tempFileName, $tempFileName, $tempFileMimeType, $tempFileSize);

            // Used to designate which file movement method to use
            $fileMode = self::BCONWAY_IMAGE_CACHER_CACHED_FILE;
        } else {
            $changeset = array();

            if ($pet->getId()) {
                $changeset = $this->getChangedData($pet);
            }

            if (
                is_array($changeset)
                && array_key_exists('petImage', $changeset)
                && strlen($changeset['petImage'][0]) > 0
                && file_exists($this->kernel->getRootDir() . '/../web' . $changeset['petImage'][0])
            ) {

                // No image was uploaded and no cached image was found.  However, a valid image was
                // found in the database.  Load the file an UploadedFile object.

                // Used to designate which file movement method to use
                $fileMode = self::BCONWAY_IMAGE_CACHER_PERSISTED_FILE;

                $filePath = $this->kernel->getRootDir() . '/../web' . $changeset['petImage'][0];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $uploadedFile = new UploadedFile($filePath, pathinfo($filePath)['basename'], finfo_file($finfo, $filePath), filesize($filePath));
                finfo_close($finfo);

                /* @var integer */
                $pos = stripos($filePath, '/web');

                /* @var string */
                $filePath = substr($filePath, $pos+4);
                $pos = strrpos($filePath, '/');
                $filePath = substr($filePath, 0, $pos+1);

                /* @var array */
                $cacheData = array();

                /* @var string */
                $cacheData['path'] = $filePath;

                /* @var string */
                $cacheData['name'] = $uploadedFile->getClientOriginalName();

                /* @var integer */
                $cacheData['size'] = $uploadedFile->getClientSize();

                /* @var string */
                $cacheData['mimeType'] = $uploadedFile->getClientMimeType();

                /* @var string */
                $cacheData['saveType'] = 'persisted';

                $session->set($postType . 'PetImage-cached', $filePath . $uploadedFile->getClientOriginalName());
                $session->set($postType . 'PetImage-cached-data', $cacheData);
            } else {
                // Nothing useful found, exit function
                return;
            }
        }

        /* @var string */
        $fileExtension = $uploadedFile->guessExtension();
        $fileExtension = ($fileExtension === null || $fileExtension == 'jpeg') ? 'jpg' : $fileExtension;

        /* @var string */
        $unique_filename = \sha1(uniqid(mt_rand(), true)) . '.' . $fileExtension;

        // If we are caching the image, we want it to go to a temp folder,
        // otherwise we want it to be organized by entity and id.
        if ($cacheImage) {
            /* @var string */
            $newFilePath = $this->kernel->getRootDir() . '/../web/uploads/temp/';
        } elseif (!$cacheImage && $pet && is_numeric($pet->getId())) {
            /* @var string */
            $newFilePath = $this->kernel->getRootDir() . '/../web/uploads/' . $postType . '_pets/' . $pet->getId() . '/';
        } else {
            return;
        }

        // If the cached filename and the $uploadedFile filename are the same, we know that we are using the cached
        // image.  If this is not true, then the user has uploaded a new file instead of using the image that they
        // had previously cached.
        //
        // NOTE: I am really not sure why but when I try to use UploadedFile->move() on a manually created UploadedFile,
        //       it throws an unknown exception.  That is why we want to use rename if the file is cached.
        if (
            $fileMode === self::BCONWAY_IMAGE_CACHER_CACHED_FILE
            || (
                array_key_exists('name', $cacheData)
                && $cacheData['name'] !== $uploadedFile->getClientOriginalName()
            )
        ) {
            // If the target directory does not exist, create it and any required parent directories
            if (!file_exists($newFilePath)) {
                mkdir($newFilePath, 0777, true);
            }

            /* @var boolean */
            $moved_status = \rename($uploadedFile, $newFilePath . $unique_filename);
        } elseif ($fileMode === self::BCONWAY_IMAGE_CACHER_PERSISTED_FILE) {
            // Do nothing
            $moved_status = false;

        } else {
            /* @var boolean */
            $moved_status = $uploadedFile->move($newFilePath, $unique_filename);
        }

        if ($moved_status) {
            if ($cacheImage) {
                // Cache image and save it to the session

                // Delete any existing cached image
                $this->removeCachedImage($pet);

                /* @var integer */
                $pos = stripos($newFilePath, '/web');

                /* @var string */
                $newFilePath = substr($newFilePath, $pos+4);

                /* @var array */
                $cacheData = array();

                /* @var string */
                $cacheData['path'] = $newFilePath;

                /* @var string */
                $cacheData['name'] = $unique_filename;

                /* @var integer */
                $cacheData['size'] = $uploadedFile->getClientSize();

                /* @var string */
                $cacheData['mimeType'] = $uploadedFile->getClientMimeType();

                /* @var string */
                $cacheData['saveType'] = 'cached';

                $session->set($postType . 'PetImage-cached', $newFilePath . $unique_filename);
                $session->set($postType . 'PetImage-cached-data', $cacheData);
            } else {
                // Strip filesystem path from the image path

                /* @var integer */
                $pos = stripos($newFilePath, '/web');

                /* @var string */
                $newFilePath = substr($newFilePath, $pos+4);

                // We are not caching the image, so remove any leftover cached file and cache data from the session
                $this->removeCachedImage($pet, true);
            }
        }

        if (!$cacheImage) {
            /* @var \Doctrine\ORM\EntityManager */
            $em = $this
                ->container
                ->get('doctrine')
                ->getManager();

            // Update the entity
            if ($fileMode === self::BCONWAY_IMAGE_CACHER_PERSISTED_FILE) {
                $pet->setPetImage($cacheData['path'] . $cacheData['name']);
            } else {
                $pet->setPetImage($newFilePath . $unique_filename);
            }

            // If the file we are using for the image was previously persisted, we did not move anything.
            // If not, delete any remaining previously persisted image file.
            if ($fileMode !== self::BCONWAY_IMAGE_CACHER_PERSISTED_FILE) {
                // We need to manually delete the old one (if one exists)
                $this->deletePersistedImage($pet);
            }

            // Save the changes to the database
            $em->flush();
        }
    }

    /**
     * @param $pet \BConway\WebsiteBundle\Entity\LostPet or \BConway\WebsiteBundle\Entity\FoundPet
     * @param bool $clearSessionData Remove previously cached image data from session?
     */
    public function removeCachedImage($pet, $clearSessionData = false)
    {
        /*
         * Check if a previously cached file exists, but was not used after all.
         * If an existing file is found, remove it.
         */
        $session = $this->container->get('session');

        /* @var array */
        $petClass = explode('\\', get_class($pet));

        /* @var string */
        $postType = str_replace('pet', '', strtolower(end($petClass)));

        /* @var array */
        $cacheData = $this->container->get('session')->get($postType . 'PetImage-cached-data', array());

        /* @var string */
        $tempFilePath = (array_key_exists('path', $cacheData)) ? $cacheData['path'] : null;

        /* @var string */
        $tempFileName = (array_key_exists('name', $cacheData)) ? $cacheData['name'] : null;

        /* @var string */
        $previouslyCachedFile = $this->kernel->getRootDir() . '/../web' . $tempFilePath . $tempFileName;

        if (file_exists($previouslyCachedFile) && strpos($previouslyCachedFile, '/web/') && is_file($previouslyCachedFile)) {
            // Previously cached file exists, remove it.
            unlink($previouslyCachedFile);
        }

        if ($clearSessionData) {
            /**
             * Remove related session data.  If this is not done,
             * the user will see their cached image if they revisit
             * the form in the same session.
             */
            $session->remove($postType . 'PetImage-cached-data');
            $session->remove($postType . 'PetImage-cached');
        }
    }

    public function deletePersistedImage($pet)
    {
        $changeset = $this->getChangedData($pet);

        if (
            array_key_exists('petImage', $changeset)
            && strlen($changeset['petImage'][0]) > 0
            && file_exists($this->kernel->getRootDir() . '/../web' . $changeset['petImage'][0])
            && is_file($this->kernel->getRootDir() . '/../web' . $changeset['petImage'][0])
        ) {
            unlink($this->kernel->getRootDir() . '/../web' . $changeset['petImage'][0]);
        }
    }

    public function getChangedData($entity)
    {
        $em = $this->container->get('doctrine')->getManager();
        $uow = $em->getUnitOfWork();
        $uow->computeChangeSets();
        return $uow->getEntityChangeSet($entity);
    }
}