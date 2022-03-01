<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PostRepository $postRepository): Response
    {

        $allPosts = $postRepository->findAll();

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'posts' => $allPosts,
        ]);
    }
}
