<?php

namespace AppBundle\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Offer;

class QuizController extends Controller
{
    /**
     * @Get("/quizs")
     */
    public function getQuizsAction(Request $request)
    {
        $quizs = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Quiz')
            ->findAll();

        if (count($quizs)) {
            $response = array();
            $response['success'] = 'true';
            foreach ($quizs as $quiz) {
                $response['quiz'][] = $quiz->getInfosAsArray();
            }
        } else {
            $response = array('success' => 'false', 'message' => 'No quiz found.');
        }

        return new JsonResponse($response);
    }

    /**
     * @Rest\Get("/quizs/{offer_reference}")
     */
    public function getQuizByOfferAction(Request $request)
    {
        $offer = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Offer')
            ->findOneByReference($request->get('offer_reference'));
        if ($offer) {
            foreach ($offer->getRequiredSkills() as $tag) {
                $q = $this->getDoctrine()->getRepository('AppBundle:Quiz')->findBy(array('tag' => $tag));
                if (count($q)) {
                    foreach ($q as $_quiz) {
                        $quizs[$tag->getName()][] = $_quiz;
                    }
                }

            }
            $response['success'] = 'true';
            foreach ($quizs as $tag => $_quizs) {
                foreach($_quizs as $quiz) {
                    $response['quiz'][] = $quiz->getInfosAsArray();
                }
            }

        } else {
            $response = array('success' => 'false', 'message' => 'No offer found.');
        }

        return new JsonResponse($response);

    }
}