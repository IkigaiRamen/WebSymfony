<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\Post1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post/front")
 */
class PostFrontController extends AbstractController
{
    /**
     * @Route("/", name="app_post_front_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('post_front/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/new", name="app_post_front_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(Post1Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_post_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post_front/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPost}", name="app_post_front_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('post_front/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{idPost}/edit", name="app_post_front_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Post1Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post_front/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPost}", name="app_post_front_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getIdPost(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_post_front_index', [], Response::HTTP_SEE_OTHER);
    }
}
