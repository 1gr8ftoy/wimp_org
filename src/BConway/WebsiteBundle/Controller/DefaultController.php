<?php

namespace BConway\WebsiteBundle\Controller;

use BConway\WebsiteBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function homepageAction()
    {
        return $this->render('BConwayWebsiteBundle:Default:homepage.html.twig');
    }

    public function browseAction()
    {
        return $this->render('BConwayWebsiteBundle:Default:browse.html.twig');
    }

    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());

        if ($this->container->get('kernel')->getEnvironment() != 'test') {
            $form->add('ayah', 'ayah');
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('[WhereIsMyPet.org] ' . $form->get('subject')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo('contact@whereismypet.org')
                    ->setBody(
                        $this->renderView(
                            'BConwayWebsiteBundle:Mail:contact.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'name' => $form->get('name')->getData(),
                                'message' => $form->get('message')->getData()
                            )
                        )
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Your message has been sent. If necessary, we will get back to you as soon as possible.');

                return $this->redirect($this->generateUrl('b_conway_website_contact_us'));
            }
        }

        return $this->render('BConwayWebsiteBundle:Default:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
