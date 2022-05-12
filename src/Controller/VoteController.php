<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Form\VoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commentaire;
use App\Entity\User;

/**
 * @Route("/vote")
 */
class VoteController extends AbstractController
{
   /**
     * @Route("/newdeslike/{id}/{idp}", name="app_vote_newdeslike", methods={"GET", "POST"})
     */
    public function newDeslike(Request $request, EntityManagerInterface $entityManager,$id,$idp): Response
    {
        $vote = new Vote();
        $user = $entityManager
            ->getRepository(User::class)
            ->find($this->getUser());
        $avis = $entityManager
        ->getRepository(Commentaire::class)
        ->find($id);    

        $voteExsit = $entityManager
        ->getRepository(Vote::class)
        ->findOneBy([
            'idPost' => $avis,
            'idUser' => $user,
        ]);

        if($voteExsit == null){
        $vote->setIdUser($user);
        $vote->setIdPost($avis);
        $vote->setTypeVote(2);
        $entityManager->persist($vote);
        $entityManager->flush();
        }
        else{

            $vote->setIdUser($user);
            $vote->setIdPost($avis);
            $vote->setTypeVote(2);
            $entityManager->remove($voteExsit);
            $entityManager->persist($vote);
            $entityManager->flush();


        }

        return $this->redirectToRoute('app_commentaire_new',['id'=>$idp], Response::HTTP_SEE_OTHER);

    }



        /**
     * @Route("/newlike/{id}/{idp}", name="app_vote_newlike", methods={"GET", "POST"})
     */
    public function newLike(Request $request, EntityManagerInterface $entityManager,$id,$idp): Response
    {
        $vote = new Vote();
        $user = $entityManager
            ->getRepository(User::class)
            ->find($this->getUser());
        $avis = $entityManager
        ->getRepository(Commentaire::class)
        ->find($id);    

        $voteExsit = $entityManager
        ->getRepository(Vote::class)
        ->findOneBy(array('idUser'=>$user ,'idPost'=>$avis));    

        if($voteExsit == null){
        $vote->setIdUser($user);
        $vote->setIdPost($avis);
        $vote->setTypeVote(1);
        $entityManager->persist($vote);
        $entityManager->flush();
        }
        else{

            $vote->setIdUser($user);
            $vote->setIdPost($avis);
            $vote->setTypeVote(1);
            $entityManager->remove($voteExsit);
            $entityManager->persist($vote);
            $entityManager->flush();


        }
        return $this->redirectToRoute('app_commentaire_new',['id'=>$idp], Response::HTTP_SEE_OTHER);
    }
}
