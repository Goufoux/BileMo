<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProductController extends ObjectManagerController
{
    /**
     * @Rest\View(serializerGroups={"product"})
     * @Rest\Get("/api/products")
     * @Rest\Get("/api/products/{id}")
     */
    public function getProductsAction(Product $product = null)
    {
        if (null === $product || $product->getCustomer() !== $this->getUser()) {
            $products = $this->em->getRepository(Product::class)->findBy(['customer' => $this->getUser()]);

            $data = [];

            foreach ($products as $product) {
                $data[] = [
                    'product' => $product,
                    'link' => [
                        'view' => "/products/{$product->getId()}",
                        'remove' => "/products/{$product->getId()}"
                    ]
                ];
            }

            return $data;
        }

        $data = [
            'product' => $product,
            'link' => [
                'remove' => "/products/{$product->getId()}"
            ]
        ];

        return $data;
    }
}
