<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function allPostDetail(PostRepository $postRepository): Response
    {

        $allPost = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $allPost,
        ]);
    }

    #[Route('/post/{id}', name: 'post-detail')]
    public function OnePostDetail(PostRepository $postRepository, int $id, Post $post): Response
    {

        $onePost = $postRepository->find($id);

        return $this->render('post/onePost.html.twig', [
            'id' => $post->getId(),
            'post' => $onePost,
        ]);
    }
}
