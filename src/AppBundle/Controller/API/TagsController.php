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

class TagsController extends Controller
{
    /**
     * @Get("/tags")
     */
    public function getOffersAction(Request $request)
    {
        $tags = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Tags')
            ->findAll();

        if (count($tags)) {
            $response = array();
            $response['success'] = 'true';
            foreach ($tags as $tag) {
                $response['tags'][] = array(
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                );
            }
        } else {
            $response = array('success' => 'false', 'message' => 'No tags found.');
        }

        return new JsonResponse($response);
    }
}