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
                                'offers' => array(
                                    'get offers' => array('url' => '/api/offers',
                                                          'method' => 'GET'),
                                    'get offer info' => array('url' => '/api/offers/{reference}',
                                                              'method' => 'POST')
                                ))));
        return new JsonResponse($response);
    }
}