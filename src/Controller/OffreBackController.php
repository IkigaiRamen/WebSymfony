<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\Offre2Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/offre/back")
 */
class OffreBackController extends AbstractController
{
    /**
     * @Route("/", name="app_offre_back_index", methods={"GET"})
     */
    public function index(OffreRepository $offreRepository): Response
    {
        return $this->render('offre_back/index.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_offre_back_new", methods={"GET", "POST"})
     */
    public function new(Request $request, OffreRepository $offreRepository): Response
    {
        $offre = new Offre();
        $form = $this->createForm(Offre2Type::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreRepository->add($offre);
            return $this->redirectToRoute('app_offre_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre_back/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_offre_back_show", methods={"GET"})
     */
    public function show(Offre $offre): Response
    {
        return $this->render('offre_back/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_offre_back_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Offre $offre, OffreRepository $offreRepository): Response
    {
        $form = $this->createForm(Offre2Type::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreRepository->add($offre);
            return $this->redirectToRoute('app_offre_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre_back/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_offre_back_delete", methods={"POST"})
     */
    public function delete(Request $request, Offre $offre, OffreRepository $offreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getId(), $request->request->get('_token'))) {
            $offreRepository->remove($offre);
        }

        return $this->redirectToRoute('app_offre_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
