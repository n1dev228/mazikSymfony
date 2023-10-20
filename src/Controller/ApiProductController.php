<?php

namespace App\Controller;

use App\Entity\Attachment;
use App\Entity\Product;
use App\Entity\CategoryRelation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ApiProductController extends AbstractController
{
    #[Route('/api/product/create', name: 'app_api_product', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
				$product_data = $request->request;

   	 	  // Creating product
				$product = new Product();
				$product->setName($product_data->get('name'));
				$product->setSku($product_data->get('sku'));
				$product->setArticle($product_data->get('article'));
				$product->setSlug($product_data->get('slug'));
				$product->setPrice($product_data->get('price'));
				$product->setContent($product_data->get('content'));
				$product->setCreatedAt(new \DateTime());
				$entityManager->persist($product);
				$entityManager->flush();

				$product_id = $product->getId();

				if($request->get('category')) {

					foreach($request->get('category') as $cat_id) {
						$category_relation = new CategoryRelation();
						$category_relation->setPostId($product_id);
						$category_relation->setCategoryId((int) $cat_id);
						$entityManager->persist($category_relation);
						$entityManager->flush();
						}
				}
				// Uploading attachment
				$uploadedFile = $request->files->get('mainImage');
				if($uploadedFile) {
					$originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
					$safeFilename = $originalFilename;
					$newFilename = $product_id . '_' .$safeFilename.'.'.$uploadedFile->guessExtension();
 		 	 	  $fileExtension = $uploadedFile->guessExtension();
					try {
						$dir = $this->getParameter('kernel.project_dir').'/public/uploads/' . date('Y');
					 	if(!$dir) {
							 mkdir($dir);
						}
					 	$uploadedFile->move(
						  $dir,
							$newFilename
						);
						$attachment = new Attachment();
						$attachment->setFileName($newFilename);
						$attachment->setFilePath('uploads/' . date('Y'));
						$attachment->setPostId($product_id);
						$attachment->setFileType($fileExtension);
						$attachment->setCreatedAt(new \DateTime());
						$entityManager->persist($attachment);
						$entityManager->flush();

					} catch (FileException $e) {
						// Handle exception if something happens during the file upload process
					}
				}

        return $this->json([json_encode($request->request)]);
    }
}
