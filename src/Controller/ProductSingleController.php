<?php

namespace App\Controller;

use App\Repository\AttachmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;

class ProductSingleController extends AbstractController
{
	#[Route('/catalog/{cat_slug}/{slug}.html', name: 'app_product_single', methods: ['GET', 'HEAD'])]
	public function index(string $cat_slug, CategoryRepository $categoryRepository, string $slug, ProductRepository $productRepository, AttachmentRepository $attachmentRepository): Response
	{
		$controllerData = [];
		$product = $productRepository->findOneBy(['slug' => $slug]);
		if ($product) {
			$attachments = $attachmentRepository->findBy(['post_id' => $product->getId()]);

			$mainAttachment = array_filter($attachments, function ($attachment) {
				return $attachment->getFileType() == null;
			});
			$attachments = array_filter($attachments, function ($attachment) {
				return $attachment->getFileType() != null;
			});
			if (count($attachments) > 0) {
				$product->getAttachments = $attachments;
			}
			if (count($mainAttachment) > 0) {
				$product->mainAttachment = reset($mainAttachment);
			}
			$remainings = $product->getRemaining();
			$summ = 0;
			if ($remainings) {
				foreach ($remainings as $remaining) {
					$summ += $remaining['Остаток'];
				}
			}


			$controllerData = [
				'product_stock' => $summ,
				'product' => $product,
			];
			$productCategory = $categoryRepository->findOneBy(['slug' => $cat_slug]);
			if($productCategory) {
				$controllerData['productCat'] = $productCategory;
			}

		}
		return $this->render('product_single/index.html.twig', $controllerData);
	}
}
