<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Entity\User;
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
     * @Route("/", name="app_commentaire_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('commentaire/indexAdmin.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * @Route("/details/{id}", name="app_commentaire_new")
     */
    public function new(Request $request,$id, EntityManagerInterface $entityManager): Response
    {
        $test= Array_values($this->getUser()->getRoles())[0];
        if( $test != 'ROLE_EMPLOYEUR') {
            $template = 'base.html.twig';
            }
            else {
            $template ='base2.html.twig';
            }

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
            ->find(2);
        if ($form->isSubmitted() && $form->isValid()) {

            $commentaire->setIdUser($user);
            $commentaire->setIdpost($post);
            $commentaire->setDate(new \DateTime());
            $entityManager->persist($commentaire);
            $entityManager->flush();


            return $this->redirectToRoute('app_commentaire_new', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/index.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
            'post'=>$post,
            'template'=>$template,
            'comment'=>$comment
        ]);
    }

    /**
     * @Route("/{idCommentaire}", name="app_commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        $test= Array_values($this->getUser()->getRoles())[0];
        if( $test != 'ROLE_EMPLOYEUR') {
            $template = 'base.html.twig';
            }
            else {
            $template ='base2.html.twig';
            }

        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
            'template'=>$template,
        ]);
    }

    /**
     * @Route("/{idp}/{idCommentaire}/edit", name="app_commentaire_edit")
     */
    public function edit(Request $request,$idp, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $test= Array_values($this->getUser()->getRoles())[0];
        if( $test != 'ROLE_EMPLOYEUR') {
            $template = 'base.html.twig';
            }
            else {
            $template ='base2.html.twig';
            }

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $post = $entityManager
            ->getRepository(Post::class)
            ->find($idp);
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
            'template'=>$template,
            'comment'=>$comment
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
