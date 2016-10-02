<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="main_home")
     */
    public function indexAction(Request $request)
    {
        if( $this->container->get('security.authorization_checker')->isGranted('ROLE_USER') ){ 
             $actus = $this->getDoctrine()
                ->getRepository('SocialBundle:Actuality')
                ->findBy(['user' => $this->getUser()], ['date' => 'DESC'])
            ;
            //exit(var_dump($actus));

            $token = md5(uniqid());
            $session = $request->getSession();
            $session->set('token', $token);
            return $this->render('SocialBundle:Default:accueil.html.twig', [ 
                'actus' => $actus,
                'token' => $token
            ]); 
        } return $this->render('MainBundle:Default:index.html.twig');
    }
}
