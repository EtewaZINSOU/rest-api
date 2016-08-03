<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Rest\view()
     * @Rest\Get("/users")
     * @param Request $request
     * @return \AppBundle\Entity\User[]
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->getDoctrine()
                      ->getRepository("AppBundle:User")
                      ->findAll();

        /** @var  $users User[] */

        return $users;

    }


    /**
     * @Rest\view()
     * @Rest\Get("/users/{id}")
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserAction(Request $request)
    {
        $user_one = $this->getDoctrine()
            ->getRepository("AppBundle:User")
            ->find($request->get('id'));


        if(!$user_one instanceof User){
            return new JsonResponse(['message' =>'User ' . $request->get('id').' not found'], Response::HTTP_NOT_FOUND);
        }

        /** @var  $users User[] */

        return $user_one;

    }

}