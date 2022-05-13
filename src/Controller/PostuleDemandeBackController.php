<?php

namespace App\Controller;

use App\Entity\PostuleDemande;
use App\Form\PostuleDemande1Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\PostuleDemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/postule/demande/back")
 */
class PostuleDemandeBackController extends AbstractController
{
    /**
     * @Route("/", name="app_postule_demande_back_index", methods={"GET"})
     */
    public function index(PostuleDemandeRepository $postuleDemandeRepository): Response
    {
        return $this->render('postule_demande_back/index.html.twig', [
            'postule_demandes' => $postuleDemandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_postule_demande_back_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PostuleDemandeRepository $postuleDemandeRepository): Response
    {
        $postuleDemande = new PostuleDemande();
        $form = $this->createForm(PostuleDemande1Type::class, $postuleDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postuleDemandeRepository->add($postuleDemande);
            return $this->redirectToRoute('app_postule_demande_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postule_demande_back/new.html.twig', [
            'postule_demande' => $postuleDemande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_postule_demande_back_show", methods={"GET"})
     */
    public function show(PostuleDemande $postuleDemande): Response
    {
        return $this->render('postule_demande_back/show.html.twig', [
            'postule_demande' => $postuleDemande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_postule_demande_back_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PostuleDemande $postuleDemande, PostuleDemandeRepository $postuleDemandeRepository): Response
    {
        $form = $this->createForm(PostuleDemande1Type::class, $postuleDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postuleDemandeRepository->add($postuleDemande);
            return $this->redirectToRoute('app_postule_demande_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postule_demande_back/edit.html.twig', [
            'postule_demande' => $postuleDemande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_postule_demande_back_delete", methods={"POST"})
     */
    public function delete(Request $request, PostuleDemande $postuleDemande, PostuleDemandeRepository $postuleDemandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postuleDemande->getId(), $request->request->get('_token'))) {
            $postuleDemandeRepository->remove($postuleDemande);
        }

        return $this->redirectToRoute('app_postule_demande_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
