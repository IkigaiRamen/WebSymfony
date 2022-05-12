<?php

namespace App\Controller;

use App\Entity\Commentaire;

use App\Entity\Post;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiCommentaireController extends AbstractController
{



    function filterwords($text){
        $filterWords = array('fuck', 'merde', 'pute','bitch');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }




    /**
     * @Route("/api/addComment", name="api_commentaire")
     */
    public function newCommentaire(Request $request ,UserRepository $userRepository,EntityManagerInterface $entityManager )
    {

        $em = $this->getDoctrine()->getManager();
        $comment = new Commentaire();
        $comment->setContenu($this->filterwords($request->get('comment')));
        $comment->setIdUser($userRepository->find($request->get('idu')));
        $comment->setIdpost(
            $entityManager
                ->getRepository(Post::class)
                ->find($request->get('idp'))
        );
        $comment->setDate(new \DateTime());
        $em->persist($comment);
        $em->flush();

        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize($comment);
        return new JsonResponse($formated);
    }



    /**
     * @Route("/api/allCommentevents/{id}", name="all_Comment")
     */
    public function AfficheComment(EntityManagerInterface $entityManager,NormalizerInterface $normalizer,$id)
    {

        $p = $entityManager
            ->getRepository(Post::class)
            ->find($id);
        $c = $entityManager
            ->getRepository(Commentaire::class)
            ->findBy(array('idpost'=>$p));
        $jsonContent = $normalizer->normalize($c,'json',['groups'=>'post:comment']);
        // $serializer = new Serializer( [new ObjectNormalizer()]);
        return new JsonResponse($jsonContent);

    }


    /**
     * @Route("/api/updateComment", name="update_Comment")
     */
    public function UpdateCommentaire(Request $request ,UserRepository $userRepository,EntityManagerInterface $entityManager)
    {
        $em=$this->getDoctrine()->getManager();
        $comment = $entityManager
            ->getRepository(Commentaire::class)
            ->find($request->get('id'));
        $em = $this->getDoctrine()->getManager();
        $comment->setContenu($request->get('comment'));

        $em->persist($comment);
        $em->flush();

        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);

    }

    /**
     * @Route("/api/delete/{id}", name="delete_C")
     */
    public function delete(Request $request,$id,EntityManagerInterface $entityManager)
    {

        $em=$this->getDoctrine()->getManager();
        $comment = $entityManager
            ->getRepository(Commentaire::class)
            ->find($id);
        $em->remove($comment);
        $em->flush();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }


}
