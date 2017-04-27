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
                $tags = array();
                foreach ($offer->getRequiredSkills() as $tag) {
                    $tags['required_skills'] = array('id' => $tag->getId(),
                        'name' => $tag->getName(),
                    );
                }
                foreach ($offer->getOptionalSkills() as $tag) {
                    $tags['optional_skills'] = array('id' => $tag->getId(),
                        'name' => $tag->getName(),
                    );
                }
                $response['offers'][] = array(
                    'id' => $offer->getId(),
                    'reference' => $offer->getReference(),
                    'title' => $offer->getTitle(),
                    'description' => $offer->getDescription(),
                    'poste' => $offer->getPoste(),
                    'date' => $offer->getDate(),
                    'skills' => $tags,
                );
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
            $tags = array();
            foreach ($offer->getRequiredSkills() as $tag) {
                $tags['required_skills'] = array('id' => $tag->getId(),
                    'name' => $tag->getName(),
                );
            }
            foreach ($offer->getOptionalSkills() as $tag) {
                $tags['optional_skills'] = array('id' => $tag->getId(),
                    'name' => $tag->getName(),
                );
            }
            $response = array('success' => 'true', 'offer' => array(
                'id' => $offer->getId(),
                'reference' => $offer->getReference(),
                'title' => $offer->getTitle(),
                'description' => $offer->getDescription(),
                'poste' => $offer->getPoste(),
                'date' => $offer->getDate(),
                'skills' => $tags,
            ));

        } else {
            $response = array('success' => 'false', 'message' => 'No offer found.');
        }

        return new JsonResponse($response);

    }
}
