<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;


class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/reclamation", name="app_api_reclamation")
     */
    public function index(): Response
    {
        return $this->render('api_reclamation/index.html.twig', [
            'controller_name' => 'ApiReclamationController',
        ]);
    }



     /**
     * @Route("/api/afficherPost/{id}", name="all_postuser")
     */
    public function AffichePost( EntityManagerInterface $entityManager,NormalizerInterface $normalizer,$id)
    {

        $user = $entityManager
        ->getRepository(User::class)
        ->find($id);
        $post = $entityManager
        ->getRepository(Post::class)
        ->findBy(array('idUser'=>$user));
        $jsonContent = $normalizer->normalize($post,'json',['groups'=>'post:post']);
        // $serializer = new Serializer( [new ObjectNormalizer()]);
        return new JsonResponse($jsonContent);

    }



    /**
     * @Route("/api/AllPost", name="all_Post")
     */
    public function AfficheAllPost( EntityManagerInterface $entityManager,NormalizerInterface $normalizer)
    {


        $post = $entityManager
            ->getRepository(Post::class)
            ->findAll();
        $jsonContent = $normalizer->normalize($post,'json',['groups'=>'post:post']);
        // $serializer = new Serializer( [new ObjectNormalizer()]);
        return new JsonResponse($jsonContent);

    }



    /**
     * @Route("/api/AllPostUser", name="all_PostUser")
     */
    public function AfficheAllPostUser( EntityManagerInterface $entityManager,NormalizerInterface $normalizer)
    {


        $post = $entityManager
            ->getRepository(Post::class)
            ->findby(array('etat'=>"acceptée"));
        $jsonContent = $normalizer->normalize($post,'json',['groups'=>'post:post']);
        // $serializer = new Serializer( [new ObjectNormalizer()]);
        return new JsonResponse($jsonContent);

    }


     /**
     * @Route("/apipostdelete/{id}", name="delete_post")
     */
    public function deletePost(EntityManagerInterface $entityManager,Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $p = $em->getRepository(Post::class)->find($id);




        $em->remove($p);
        $em->flush();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }


    /**
     * @Route("/accepterp/{id}", name="accepterp")
     */
    public function accepter(\Swift_Mailer $mailer,EntityManagerInterface $entityManager,Request $request,$id)
    {




        $em=$this->getDoctrine()->getManager();
        $p = $em->getRepository(Post::class)->find($id);

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('dina.benmansour@esprit.tn')
            ->setTo($p->getIdUser()->getEmail())
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'post/EmailAccepter.html.twig',
                    ['post' => $p]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->renderView(
                // templates/emails/registration.txt.twig
                    'post/EmailAccepter.html.twig',
                    ['post' => $p]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);



        $p->setEtat("acceptée");
        $em->persist($p);
        $em->flush();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }


    /**
     * @Route("/refuserp/{id}", name="refuserp")
     */
    public function refuserp(\Swift_Mailer $mailer,EntityManagerInterface $entityManager,Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $p = $em->getRepository(Post::class)->find($id);


        $message = (new \Swift_Message('Email Refusé'))
            ->setFrom('dina.benmansour@esprit.tn')
            ->setTo($p->getIdUser()->getEmail())
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'post/EmailRefuser.html.twig',
                    ['post' => $p]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->renderView(
                // templates/emails/registration.txt.twig
                    'post/EmailRefuser.html.twig',
                    ['post' => $p]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);
        $p->setEtat("refusée");
        $em->persist($p);
        $em->flush();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }







        /**
     * @Route("/api/addPost", name="api_post")
     */
    public function newPost(Request $request ,EntityManagerInterface $entityManager)
    {

        $em = $this->getDoctrine()->getManager();
        $post = new Post();
        $post->setImage($request->get('image'));
        $post->setDescription($request->get('description'));
        $post->setEtat("en attent");
        $post->setIdUser(
            $entityManager
                ->getRepository(User::class)
                ->find($request->get('idu')));
        $post->setDateP(new \DateTime());
        $em->persist($post);
        $em->flush();

        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize($post);
        return new JsonResponse($formated);
    }


    /**
     * @Route("/api/updatePost", name="update_Post")
     */
    public function UpdatePost(Request $request,EntityManagerInterface $entityManager )
    {
        $post = new Post();
        $em = $this->getDoctrine()->getManager();
        $post = $entityManager
            ->getRepository(Post::class)
            ->find($request->get('id'));

        $post->setImage($request->get('image'));
        $post->setDescription($request->get('description'));

        $em->persist($post);
        $em->flush();

        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);

    }


}
