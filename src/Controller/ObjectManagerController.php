<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class ObjectManagerController extends AbstractFOSRestController
{
    protected $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    } 
}