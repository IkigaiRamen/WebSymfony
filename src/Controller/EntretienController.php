<?php

namespace App\Controller;

use App\Entity\Entretien;
use App\Form\EntretienType;
use App\Repository\EntretienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entretien")
 */
class EntretienController extends AbstractController
{
    /**
     * @Route("/", name="app_entretien_index", methods={"GET"})
     */
    public function index(EntretienRepository $entretienRepository): Response
    {
        return $this->render('entretien/index.html.twig', [
            'entretiens' => $entretienRepository->findAll(),
        ]);
    }

    /**
     * @Route("/calendar", name="Entretien_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('Entretien/calendar.html.twig');
    }


    /**
     * @Route("/new", name="app_entretien_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntretienRepository $entretienRepository): Response
    {
        $entretien = new Entretien();
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entretienRepository->add($entretien);
            return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien/new.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_entretien_show", methods={"GET"})
     */
    public function show(Entretien $entretien): Response
    {
        return $this->render('entretien/show.html.twig', [
            'entretien' => $entretien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_entretien_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Entretien $entretien, EntretienRepository $entretienRepository): Response
    {
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entretienRepository->add($entretien);
            return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien/edit.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_entretien_delete", methods={"POST"})
     */
    public function delete(Request $request, Entretien $entretien, EntretienRepository $entretienRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entretien->getId(), $request->request->get('_token'))) {
            $entretienRepository->remove($entretien);
        }

        return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
    }
}
