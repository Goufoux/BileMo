<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class IndexController extends AbstractFOSRestController
{
    /**
     * @Rest\View()
     * @Rest\Get("/")
     */
    public function index()
    {
        return $this->view(['message' => 'Hello World !']);
    }
}
