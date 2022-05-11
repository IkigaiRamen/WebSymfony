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
     * @Route("/new", name="app_offre_mobile_new", methods={"GET", "POST"})
     */
    public function new(Request $request, OffreRepository $offreRepository): Response
    {
        $offre = new Offre();
        $form = $this->createForm(Offre1Type::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreRepository->add($offre);
            return $this->redirectToRoute('app_offre_mobile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre_mobile/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
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
     * @Route("/{id}/edit", name="app_offre_mobile_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Offre $offre, OffreRepository $offreRepository): Response
    {
        $form = $this->createForm(Offre1Type::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreRepository->add($offre);
            return $this->redirectToRoute('app_offre_mobile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre_mobile/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_offre_mobile_delete", methods={"POST"})
     */
    public function delete(Request $request, Offre $offre, OffreRepository $offreRepository): Response
    {
            $offreRepository->remove($offre);
        

        return $this->redirectToRoute('app_offre_mobile_index', [], Response::HTTP_SEE_OTHER);
    }
}
