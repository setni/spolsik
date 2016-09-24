<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="main_home")
     */
    public function indexAction()
    {
        if( $this->container->get('security.authorization_checker')->isGranted('ROLE_USER') ){
            
             $actus = $this->getDoctrine()
                ->getRepository('SocialBundle:Actuality')
                ->findByUser($this->getUser())
            ;
            return $this->render('SocialBundle:Default:index.html.twig', array(
        
                'actus' => $actus,
            
            ));
            
        } return $this->render('MainBundle:Default:index.html.twig');
        
    }
}
