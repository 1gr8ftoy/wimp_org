<?php

namespace BConway\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function homepageAction()
    {
        return $this->render('BConwayWebsiteBundle:Default:homepage.html.twig');
    }
    }
}
