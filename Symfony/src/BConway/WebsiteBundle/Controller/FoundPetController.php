<?php

namespace BConway\WebsiteBundle\Controller;

use BConway\WebsiteBundle\Entity\FoundPet;
use BConway\WebsiteBundle\Form\Type\FoundPetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class FoundPetController extends Controller
{
    public function browseAction(Request $request)
    {
        $search_filters = array(
            'perpage' => 9
        );

        // Get all GET query parameters
        $query_params = $this->getRequest()->query->all();

        // Get form parameters, then remove the form key from array
        if (array_key_exists('form', $query_params) && is_array($query_params['form'])) {
            $search_filters = array_merge($query_params['form'], (array)$search_filters);

            unset($query_params['form']);
        }

        // Get the rest of the query parameters
        $search_filters = array_merge((array)$this->getRequest()->query->all(), (array)$search_filters);

        $searchForm = $this->createFormBuilder()
            ->add('searchPetType', 'choice', array(
                'choices' => array(
                    'All'   => 'All/Any',
                    'dog'   => 'Dog',
                    'cat'   => 'Cat',
                    'other' => 'Other'
                ),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'Pet Type',
                'mapped'   => false
            ))
            ->add('searchPetBreed', 'text', array(
                'label' => 'Breed',
                'mapped'   => false
            ))
            ->add('searchPetLocationFoundCity', 'text', array(
                'label' => 'City',
                'mapped'   => false
            ))
            ->add('searchPetLocationFoundState', 'choice', array(
                'choices' => array(
                    'All' => 'Any/All',
                    'AL'  => 'Alabama',
                    'AK'  => 'Alaska',
                    'AZ'  => 'Arizona',
                    'AR'  => 'Arkansas',
                    'CA'  => 'California',
                    'CO'  => 'Colorado',
                    'CT'  => 'Connecticut',
                    'DE'  => 'Delaware',
                    'DC'  => 'District Of Columbia',
                    'FL'  => 'Florida',
                    'GA'  => 'Georgia',
                    'HI'  => 'Hawaii',
                    'ID'  => 'Idaho',
                    'IL'  => 'Illinois',
                    'IN'  => 'Indiana',
                    'IA'  => 'Iowa',
                    'KS'  => 'Kansas',
                    'KY'  => 'Kentucky',
                    'LA'  => 'Louisiana',
                    'ME'  => 'Maine',
                    'MD'  => 'Maryland',
                    'MA'  => 'Massachusetts',
                    'MI'  => 'Michigan',
                    'MN'  => 'Minnesota',
                    'MS'  => 'Mississippi',
                    'MO'  => 'Missouri',
                    'MT'  => 'Montana',
                    'NE'  => 'Nebraska',
                    'NV'  => 'Nevada',
                    'NH'  => 'New Hampshire',
                    'NJ'  => 'New Jersey',
                    'NM'  => 'New Mexico',
                    'NY'  => 'New York',
                    'NC'  => 'North Carolina',
                    'ND'  => 'North Dakota',
                    'OH'  => 'Ohio',
                    'OK'  => 'Oklahoma',
                    'OR'  => 'Oregon',
                    'PA'  => 'Pennsylvania',
                    'RI'  => 'Rhode Island',
                    'SC'  => 'South Carolina',
                    'SD'  => 'South Dakota',
                    'TN'  => 'Tennessee',
                    'TX'  => 'Texas',
                    'UT'  => 'Utah',
                    'VT'  => 'Vermont',
                    'VA'  => 'Virginia',
                    'WA'  => 'Washington',
                    'WV'  => 'West Virginia',
                    'WI'  => 'Wisconsin',
                    'WY'  => 'Wyoming',
                ),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'State',
                'mapped'   => false
            ))
            ->add('searchStartDate', 'text', array(
                'attr'   => array('class' => 'hasDatePicker'),
                'label'  => 'From',
                'mapped' => false
            ))
            ->add('searchEndDate', 'text', array(
                'attr'   => array('class' => 'hasDatePicker'),
                'label'  => 'To',
                'mapped' => false
            ))
            ->add('Search', 'submit', array(
                'attr' => array('style' => 'visibility: hidden; height: 0px;')
            ))
            ->setAction($this->generateUrl('b_conway_website_browse_found_pets'))
            ->setMethod('get')
            ->getForm();

        $searchForm->handleRequest($request);

        $em = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BConwayWebsiteBundle:FoundPet');

        $foundPets = $em->findPets($search_filters);

        return $this->render('BConwayWebsiteBundle:FoundPet:browse.html.twig', array(
            'foundPets'   => $foundPets,
            'searchForm' => $searchForm->createView()
        ));
    }

    public function createAction(Request $request) {
        $foundPet = new FoundPet();

        $form = $this->createForm(new FoundPetType(), $foundPet);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();

            // Save entry to the DB
            $foundPet->setUser($this->getUser());
            $em->persist($foundPet);
            $em->flush();

            $session = $this
                ->getRequest()
                ->getSession();

            /* @var \BConway\WebsiteBundle\Service\ImageCacher */
            $imageCacher = $this->get('b_conway.website_bundle.image_cacher');

            // Handle attaching and moving uploaded or cached file
            $imageCacher->uploadPetImage(false, $foundPet);

            // Set message to user
            $session
                ->getFlashBag()
                ->add(
                    'notice',
                    'Post created successfully'
                );

            return $this->redirect($this->generateUrl('b_conway_website_found_pet_view', array(
                'id' => $foundPet->getId(),
            )));
        } else {
            if (!count($form->get('petImage')->getErrors())) {
                // No validation errors were found for file field, process uploaded/cached image

                /* @var \BConway\WebsiteBundle\Service\ImageCacher */
                $imageCacher = $this->get('b_conway.website_bundle.image_cacher');

                if ($form->isSubmitted()) {
                    // Handle attaching and moving uploaded or cached file
                    $imageCacher->uploadPetImage(true, $foundPet);
                } else {
                    // Form was not submitted.  If there is a previously cached image, delete it.
                    $imageCacher->removeCachedImage($foundPet, true);
                }
            }
        }

        return $this->render('BConwayWebsiteBundle:FoundPet:create.html.twig', array(
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    public function viewAction($id)
    {
        // Get the FoundPet repository
        $em = $this->
            getDoctrine()
            ->getManager()
            ->getRepository('BConwayWebsiteBundle:FoundPet');

        $foundPet = $em->findOneById($id);

        if ($foundPet && $foundPet->getId()) {
            return $this->render('BConwayWebsiteBundle:FoundPet:view.html.twig', array(
                'foundPet' => $foundPet,
            ));
        } else {
            // Get user's PHP session
            $session = $this
                ->getRequest()
                ->getSession();

            $session
                ->getFlashBag()
                ->add('notice',
                    'No post found with id #' . $id
                );

            return $this->redirect($this->generateUrl('b_conway_website_browse_found_pets'));
        }
    }

    public function editAction($id, Request $request)
    {
        // Get user's PHP session
        $session = $this
            ->getRequest()
            ->getSession();

        // Get the FoundPet repository
        $em = $this->
            getDoctrine()
            ->getManager();

        $foundPet = $em
            ->getRepository('BConwayWebsiteBundle:FoundPet')
            ->findOneById($id);

        $previousPetImage = $foundPet->getPetImage();

        $form = $this->createForm(new FoundPetType(), $foundPet);
        $form->handleRequest($request);

        /**
         * Delete image if checkbox was checked
         */

        /* @var \BConway\WebsiteBundle\Service\ImageCacher */
        $imageCacher = $this->get('b_conway.website_bundle.image_cacher');

        if ($form->get('deletePetImage')->getData()) {
            // Delete file that was previously persisted for the post
            $imageCacher->deletePersistedImage($foundPet);

            // Unset variable containing previous image path, if this is not done
            // the no-longer-valid value may be placed back in the db after deleting the image
            unset($previousPetImage);

            // Delete any cached image and related data from the PHP session
            $imageCacher->removeCachedImage($foundPet, true);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // Set message to user
            $session
                ->getFlashBag()
                ->add('notice',
                    'Post updated successfully'
                );

            if (!$form->get('deletePetImage')->getData()
                && !is_null($form->get('deletePetImage')->getData())) {
                // Handle attaching and moving uploaded or cached file
                $imageCacher->uploadPetImage(false, $foundPet);
            } elseif (isset($previousPetImage) && strlen($previousPetImage) > 0) {
                $foundPet->setPetImage($previousPetImage);
            }

            // Save changes to the DB
            $em->flush();

            return $this->redirect($this->generateUrl('b_conway_website_found_pet_view', array(
                'id' => $id,
            )));
        } else {
            if (!count($form->get('petImage')->getErrors())) {
                // No validation errors were found for file field, process uploaded/cached image

                if ($form->isSubmitted()) {
                    if (!$form->get('deletePetImage')->getData()) {
                        // Handle attaching and moving uploaded or cached file
                        $imageCacher->uploadPetImage(true, $foundPet);
                    }
                } else {
                    // Form was not submitted.  If there is a previously cached image, delete it.
                    $imageCacher->removeCachedImage($foundPet, true);
                }
            }
        }

        if ($foundPet && $foundPet->getId()) {
            return $this->render('BConwayWebsiteBundle:FoundPet:edit.html.twig', array(
                'foundPet' => $foundPet,
                'form'    => $form->createView(),
                'action'  => 'edit',
            ));
        } else {
            // Get user's PHP session
            $session = $this
                ->getRequest()
                ->getSession();

            $session
                ->getFlashBag()
                ->add('notice',
                    'No post found with id #' . $id
                );

            return $this->redirect($this->generateUrl('b_conway_website_browse_found_pets'));
        }
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $foundPet = $em->getRepository('BConwayWebsiteBundle:FoundPet')->findOneById($id);

        if ($foundPet) {
            if ($foundPet->getUser()->getId() === $this->getUser()->getId()) {
                $em->remove($foundPet);
                $em->flush();
                return $this->redirect($this->generateUrl('b_conway_website_browse_found_pets'));
            } else {
                throw new AccessDeniedHttpException();
            }
        } else {
            return $this->createNotFoundException('No post found with id #' . $id);
        }
    }
}
