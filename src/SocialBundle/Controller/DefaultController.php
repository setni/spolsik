<?php

namespace SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
     public function newAction(request $request)
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
     * @Method("POST")
     */
    public function youtubeAction (request $request)
    {
        return new JsonResponse(
            $this->get('social.Youtube')->search(
                $request->get('query')
            )
        );
    }
    /**
     * @Route("/comment")
     * @Method("POST")
     */
    public function commentAction(request $request)
    {       
        $session = $request->getSession();
        $tokenS = $session->get('token');
        $comment = $request->get('comment');
        $idActu = $request->get('idActu');
        $tokenF = $request->get('token');
        //exit($tokenF." / ".$tokenS);
        if($tokenS == $tokenF) {
            $em = $this->getDoctrine()->getManager();
            $actuality = $em->getRepository('SocialBundle:Actuality')->find($idActu);
            $sql = new Comment();
            $sql
                ->setText($comment)
                ->setActuality($actuality)
                ->setUser($this->getUser());
            $em->persist($sql);
            $em->flush();
            return new Response("true");
        } else {
            throw $this->createAccessDeniedException();
        }
    }
    /**
     * @Route("/testCanvas")
     * @Method("POST")
     */
    public function testCanvasAction (request $request)
    {
        $decoded = base64_decode(substr($request->get('imgBase64'),22));
        $fileName = 'users/test.png';
        $file = fopen($fileName, 'x');
        fwrite($file, $decoded);
        fclose($file);
        return new Response("true");
    }
}
