<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategoryRepository;

class CategoriesTemplateController extends AbstractController
{
    public function index(CategoryRepository $categoryRepository): Response
    {
			$categories = $categoryRepository->findBy(['taxonomy' => 'product_cat'], ['name' => 'ASC']);

        return $this->render('categories_template/index.html.twig', [
            'categories' => $categories
        ]);
    }
	public function brands(CategoryRepository $categoryRepository): Response
	{
		$categories = $categoryRepository->findBy(['taxonomy' => 'pa_proizvoditel'], ['name' => 'ASC']);

		return $this->render('categories_template/index.html.twig', [
			'categories' => $categories
		]);
	}
}
