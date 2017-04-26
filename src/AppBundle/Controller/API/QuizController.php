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
                foreach ($quiz->getQuestions() as $question) {
                    $questions[] = array('id' => $question->getId(),
                                         'title' => $question->getTitle(),
                                         'answer_one' => $question->getAnswerOne(),
                                         'answer_two' => $question->getAnswerTwo(),
                                         'answer_three' => $question->getAnswerThree(),
                                         'answer_four' => $question->getAnswerFour(),
                                         'good_answer' => $question->getGoodAnswer(),
                                         'points' => $question->getPoints(),
                                         'time' => $question->getTime(),
                                        );
                }
                $response['Quiz'][] = array(
                    'id' => $quiz->getId(),
                    'name' => $quiz->getTitle(),
                    'questions' => $questions,
                );
            }
        } else {
            $response = array('success' => 'false', 'message' => 'No quiz found.');
        }

        return new JsonResponse($response);
    }

    /**
     * @Get("/quiz/{offer_reference}")
     */
    public function getQuizByOfferAction(Request $request)
    {
        $offer = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Offer')
            ->findOneByReference($request->get('offer_reference'));
        if ($offer) {
            $quizs = $offer->getQuizs();
            $response['success'] = 'true';
            foreach ($quizs as $quiz) {
                foreach ($quiz->getQuestions() as $question) {
                    $questions[] = array('id' => $question->getId(),
                        'title' => $question->getTitle(),
                        'answer_one' => $question->getAnswerOne(),
                        'answer_two' => $question->getAnswerTwo(),
                        'answer_three' => $question->getAnswerThree(),
                        'answer_four' => $question->getAnswerFour(),
                        'good_answer' => $question->getGoodAnswer(),
                        'points' => $question->getPoints(),
                        'time' => $question->getTime(),
                    );
                }
                $response['quiz'][] = array(
                    'id' => $quiz->getId(),
                    'name' => $quiz->getTitle(),
                    'questions' => isset($questions) ? $questions : '',
                );
            }

        } else {
            $response = array('success' => 'false', 'message' => 'No offer found.');
        }

        return new JsonResponse($response);

    }
}