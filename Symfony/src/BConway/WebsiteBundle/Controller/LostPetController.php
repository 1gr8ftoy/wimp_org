<?php

namespace BConway\WebsiteBundle\Controller;

use BConway\WebsiteBundle\Entity\LostPet;
use BConway\WebsiteBundle\Form\Type\LostPetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

class LostPetController extends Controller
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
            ->add('searchPetHomeCity', 'text', array(
                'label' => 'City',
                'mapped'   => false
            ))
            ->add('searchPetHomeState', 'choice', array(
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
            ->setAction($this->generateUrl('b_conway_website_browse_lost_pets'))
            ->setMethod('get')
            ->getForm();

        $searchForm->handleRequest($request);

        $em = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BConwayWebsiteBundle:LostPet');

        $lostPets = $em->findPets($search_filters);

        return $this->render('BConwayWebsiteBundle:LostPet:browse.html.twig', array(
            'lostPets'   => $lostPets,
            'searchForm' => $searchForm->createView()
        ));
    }

    public function createAction(Request $request) {
        $lostPet = new LostPet();

        $form = $this->createForm(new LostPetType(), $lostPet);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();

            // Save entry to the DB
            $lostPet->setUser($this->getUser());
            $em->persist($lostPet);
            $em->flush();

            $session = $this
                ->getRequest()
                ->getSession();

            /* @var \BConway\WebsiteBundle\Service\ImageCacher */
            $imageCacher = $this->get('b_conway.website_bundle.image_cacher');

            // Handle attaching and moving uploaded or cached file
            $imageCacher->uploadPetImage(false, $lostPet);

            // Set message to user
            $session
                ->getFlashBag()
                ->add(
                    'notice',
                    'Post created successfully'
                );

            return $this->redirect($this->generateUrl('b_conway_website_lost_pet_view', array(
                'id' => $lostPet->getId(),
            )));
        } else {
            /* @var \BConway\WebsiteBundle\Service\ImageCacher */
            $imageCacher = $this->get('b_conway.website_bundle.image_cacher');

            if ($form->isSubmitted()) {
                // Handle attaching and moving uploaded or cached file
                $imageCacher->uploadPetImage(true, $lostPet);
            } else {
                // Form was not submitted.  If there is a previously cached image, delete it.
                $imageCacher->removeCachedImage($lostPet, true);
            }
        }

        return $this->render('BConwayWebsiteBundle:LostPet:create.html.twig', array(
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    public function editAction($id, Request $request)
    {
        // Get user's PHP session
        $session = $this
            ->getRequest()
            ->getSession();

        // Get the LostPet repository
        $em = $this->
            getDoctrine()
            ->getManager();

        $lostPet = $em
            ->getRepository('BConwayWebsiteBundle:LostPet')
            ->findOneById($id);

        $form = $this->createForm(new LostPetType(), $lostPet);
        $form->handleRequest($request);

        /**
         * Delete image if checkbox was checked
         */


        /* @var \BConway\WebsiteBundle\Service\ImageCacher */
        $imageCacher = $this->get('b_conway.website_bundle.image_cacher');

        if ($form->get('deletePetImage')->getData()) {
            // Delete file that was previously persisted for the post
            $imageCacher->deletePersistedImage($lostPet);

            // Delete any cached image and related data from the PHP session
            $imageCacher->removeCachedImage($lostPet, true);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // Set message to user
            $session
                ->getFlashBag()
                ->add('notice',
                    'Post updated successfully'
                );

            if (!$form->get('deletePetImage')->getData()) {
                // Handle attaching and moving uploaded or cached file
                $imageCacher->uploadPetImage(false, $lostPet);
            }

            // Save changes to the DB
            $em->flush();

            return $this->redirect($this->generateUrl('b_conway_website_lost_pet_view', array(
                'id' => $id,
            )));
        } else {
            if (!count($form->get('petImage')->getErrors())) {
                // No validation errors were found for file field, process uploaded/cached image

                if ($form->isSubmitted()) {
                    if (!$form->get('deletePetImage')->getData()) {
                        // Handle attaching and moving uploaded or cached file
                        $imageCacher->uploadPetImage(true, $lostPet);
                    }
                } else {
                    // Form was not submitted.  If there is a previously cached image, delete it.
                    $imageCacher->removeCachedImage($lostPet, true);
                }
            }
        }

        if ($lostPet && $lostPet->getId()) {
            return $this->render('BConwayWebsiteBundle:LostPet:edit.html.twig', array(
                'lostPet' => $lostPet,
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

            return $this->redirect($this->generateUrl('b_conway_website_browse_lost_pets'));
        }
    }

}
