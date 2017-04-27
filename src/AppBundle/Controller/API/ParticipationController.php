<?php

namespace AppBundle\Controller\API;

use AppBundle\Entity\Participation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Offer;

class ParticipationController extends Controller
{
    /**
     * @Post("/participate")
     */
    public function participateAction(Request $request)
    {
        $content = json_decode($request->getContent());

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('email' => $content->email));
        $quiz = $this->getDoctrine()->getRepository('AppBundle:Quiz')->find($content->quiz_id);
        if (!$user) {
            $response = array('success' => 'false', 'message' => 'No account found for this email.');
        } elseif (!$quiz) {
            $response = array('success' => 'false', 'message' => 'No quiz found.');
        } else {
            $em = $this->getDoctrine()->getManager();
            $participation = new Participation();
            $participation->setDate(new \DateTime());
            $participation->setNote($content->note);
            $participation->setQuiz($quiz);
            $participation->setUser($user);
            $em->persist($participation);
            $em->flush();
            $response = array('success' => 'true', 'message' => 'Participation saved.', 'participation' => $participation->getInfosAsArray());
        }

        return new JsonResponse($response);
    }
}