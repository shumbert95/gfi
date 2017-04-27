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

class DefaultController extends Controller
{
    /**
     *
     * @param Request $request
     * @Rest\Get("/")
     */
    public function getDefaultAction(Request $request)
    {
        $response = array('services' =>
                            array(
                                'users' => array(
                                    'get user info' => array('url' => '/api/user?username={email}',
                                                             'method'  => 'GET'),
                                    'register' => array('url' => '/api/users/register',
                                                        'method' => 'POST',
                                                        'params' => array('email' => 'required (string)',
                                                                          'password' => 'required (string)',
                                                                          'first_name' => 'required (string)',
                                                                          'last_name' => 'required (string)',
                                                                          'phone' => 'required (string)')),
                                    'login' => array('url' => '/api/users/login',
                                                     'method' => 'POST',
                                                     'params' => array('email' => 'required (string)',
                                                                       'password' => 'required (string)')),
                                    'update skills' => array('url' => '/api/users/update_skills',
                                                             'method' => 'POST',
                                                             'params' => array('email' => 'required (string)',
                                                                               'tags' => 'required (array)')),
                                    'update infos' => array('url' => '/api/users/update',
                                                            'method' => 'POST',
                                                            'params' => array('email' => 'required (string)',
                                                                              'first_name' => 'optional (string)',
                                                                              'last_name' => 'optional (string)',
                                                                              'password' => 'optional (string)',
                                                                              'phone' => 'optional (string)',
                                                                              'poste' => 'optional (string)',
                                                                              'title' => 'optional (string)',
                                                                              'description' => 'optional (string)',
                                                                )),
                                'offers' => array(
                                    'get offers' => array('url' => '/api/offers',
                                                          'method' => 'GET'),
                                    'get offer info' => array('url' => '/api/offers/{reference}',
                                                              'method' => 'POST')
                                ),
                                'tags' => array(
                                    'get tags' => array('url' => '/api/tags',
                                                        'method' => 'GET')),
                                'quiz' => array(
                                    'get quizs' => array('url' => '/api/quizs',
                                                         'method' => 'GET'),
                                    'get quizs by offer' => array('url' => '/api/quizs/{offer_reference}',
                                                                  'method' => 'GET')),
                                'participation' => array(
                                    'participate' => array('url' => '/api/participate',
                                                           'method' => 'POST',
                                                           'params' => array('email' => 'required (string)',
                                                                             'offer_id' => 'required (int)',
                                                                             'note' => 'required (int)')))
                                )));
        return new JsonResponse($response);
    }
}