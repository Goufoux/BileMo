<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class SecurityController extends AbstractFOSRestController
{
    /**
     * @Rest\View()
     * @Rest\Get("/api/login")
     */
    public function getLoginAction()
    {
        $user = $this->getUser();

        return $this->view([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles()
        ]);
    }
}