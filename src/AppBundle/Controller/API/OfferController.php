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

class OfferController extends Controller
{
    /**
     * @param Request $request
     * @Get("/api/offers")
     */
    public function getOffersAction(Request $request)
    {
        $offers = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Offer')
            ->findAll();

        if (count($offers)) {
            $response = array();
            $response['success'] = 'true';
            foreach ($offers as $k => $offer) {
                $response['offers'][] = $offer->getInfosAsArray();
            }
        } else {
            $response = array('success' => 'false', 'message' => 'No offer found.');
        }

        return new JsonResponse($response);
    }

    /**
     *
     * @param Request $request
     * @Rest\Get("/offers/{reference}")
     */
    public function getOfferAction(Request $request)
    {
        $offer = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Offer')
            ->findOneByReference($request->get('reference'));
        if ($offer) {
            $response = array('success' => 'true', 'offer' => $offer->getInfosAsArray());

        } else {
            $response = array('success' => 'false', 'message' => 'No offer found.');
        }

        return new JsonResponse($response);

    }
}
