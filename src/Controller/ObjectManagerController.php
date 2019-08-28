<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ObjectManagerController extends AbstractFOSRestController
{
    protected $em;
    protected $cache;

    public function __construct(ObjectManager $em, AdapterInterface $adapterInterface)
    {
        $this->em = $em;
        $this->cache = $adapterInterface;
    } 
}