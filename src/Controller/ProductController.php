<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

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
    public function getProductsAction($id = null)
    {
        if (null === $id) {
            
            $key = 'products.all';
            
            $onCache = $this->adapter->getItem($key);
            
            if (true === $onCache->isHit()) {
                $data = $onCache->get();
    
                return $data;
            }

            $data = [];
                
            $products = $this->em->getRepository(Product::class)->findBy(['customer' => $this->getUser()]);

            $data = $this->linkService->getObjectsLinks('products', $products, ['view']);
            
            $this->cache->saveItem($key, $data);
            
            return $data;
        }

        $key = "product.$id";

        $onCache = $this->adapter->getItem($key);
            
        if (!$onCache->isHit()) {
            
            $product = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);
            $data = $this->linkService->getObjectLinks('products', $product, ['all', 'remove']);
            
            $this->cache->saveItem($key, $data);            
            
            return $data;
        }
        $data = $onCache->get();

        return $data;
    }
}
