<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Vote;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_commentaire_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,$id): Response
    {

        $post = $entityManager
        ->getRepository(Post::class)
        ->find($id);

        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findBy(array('idpost'=>$post));

        return $this->render('commentaire/indexAdmin.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

      function filterwords($text){
        $filterWords = array('fuck', 'merde', 'pute','bitch');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }
    /**
     * @Route("/details/{id}", name="app_commentaire_new")
     */
    public function new(Request $request,$id, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $post = $entityManager
            ->getRepository(Post::class)
            ->find($id);
        $comment = $entityManager
            ->getRepository(Commentaire::class)
            ->findBy(array('idpost'=>$post));
        $user = $entityManager
            ->getRepository(User::class)
            ->find($this->getUser());
         $vote = $entityManager
            ->getRepository(Vote::class)
            ->findAll();
        if ($form->isSubmitted() && $form->isValid()) {

            $commentaire->setIdUser($user);
            $commentaire->setIdpost($post);
            $commentaire->setContenu($this->filterwords($commentaire->getContenu()));
            $commentaire->setDate(new \DateTime());
            $entityManager->persist($commentaire);
            $entityManager->flush();


            return $this->redirectToRoute('app_commentaire_new', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/index.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
            'post'=>$post,
            'comment'=>$comment,
            'vote'=>$vote,
            'user'=>$user
        ]);
    }

    /**
     * @Route("/{idCommentaire}", name="app_commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{idp}/{idCommentaire}/edit", name="app_commentaire_edit")
     */
    public function edit(Request $request,$idp, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $post = $entityManager
            ->getRepository(Post::class)
            ->find($idp);
        $user = $entityManager
            ->getRepository(User::class)
            ->find($this->getUser());
        $vote = $entityManager
            ->getRepository(Vote::class)
            ->findAll();
        $comment = $entityManager
            ->getRepository(Commentaire::class)
            ->findBy(array('idpost'=>$post));
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_new',  ['id'=>$idp], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
            'post'=>$post,
            'comment'=>$comment,
            'vote'=>$vote,
            'user'=>$user
        ]);
    }

    /**
     * @Route("/delete/{id}/{idp}", name="comment_delete")
     */
    public function delete($id,$idp): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository(Commentaire::class)->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('app_commentaire_new', ['id'=>$idp]);
    }
}
