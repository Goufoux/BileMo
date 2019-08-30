<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\UserType;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class UserController extends ObjectManagerController
{
    /**
     * Get all users or specified user if id is in parameter
     * 
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("api/users")
     * @Rest\Get("api/users/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Ok",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"user"}))
     *     )
     * )
     * 
     * @SWG\Tag(name="User")
     */
    public function getUsersAction(User $user = null)
    {
        if (null === $user || $user->getCustomer() !== $this->getUser()) {
            
            $key = 'user.all';
            
            $onCache = $this->adapter->getItem($key);
            
            if (!$onCache->isHit()) {
                $users = $this->em->getRepository(User::class)->findBy(['customer' => $this->getUser()]);
            
                $data = $this->linkService->getObjectsLinks('users', $users, ['view']);

                $this->cache->saveItem($key, $data);
                
                return $data;
            }
            $data = $onCache->get();

            return $data;
        }

        $key = 'user.'.$user->getId();

        $onCache = $this->adapter->getItem($key);
            
        if (!$onCache->isHit()) {
            $data = $this->linkService->getObjectLinks('user', $user, ['all', 'remove']);

            $this->cache->saveItem($key, $data);
            
            return $data;
        }

        $data = $onCache->get();
        
        return $data;
    }

    /**
     * Create users
     *
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Post("api/users")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Ok",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"user"}))
     *     )
     * )
     *
     * @SWG\Response(
     *      response=400,
     *      description="Form is invalid"
     * )
     * 
     * @SWG\Tag(name="User")
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

            $user->setCustomer($this->getUser());

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
     * Remove an user
     *
     * @Rest\View()
     * @Rest\Delete("api/users/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Ok"
     * )
     * 
     * @SWG\Tag(name="User")
     */
    public function deleteUsersAction(User $user)
    {
        if ($user->getCustomer() !== $this->getUser()) {
            return $this->view([], Response::HTTP_NOT_FOUND);
        }
        $this->em->remove($user);
        $this->em->flush();

        return $this->view(['message' => 'Ok'], Response::HTTP_OK);
    }
}
