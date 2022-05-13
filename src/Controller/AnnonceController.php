<?php

namespace App\Controller;
use App\Entity\Annonce;
use App\Entity\Demande;
use App\Entity\Postule;
use App\Form\OffrePostuleType;
use App\Entity\Offre;
use App\Form\OffreType;
use App\Entity\Apply;
use App\Entity\User;
use App\Entity\PostuleDemande;
use App\Entity\Search;
use App\Form\Employeur\AnnonceEmployerType;
use App\Form\AnnonceFormType;
use App\Form\DemandeType;
use App\Form\ApplyFormType;
use App\Form\PostuleDemnadeType;
use App\Form\SearchType;
use App\Repository\AnnonceRepository;
use App\Repository\DemandeRepository;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use PhpParser\Node\Expr\BinaryOp\Equal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
use Symfony\Component\Validator\Constraints\EqualTo;






class AnnonceController extends AbstractController
{

    private $twilio;

    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(Request $request, AnnonceRepository $ar)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class,$search);
    $form->handleRequest($request);
   // $annonce= [];

        //appelle la liste des annonces;
        $test= Array_values($this->getUser()->getRoles())[0];
        if( $test != 'ROLE_EMPLOYEUR') {
        $annonce = $this->getDoctrine()->getRepository(Offre::class)->findAll(); }
        else {
            $annonce = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        }
        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $city = $search->getCity();  
            $exp =  $search->getExp();
            $type = $search->getType();
            $categorie = $search->getCategorie();
            $qualification = $search->getQualification();
           // $titre= $search->getTitre();
            
            
               $annonce =$ar->findOneByCityandExp($city,$exp,$type,$qualification,$categorie);
              
             
              
            }
        
            
            return  $this->render('annonce/index.html.twig',[ 'form' =>$form->createView(), 'annonce' => $annonce]);
        /*return $this->render('annonce/index.html.twig', [
            'annonce' => $annonce
        ]);*/
    }

    


    /**
     * @IsGranted("ROLE_TRAVAILLEUR")
     * @Route("/travailleur/Publier", name="add_annoncetravailleur")
     */
    public function ajoutAnnonce(Request $request): Response{
    $demande = new demande();
    $form = $this->createForm(DemandeType::class,$demande);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $demande->setUser($this->getUser());    
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($demande);
        $doctrine->flush();
        return $this->redirectToRoute('annonce_show', ['id' => $demande->getId()], Response::HTTP_SEE_OTHER);

    }

    return $this->render('annonce/AddAnnonceWorker.twig', [
        'annonceForm' => $form->createView()
    ]);
}
    /**
     * @IsGranted("ROLE_EMPLOYEUR")
     * @Route("/Employeur/PublierOffre", name="add_annonce")
     */
    public function ajoutAnnonceEmployeur(Request $request){
        $annonce = new Offre();
        $form = $this->createForm(OffreType::class,$annonce);
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid()){
            $annonce->setUser($this->getUser());
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($annonce);
            $doctrine->flush();
        }
    
           /** @var \App\Entity\User $user */
           return $this->redirectToRoute('annonce_show_employer', ['id' => $annonce->getId()], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/annonce/remove/{id}", name="annonce_remove")
     */

    public function remove(int $id, Request $request ,UserRepository $ur,demandeRepository $ar): Response
    {
        
        $annonce = $this->getDoctrine()
        ->getRepository(demande::class)
        ->findOneById($id);

        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }
    return $this->redirect($request->getUri());
    }

    /**
     * @Route("/annonces/remove/{id}", name="annonce_remove_employer")
     */

    public function remove2(int $id, Request $request ,UserRepository $ur,demandeRepository $ar)
    {
        
        $annonce = $this->getDoctrine()
            ->getRepository(offre::class)
            ->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($annonce);
                $entityManager->flush();
            }
        return $this->redirect($request->getUri());
    }


    /**
     * @Route("/annonce/{id}", name="annonce_show")
     */
    
        public function show(int $id, Request $request ,UserRepository $ur,demandeRepository $ar, offreRepository $or): Response
    {
        $test= Array_values($this->getUser()->getRoles())[0];
        if( $test != 'ROLE_EMPLOYEUR') {
            $template ='base.html.twig';
            }
            else {
            $template ='base2.html.twig';
            }
        $annonce = $this->getDoctrine()
        ->getRepository(demande::class)
        ->findOneById($id);
        $postule = new PostuleDemande();

        $form = $this->createForm(PostuleDemnadeType::class,$postule);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        $postule->setDemande($annonce);
        $postule->setUser($this->getUser());
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($postule);
        $doctrine->flush();
        }
        
    
        /*$message = $this->twilio->messages->create(
            $user->getNumTel(), // Send text to this number
            array(
              'from' => $sender, // My Twilio phone number
              'body' => 'Hello from Awesome Massages. A reminder that your massage appointment is for today at ' . $appoint->getDate()->format('H:i') . '. Call ' . $sender . ' for any questions.'
            )
          );
   
          $output->writeln('SMS #' . $message->sid . ' sent to: ' . $user->getNumTel());*/
    

    

    return $this->render('annonce/annonceshowworker.html.twig', ['annonce' => $annonce , 'template'=>$template,
    'formApply'=>$form->createView(),
    'test'=>$test,
]);
    }

     /**
     * @Route("/annonces/{id}", name="annonce_show_employer")
     */
    
    public function show2(int $id, Request $request ,UserRepository $ur,demandeRepository $ar, offreRepository $or): Response
    {
        $test= Array_values($this->getUser()->getRoles())[0];
        if( $test != 'ROLE_EMPLOYEUR') {
            $template ='base.html.twig';
            }
            else {
            $template ='base2.html.twig';
            }
        $annonce = $this->getDoctrine()
        ->getRepository(offre::class)
        ->findOneById($id);
        $postule = new Postule();

        $form = $this->createForm(OffrePostuleType::class,$postule);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        $postule->setOffre($annonce);
        $postule->setUser($this->getUser());
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($postule);
        $doctrine->flush();
        }
        return $this->render('annonce/annonceshow.html.twig', ['annonce' => $annonce ,'formApply'=>$form->createView(),'template'=>$template]);
    }

}
