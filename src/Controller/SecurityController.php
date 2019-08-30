<?php

namespace App\Controller;

use App\Entity\Customer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class SecurityController extends AbstractFOSRestController
{
    /**
     * Login
     * @Rest\View()
     * @Rest\Get("/api/login")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Successfull authenticated"
     * )
     *
     * @SWG\Parameter(
     *  name="data",
     *  in="body",
     *  required=true,
     *  description="Required parameters for authentication",
     *  @SWG\Schema(
     *      type="object",
     *      @SWG\Property(property="username", type="string"),
     *      @SWG\Property(property="password", type="string")
     *    ),
     *  )
     * )
     *
     * @SWG\Tag(name="Login")
     */
    public function getLoginAction()
    {
        // $user = $this->getUser();

        // return $this->view([
        //     'email' => $user->getEmail(),
        //     'roles' => $user->getRoles()
        // ]);
    }
}