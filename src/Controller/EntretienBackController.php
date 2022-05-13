<?php

namespace App\Controller;

use App\Entity\Entretien;
use App\Form\Entretien1Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\EntretienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/entretien/back")
 */
class EntretienBackController extends AbstractController
{
    /**
     * @Route("/", name="app_entretien_back_index", methods={"GET"})
     */
    public function index(EntretienRepository $entretienRepository): Response
    {
        return $this->render('entretien_back/index.html.twig', [
            'entretiens' => $entretienRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_entretien_back_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntretienRepository $entretienRepository): Response
    {
        $entretien = new Entretien();
        $form = $this->createForm(Entretien1Type::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entretienRepository->add($entretien);
            return $this->redirectToRoute('app_entretien_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien_back/new.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_entretien_back_show", methods={"GET"})
     */
    public function show(Entretien $entretien): Response
    {
        return $this->render('entretien_back/show.html.twig', [
            'entretien' => $entretien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_entretien_back_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Entretien $entretien, EntretienRepository $entretienRepository): Response
    {
        $form = $this->createForm(Entretien1Type::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entretienRepository->add($entretien);
            return $this->redirectToRoute('app_entretien_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien_back/edit.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_entretien_back_delete", methods={"POST"})
     */
    public function delete(Request $request, Entretien $entretien, EntretienRepository $entretienRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entretien->getId(), $request->request->get('_token'))) {
            $entretienRepository->remove($entretien);
        }

        return $this->redirectToRoute('app_entretien_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
