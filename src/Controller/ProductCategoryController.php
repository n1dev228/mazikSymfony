<?php

namespace App\Controller;

use App\Repository\AttachmentRepository;
use App\Repository\CategoryRelationRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductCategoryController extends AbstractController
{
	#[Route('/product-category/{slug}/{page}/{number}', name: 'app_product_category', defaults:['page' => null, 'number' => null] ,
		methods: ['GET', 'HEAD'])]
	public function index($number, $page, string $slug, AttachmentRepository $attachmentRepository, CategoryRepository $categoryRepository, ProductRepository $productRepository, CategoryRelationRepository $categoryRelationRepository): Response
	{
		if( $number == '1') {
			return $this->redirectToRoute('app_product_category', ['slug' => $slug]);
		}
		$category = $categoryRepository->findOneBy(['slug' => $slug]);

		$offset = 0;
		if($page) {
			$offset = $number * 42;
		}

		$products = $productRepository->findProductsByCategory($category, 'p.name', 42, $offset);
		$products = array_map(function ($product) use ($attachmentRepository) {
			$attach = $attachmentRepository->findOneBy(['post_id' => $product->getId()]);
			if ($attach) {
				$product->attachment = $attach;
			}
			return $product;
		}, $products);


		$pages_number = intval(count( $productRepository->findProductsByCategory($category))/42);
		$pages = [];
		for($i = 1; $i <= $pages_number; $i++ ) {
			$pages[] = $i;
		}
 	  $rendering_args = [
			'category' => $category,
			'products' => $products,
			'pages' => $pages,
		];
		if($page && $number) {
			$rendering_args['page'] = true;
			$rendering_args['pageNumber'] = $number;
		}


		return $this->render('product_category/index.html.twig', $rendering_args);
	}
}
