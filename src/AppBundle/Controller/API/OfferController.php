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
            ->findByReference($request->get('offer_reference'))[0];
        $formatted = array(
                        'id' => $offer->getId(),
                        'reference' => $offer->getReference(),
                        'title' => $offer->getTitle(),
                        'description' => $offer->getDescription(),
                        'poste' => $offer->getPoste(),
                    );

        $viewHandler = $this->get('fos_rest.view_handler');

        $view = View::create($formatted);
        $view->setFormat('json');

        return $viewHandler->handle($view);

    }

    /**
     * @Get("/offers")
     */
    public function getOffersAction(Request $request)
    {
        $offers = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Offer')
            ->findAll();

        $formatted = [];
        foreach ($offers as $offer) {
            $formatted[] = [
                'id' => $offer->getId(),
                'reference' => $offer->getReference(),
                'title' => $offer->getTitle(),
                'description' => $offer->getDescription(),
                'poste' => $offer->getPoste(),
            ];
        }

        $viewHandler = $this->get('fos_rest.view_handler');

        $view = View::create($formatted);
        $view->setFormat('json');

        return $viewHandler->handle($view);
    }
}
