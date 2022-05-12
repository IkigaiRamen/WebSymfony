<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\Offre1Type;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @Route("/offre/mobile")
 */
class OffreMobileController extends AbstractController
{
    /**
     * @Route("/all", name="app_offre_mobile_index", methods={"GET"})
     */
    public function index(NormalizerInterface $normalizable ,OffreRepository $offreRepository): Response
    {
        $offre = $offreRepository->findAll();
        $jsonContent=$normalizable->normalize($offre,'json',['groups'=>['offre']]);
        return new Response(json_encode($jsonContent));
        
    }

    /**
     * @Route("/new/offre", name="app_offre_mobile_new", methods={"GET", "POST"})
     */
    public function new(NormalizerInterface $normalizable,Request $request, OffreRepository $offreRepository)
    {
        
        $offre = new offre();
        $offre->setTitre($request->get('titre'));
        $offre->setEduexp($request->get('eduexp'));
        $offre->setDescription($request->get('description'));
        $offre->setResponsibilities($request->get('responsibilities'));
        $offre->setType($request->get('type'));
        $offre->setExp($request->get('exp'));
        $offre->setQualification($request->get('qualification'));
        $offre->setCity($request->get('city'));
        $entityManager->persist($offre);
        $entityManager->flush();    
    
    }

    /**
     * @Route("/{id}", name="app_offre_mobile_show", methods={"GET"})
     */
    public function show(Offre $offre): Response
    {
        return $this->render('offre_mobile/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    /**
     * @Route("/{id}/edit/{titre}/{description}/", name="app_offre_mobile_edit",)
     */
    public function edit(Request $request, OffreRepository $offreRepository,$id,$titre,$description ): Response
    {
        $offre =new offre();
        $offre =$offreRepository->findOneById($id);
        $offre->setTitre($titre);
        $offre->setDescription($description);
        $entityManager->persist($offre);
        $entityManager->flush();
        $jsonContent=$normalizable->normalize($offre,'json',['groups'=>['offre']]);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/{id}", name="app_offre_mobile_delete", methods={"POST"})
     */
    public function delete(Request $request, int $id, OffreRepository $offreRepository)
    {       

        $repository_m=$this->getdoctrine()->getrepository(offre::class);

        $offre=$repository_m->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();
    

        
    }
}
