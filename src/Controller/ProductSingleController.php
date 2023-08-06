<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductSingleController extends AbstractController
{
    #[Route('/catalog/{cat_slug}/{slug}.html', name: 'app_product_single', methods: ['GET', 'HEAD'])]
    public function index($cat_slug, $slug): Response
    {
        return $this->render('product_single/index.html.twig', [
            'controller_name' => 'ProductSingleController ' . $slug . ' ' . $cat_slug,
        ]);
    }
}
