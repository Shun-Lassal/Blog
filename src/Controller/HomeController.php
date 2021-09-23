<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;
use App\Entity\User;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(PostRepository $repo): Response
    {

        $posts = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'posts' => $posts
        ]);
    }

    #[Route("/posts/{id}", name:"show_post")]
    public function show(Post $post, Request $request, EntityManagerInterface $em) {

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
            
            $comment->setCreatedAt(new \DateTime());
            $comment->setPost($post);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $em->persist($comment);
                $em->flush();
            }

        return $this->render('home/post.html.twig', [

            'post' => $post,
            'form' => $form->createView()
        ]);
    }
}
