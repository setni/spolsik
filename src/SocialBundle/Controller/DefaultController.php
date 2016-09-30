<?php

namespace SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     public function newAction()
     { 
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
        return $this->render(
            'SocialBundle:Default:new.html.twig',
            ['error' => $error, 'form' => $form->createView()]
        );
    }
    /**
     * @Route("/youtube")
     */
    public function youtubeAction (request $request)
    {
        $youtube = $this->get('social.Youtube')->search($request->get('artiste')." ".$request->get('titre'));
        return new JsonResponse(['result' => $youtube]);
    }
}
