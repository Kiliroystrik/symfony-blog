<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/addpost', name: 'add-post')]
    public function createPost(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {

        $post = new Post();

        $post->setCreationDate(new \DateTime());
        $post->setUpdatedDate(new \DateTime());

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($post);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('post/add.html.twig', [
            'form' => $form,
        ]);
    }
}
