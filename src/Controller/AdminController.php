<?php

namespace App\Controller;

 use App\Entity\Attachment;
 use App\Entity\Category;
 use App\Entity\CategoryRelation;
 use App\Entity\Product;
 use App\Repository\ProductRepository;
 use Cassandra\Date;
 use Doctrine\ORM\EntityManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
 	  // Categories
		#[Route('/admin/products/categories', name: 'app_admin_categories')]
		public function categories( CategoryRepository $repository): Response
		{
			$categories = $repository->findAll();
			return $this->render('admin/products/categories/index.html.twig', [
				'controller_name' => 'Products',
				'categories' => $categories
			]);
		}

		// Products
		#[Route('/admin/products', name: 'app_admin_products')]
		public function products(): Response
		{
			return $this->render('admin/products/index.html.twig', [
				'controller_name' => 'Products',
			]);
		}


		#[Route('/admin/products/create', name: 'app_admin_products_create')]
		public function create_product( CategoryRepository $repository ): Response
		{
			$categories = $repository->findAll();

			return $this->render('admin/products/create/index.html.twig', [
				'controller_name' => 'Products',
				'categories' => $categories
			]);
		}

		#[Route('/admin/products/import', name: 'app_admin_products_import')]
		public  function import_products( ProductRepository $productRepository, CategoryRepository $categoryRepository, KernelInterface $kernel, Request $request, EntityManagerInterface $entityManager): Response {
			$products = file_get_contents($kernel->getProjectDir() . '/public/json/brands.json');
			$products = json_decode($products);

			ini_set('memory_limit', '1500M');
			set_time_limit(0);

 		  if($request->get('importProducts')) {
 		 	   foreach($products as $product) {
 		 	 	 	  $brand = $categoryRepository->findOneBy(['name' => $product->cat_name, 'taxonomy' => $product->cat_taxonomy]);
						if(!$brand) {
							$newBrand = new Category();
							$newBrand->setName($product->cat_name);
							$newBrand->setSlug($product->cat_slug);
							$newBrand->setTaxonomy($product->cat_taxonomy);
							$newBrand->setCreatedAt(new \DateTime());
							$entityManager->persist($newBrand);
						}
				 }
					 $entityManager->flush();
// 	 	 	  foreach($products as $product ) {
//						 $product_id = $productRepository->findOneBy(['sku' => $product->product_sku]);
//			  	 	 if($product_id) {
//							 $category = $entityManager->getRepository(Category::class)->findOneBy(['cat_unique' => '00-11111111']);
//							 if($category) {
//								 $categoryRelations = $entityManager->getRepository(CategoryRelation::class)->findOneBy(['post_id' => $product_id,
//									 'category_id' => $category->getId()]);
//								 if(!$categoryRelations) {
//									 $categoryRelation = new CategoryRelation();
//									 $categoryRelation->setPostId($product_id->getId());
//									 $categoryRelation->setCategoryId($category->getId());
//									 $entityManager->persist($categoryRelation);
//
//								 }
//							 }
//						 }
//				}
//				$entityManager->flush();
			}
			return $this->render('admin/products/import/index.html.twig', [
 		 	 	 'products' => $products
			]);
		}


		// Pages
		#[Route('/admin/pages', name: 'app_admin_pages')]
		public function pages(): Response
		{
			return $this->render('admin/pages/index.html.twig', [
				'controller_name' => 'Pages',
			]);
		}

		#[Route('/admin/posts', name: 'app_admin_posts')]
		public function posts(): Response
		{
			return $this->render('admin/posts/index.html.twig', [
				'controller_name' => 'Posts',
			]);
		}

		#[Route('/admin/users', name: 'app_admin_users')]
		public function users(): Response
		{
			return $this->render('admin/users/index.html.twig', [
				'controller_name' => 'Users',
			]);
		}

		#[Route('/admin/orders', name: 'app_admin_orders')]
		public function orders(): Response
		{
			return $this->render('admin/products/index.html.twig', [
				'controller_name' => 'Orders',
			]);
		}

	#[Route('/admin/settings', name: 'app_admin_settings')]
	public function settings(): Response
	{
		return $this->render('admin/settings/index.html.twig', [
			'controller_name' => 'Settings',
		]);
	}
}
