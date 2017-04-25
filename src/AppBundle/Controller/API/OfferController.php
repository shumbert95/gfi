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
     *
     * @param Request $request
     * @Rest\Get("/offers/{offer_reference}")
     */
    public function getOfferAction(Request $request)
    {
        $offer = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Offer')
            ->findOneByReference($request->get('offer_reference'));
        if ($offer) {
            $response = array('Success' => 'true', 'Offer' => array(
                'id' => $offer->getId(),
                'reference' => $offer->getReference(),
                'title' => $offer->getTitle(),
                'description' => $offer->getDescription(),
                'poste' => $offer->getPoste(),
            ));

        } else {
            $response = array('Success' => 'false', 'Message' => 'No offer found.');
        }

        return new JsonResponse($response);

    }

    /**
     * @Get("/offers")
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
                $response['offers'][] = array(
                    'id' => $offer->getId(),
                    'reference' => $offer->getReference(),
                    'title' => $offer->getTitle(),
                    'description' => $offer->getDescription(),
                    'poste' => $offer->getPoste(),
                );
            }
        } else {
            $response = array('success' => 'false', 'message' => 'No offer found.');
        }

        return new JsonResponse($response);
    }
}
