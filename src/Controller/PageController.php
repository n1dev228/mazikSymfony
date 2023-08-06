<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
		#[Route('/', name: 'app_homepage')]
		public function index( ): Response
		{
			return $this->render('homepage/index.html.twig', [
				'controller_name' => 'Homepage Function Controller',
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
