<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\Demande1Type;
use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @Route("/demande/mobile")
 */
class DemandeMobileController extends AbstractController
{
    /**
     * @Route("/all", name="app_demande_mobile_index", methods={"GET"})
     */
    public function index(NormalizerInterface $normalizable ,DemandeRepository $demandeRepository): Response
    {
        $demande = $demandeRepository->findAll();
        $jsonContent=$normalizable->normalize($demande,'json',['groups'=>['demande']]);
        return new Response(json_encode($jsonContent));
        
    }
    /**
     * @Route("/new", name="app_demande_mobile_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DemandeRepository $demandeRepository)
    {
        $demande = new Demande();
        $demande->setTitre($request->get('t')->get('titre'));
        $demande->setCategorie($request->get('t')->get('categorie'));
        $demande->setDescription($request->get('t')->get('description'));
        $demande->setType($request->get('t')->get('type'));
        $demande->setExp($request->get('t')->get('exp'));
        $demande->setQualification($request->get('t')->get('qualification'));
        $demande->setCity($request->get('t')->get('city'));
        $entityManager->persist($demande);
        $entityManager->flush();    
    }


    /**
     * @Route("/{id}/{description}/{titre}/edit", name="app_demande_mobile_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {
        $demande =new demande();
        $demande =$demandeRepository->findOneById($id);
        $offre->setTitre($titre);
        $offre->setDescription($description);
        $entityManager->persist($offre);
        $entityManager->flush();
        $jsonContent=$normalizable->normalize($offre,'json',['groups'=>['demande']]);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/{id}/delete", name="app_demande_mobile_delete", methods={"POST"})
     */
    public function delete(Request $request, $id , DemandeRepository $demandeRepository)
    {

        $demande = $demandeRepository->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();

    }
    
}

