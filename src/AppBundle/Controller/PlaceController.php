<?php
namespace AppBundle\Controller;

use AppBundle\Form\PlaceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Place;


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
     * @param Place $place
     * @return JsonResponse
     */
    public function getPlaceAction(Request $request,Place $place)
    {
        $place_one = $this->getDoctrine()
            ->getRepository('AppBundle:Place')
            ->find($place);

        /* @var $places Place[] */

        if(!$place_one instanceof Place){
            return new JsonResponse(["message" => " Place ".$request->get('id')." not found "], Response::HTTP_NOT_FOUND);
        }

        return $place_one;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/places")
     * @param Request $request
     * @return Place
     */
    public function postPlacesAction(Request $request)
    {
        $place = new Place();


        $form = $this->createForm(PlaceType::class, $place);

        $form->handleRequest($request);

        //$form->submit($request->request->all()); // Validation des données

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();
            return $place;
        }else{
            return$form;
        }

    }
}