<?php

namespace App\Controller;

use App\Repository\AttachmentRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProductRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class PageController extends AbstractController
{

		#[Route('/', name: 'app_homepage')]
		public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository, AttachmentRepository $attachmentRepository,  KernelInterface $kernel , HttpClientInterface $client	): Response
		{
 	 	 ini_set('memory_limit', '1500M');

			$products = $productRepository->findBy(['stock_status' => 'instock'], ['created_at' => 'DESC'], 12, 0);

			return $this->render('homepage/index.html.twig', [
				 'products' => $products,

			]);
		}

    #[Route('/{slug}', name: 'app_page', methods: ['GET', 'HEAD'])]
    public function page(string $slug): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController for page ' . $slug,
        ]);
    }
}
