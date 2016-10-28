<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Form\LoginType;
use MainBundle\Entity\User;

class MainController extends Controller
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

            $usersList = (count($actus) === 0) ? $this->get('app.userList')->getUserList($user) : null;
            $token = md5(uniqid());
            $request->getSession()->set('token', $token);
            return $this->render('SocialBundle:Default:accueil.html.twig', [
                'actus' => $actus,
                'token' => $token,
                'user' => $user,
                'usersList' => $usersList,
            ]);
        } else { return $this->render('MainBundle:Default:index.html.twig');}
    }
}
