<?php

namespace BConway\WebsiteBundle\Controller;

use BConway\WebsiteBundle\Form\Type\DeleteAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function deleteAction(Request $request)
    {
        $form = $this->createForm(new DeleteAccountType());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $this->get('fos_user.user_manager')->deleteUser($user);

            $request->getSession()->invalidate();

            $session = $this->getRequest()->getSession();

            $session
                ->getFlashBag()
                ->add('notice',
                    'Your account has been deleted successfully'
                );

            return $this->redirect($this->generateUrl('b_conway_website_homepage'));
        }

        return $this->render('BConwayWebsiteBundle:User:delete_account.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function postsAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $lostPets = $em->getRepository('BConwayWebsiteBundle:LostPet')->findByUser($user);
        $foundPets = $em->getRepository('BConwayWebsiteBundle:FoundPet')->findByUser($user);
        return $this->render('BConwayWebsiteBundle:User:edit_posts.html.twig', array(
            'lostPets' => $lostPets,
            'foundPets' => $foundPets,
        ));
    }
}
