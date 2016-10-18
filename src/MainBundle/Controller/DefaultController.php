<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Form\LoginType;
use MainBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="main_home")
     */
    public function indexAction(Request $request)
    {
        if( $this->container->get('security.authorization_checker')->isGranted('ROLE_USER') ){ 
            $user = $this->getUser();
             $actus = $this->getDoctrine()
                ->getRepository('SocialBundle:Actuality')
                ->findBy(['user' => $user], ['date' => 'DESC'])  
            ;
            
            $usersList = (count($actus) === 0) ?
                $this->getDoctrine()->getManager()
                ->createQuery('
                    SELECT u FROM MainBundle:User u WHERE u.id NOT IN 
                        (SELECT v.idFollow FROM SocialBundle:Follow v WHERE v.user = :myUser) 
                    AND u.id != :myUserId
                    ')
                ->setParameters(['myUser' => $user, 'myUserId' => $user->getId()])
                ->getResult() 
            : null;
            
            $token = md5(uniqid());
            $request->getSession()->set('token', $token);
            return $this->render('SocialBundle:Default:accueil.html.twig', [ 
                'actus' => $actus,
                'token' => $token,
                'user' => $user,
                'usersList' => $usersList
            ]); 
        } return $this->render('MainBundle:Default:index.html.twig');
    }
}
