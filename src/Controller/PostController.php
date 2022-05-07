<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/post")
 * @IsGranted("ROLE_ADMIN")
 */
class PostController extends AbstractController
{


    /**
     * @Route("/allPost", name="all_post_index", methods={"GET"})
     */
    public function AllPost(EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('post/AllPost.html.twig', [
            'posts' => $posts,
        ]);
    }



    /**
     * @Route("/", name="app_post_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $entityManager
            ->getRepository(Post::class)
            ->findAll();

            $articles = $paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                 // Nombre de résultats par page
                 1
            );
        return $this->render('post/index.html.twig', [
            'posts' => $articles,
        ]);
    }

    /**
     * @Route("/mesPost", name="mes_post", methods={"GET"})
     */
    public function indexfront(EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager
            ->getRepository(User::class)
            ->find(2);
        $posts = $entityManager
            ->getRepository(Post::class)
            ->findBy(array('idUser'=>$user));

        return $this->render('post/indexFront.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/new", name="app_post_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $user = $entityManager
            ->getRepository(User::class)
            ->find(2);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->getUploadFile();
            $post->setDateP(new \DateTime());
            $post->setEtat("en attent");
            $post->setIdUser($user);
            $post->setReaction(0);
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('mes_post', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{idPost}/edit", name="app_post_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setEtat("en attent");

            if ($post->getFile() != null){
                $post->getUploadFile();
            }

            $entityManager->flush();

            return $this->redirectToRoute('mes_post', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="post_delete")
     */
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('mes_post');
    }


    /**
     * @Route("/accepter/{id}", name="post_accepter")
     */
    public function accepter($id , \Swift_Mailer $mailer, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager
        ->getRepository(Post::class)
        ->find($id);

        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('dina.benmansour@esprit.tn')
        ->setTo($post->getIdUser()->getEmail())
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'post/EmailAccepter.html.twig',
                ['post' => $post]
            ),
            'text/html'
        )

        // you can remove the following code if you don't define a text version for your emails
        ->addPart(
            $this->renderView(
                // templates/emails/registration.txt.twig
                'post/EmailAccepter.html.twig',
                ['post' => $post]
            ),
            'text/plain'
        )
    ;

    $mailer->send($message);

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        $post->setEtat("acceptée");
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('app_post_index');
    }


    /**
     * @Route("/refuser/{id}", name="post_refuser")
     */
    public function refuser($id,\Swift_Mailer $mailer, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager
        ->getRepository(Post::class)
        ->find($id);

        $message = (new \Swift_Message('Email Refusé'))
        ->setFrom('dina.benmansour@esprit.tn')
        ->setTo($post->getIdUser()->getEmail())
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'post/EmailRefuser.html.twig',
                ['post' => $post]
            ),
            'text/html'
        )

        // you can remove the following code if you don't define a text version for your emails
        ->addPart(
            $this->renderView(
                // templates/emails/registration.txt.twig
                'post/EmailRefuser.html.twig',
                ['post' => $post]
            ),
            'text/plain'
        )
    ;

    $mailer->send($message);

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        $post->setEtat("refusée");
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('app_post_index');
    }
}
