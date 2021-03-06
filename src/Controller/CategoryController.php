<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/category/{name}', name: 'category-posts')]
    public function allPosts(PostRepository $post, Category $category = null): Response
    {

        if ($category == null) {
            return $this->redirectToRoute("home");
        }

        $allPost = $category->getPosts();

        return $this->render('category/postbycatego.html.twig', [
            'posts' => $allPost,
            'category' => $category,
        ]);
    }


    #[Route('/addcategory', name: 'add-category')]
    public function createCategory(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {

        $category = new Category();


        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('category/add.html.twig', [
            'form' => $form,
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
