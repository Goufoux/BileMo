<?php

namespace App\Controller;

use App\Service\CacheService;
use App\Service\LinkService;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ObjectManagerController extends AbstractFOSRestController
{
    protected $em;
    protected $cache;
    protected $linkService;
    protected $adapter;

    public function __construct(ObjectManager $em, AdapterInterface $adapter, CacheService $cache, LinkService $linkService)
    {
        $this->em = $em;
        $this->cache = $cache;
        $this->linkService = $linkService;
        $this->adapter = $adapter;
    } 
}