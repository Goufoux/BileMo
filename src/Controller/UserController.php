<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\UserType;

class UserController extends ObjectManagerController
{
    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users")
     * @Rest\Get("/users/{id}")
     */
    public function getUsersAction(User $user = null)
    {
        if (null === $user) {
            $users = $this->em->getRepository(User::class)->findAll();

            $data = [];

            foreach ($users as $user) {
                $data[] = [
                    'user' => $user,
                    'link' => [
                        'remove' => "/users/{$user->getId()}"
                    ]
                ];
            }

            return $data;
        }

        $data = [
            'user' => $user,
            'link' => [
                'remove' => "/users/{$user->getId()}"
            ]
        ];

        return $data;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Post("/users")
     */
    public function postUsersAction(Request $request)
    {
        $data = $request->request->all();

        foreach ($data as $value) {
            $user = new User();

            $form = $this->createForm(UserType::class, $user);

            $form->submit($value);

            if (false === $form->isValid()) {
                return $this->view($form, Response::HTTP_BAD_REQUEST);
            }

            $this->em->persist($user);
        }

        $this->em->flush();

        $data = [
            'link' => [
                'view' => "/users/{$user->getId()}",
                'remove' => "/users/{$user->getId()}"
            ]
        ];

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @Rest\View()
     * @Rest\Delete("/users/{id}")
     */
    public function deleteUsersAction(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();

        return $this->view(['message' => 'Ok'], Response::HTTP_OK);
    }
}
