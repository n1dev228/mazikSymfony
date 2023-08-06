<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductCategoryController extends AbstractController
{
    #[Route('/product-category/{slug}', name: 'app_product_category', methods: ['GET', 'HEAD'])]
    public function index(string $slug): Response
    {
        return $this->render('product_category/index.html.twig', [
            'controller_name' => 'ProductCategoryController - - - ' . $slug,
        ]);
    }
}
