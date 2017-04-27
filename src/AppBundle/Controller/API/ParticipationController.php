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
        $offer = $this->getDoctrine()->getRepository('AppBundle:Offer')->find($content->offer_id);
        if (!$user) {
            $response = array('success' => 'false', 'message' => 'No account found for this email.');
        } elseif (!$offer) {
            $response = array('success' => 'false', 'message' => 'No offer found.');
        } else {
            $em = $this->getDoctrine()->getManager();
            $participation = new Participation();
            $participation->setDate(new \DateTime());
            $participation->setNote($content->note);
            $participation->setOffer($offer);
            $participation->setUser($user);
            $em->persist($participation);
            $em->flush();
            $_participation = array('id' => $participation->getId(),
                                    'offer_id' => $participation->getOffer()->getId(),
                                    'offer_title' => $participation->getOffer()->getTitle(),
                                    'note' => $participation->getNote(),
                                    'date' => $participation->getDate(),
                                    'user_id' => $participation->getUser()->getId());
            $response = array('success' => 'true', 'message' => 'Participation saved.', 'participation' => $_participation);
        }

        return new JsonResponse($response);
    }
}