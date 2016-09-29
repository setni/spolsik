<?php

namespace SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SocialBundle\Form\ActualityType;
use SocialBundle\Entity\Actuality;
use SocialBundle\Entity\Comment;
use Symfony\Component\Security\Csrf\CsrfToken;

class DefaultController extends Controller
{
    /**
     * @Route("/new")
     */
     public function newAction(request $request)
     {
        $youtube = $this->get('social.Youtube');
        var_dump($youtube->search('test'));
         
        $user = $this->getUser();
        $new = new Actuality();
        $form = $this->createForm(ActualityType::class, $new);
        $form->handleRequest($request);
        $error = false;
        if ($form->isSubmitted()) {
        
            if(!$form->isValid()) {
                $error = true;
            } else {
                $task = $form->getData()->setUser($user);
                $em = $this->getDoctrine()->getManager();
                try {
                    $em->persist($task);
                    $em->flush();
                    return new RedirectResponse('/');
                } catch (Exception $e) {
                    return new Response("Une erreur ".$e->getMessage()." est survenue");
                }
            }   
        } 
        return $this->render('SocialBundle:Default:new.html.twig', array(
            'error' => $error,
            'form' => $form->createView(),
        ));
        

        
    }
}
