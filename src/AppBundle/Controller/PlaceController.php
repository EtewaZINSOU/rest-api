<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Response;


class PlaceController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/places")
     * @param Request $request
     * @return \AppBundle\Entity\Place[]|array
     */
    public function getPlacesAction(Request $request)
    {
        $places = $this->getDoctrine()
            ->getRepository('AppBundle:Place')
            ->findAll();

        /* @var $places Place[] */
        return $places;
    }


    /**
     * @Rest\View
     * @Rest\Get("/places/{id}")
     * @param Request $request
     * @return JsonResponse
     */
    public function getPlaceAction(Request $request)
    {
        $place = $this->getDoctrine()
            ->getRepository('AppBundle:Place')
            ->find($request->get('id'));

        /* @var $places Place[] */

        if(!$place instanceof Place){
            return new JsonResponse(["message" => " Place ".$request->get('id')." not found "], Response::HTTP_NOT_FOUND);
        }

        return $place;
    }
}