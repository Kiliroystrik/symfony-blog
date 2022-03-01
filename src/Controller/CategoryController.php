<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'category')]
    public function allCategory(CategoryRepository $categoryRepository): Response
    {

        $allCategory = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $allCategory,
        ]);
    }

    // #[Route('/category', name: 'app_category')]
    // public function index(CategoryRepository $categoryRepository): Response
    // {
    //     return $this->render('category/index.html.twig', [
    //         'controller_name' => 'CategoryController',
    //     ]);
    // }
}
