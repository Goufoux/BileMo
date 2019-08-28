<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Cache\Adapter\DoctrineAdapter;
use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Cache\SQLite3Cache;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\ItemInterface;

class ProductController extends ObjectManagerController
{
    /**
     * @Rest\View(serializerGroups={"product"})
     * @Rest\Get("/api/products")
     * @Rest\Get("/api/products/{id}")
     * 
     * @SWG\Response(
     *     response=200,
     *     description="Get all products or specified product if id is in parameter",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Product::class, groups={"product"}))
     *     )
     * )
     * 
     * @SWG\Tag(name="Produit")
     */
    public function getProductsAction(Product $product = null)
    {
        if (null === $product || $product->getCustomer() !== $this->getUser()) {
        
            $key = 'products.all';
            
            $onCache = $this->cache->getItem($key);
            
            if (!$onCache->isHit()) {
                $data = [];
                
                $products = $this->em->getRepository(Product::class)->findBy(['customer' => $this->getUser()]);
                
                foreach ($products as $product) {
                    $data[] = [
                        'product' => $product,
                        'link' => [
                            'view' => "api/products/{$product->getId()}"
                        ]
                    ];
                }
                
                $item = $this->cache->getItem($key);
                $item->expiresAfter(3600);
                $item->set($data);
                $this->cache->save($item);
                
                return $data;
            }
            $data = $onCache->get();

            return $data;
        }

        // $key = 'product.'.$product->getId();

        // $onCache = $this->cache->getItem($key);
            
        // if (!$onCache->isHit()) {
            $data = [];
            
            $data = [
                'product' => $product,
                'link' => [
                    'remove' => "api/products/{$product->getId()}",
                    'all' => "api/products"
                ]
            ];
            
            // $item = $this->cache->getItem($key);
            // $item->expiresAfter(3600);
            // $item->set($data);
            // $this->cache->save($item);
            
            return $data;
        // }
        // $data = $onCache->get();

        // return $data;
    }
}
