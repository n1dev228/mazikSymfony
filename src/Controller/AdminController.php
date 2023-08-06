<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'AdminController',
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
		public function create_product(): Response
		{
			return $this->render('admin/products/create/index.html.twig', [
				'controller_name' => 'Products',
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
