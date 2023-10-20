<?php

namespace App\Controller;
use App\Entity\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ApiCategoryController extends AbstractController
{
    #[Route('/api/category/create', name: 'app_api_category_create', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
 	 	 		$category = new Category();
				$category->setName($request->get('name'));
				$category->setSlug($request->get('slug'));
				$category->setContent($request->get('content'));
				$category->setTaxonomy('product_cat');
				$category->setCreatedAt(new \DateTime());
				$entityManager->persist($category);
				$entityManager->flush();

				$category_id = $category->getId();


			return $this->json([json_encode($request->request)]);
    }
}
