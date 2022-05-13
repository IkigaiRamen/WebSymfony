<?php

namespace App\Controller;

use App\Entity\Postule;
use App\Form\PostuleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\PostuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/postule/back")
 */
class PostuleBackController extends AbstractController
{
    /**
     * @Route("/", name="app_postule_back_index", methods={"GET"})
     */
    public function index(PostuleRepository $postuleRepository): Response
    {
        return $this->render('postule_back/index.html.twig', [
            'postules' => $postuleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_postule_back_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PostuleRepository $postuleRepository): Response
    {
        $postule = new Postule();
        $form = $this->createForm(PostuleType::class, $postule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postuleRepository->add($postule);
            return $this->redirectToRoute('app_postule_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postule_back/new.html.twig', [
            'postule' => $postule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_postule_back_show", methods={"GET"})
     */
    public function show(Postule $postule): Response
    {
        return $this->render('postule_back/show.html.twig', [
            'postule' => $postule,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_postule_back_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Postule $postule, PostuleRepository $postuleRepository): Response
    {
        $form = $this->createForm(PostuleType::class, $postule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postuleRepository->add($postule);
            return $this->redirectToRoute('app_postule_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postule_back/edit.html.twig', [
            'postule' => $postule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_postule_back_delete", methods={"POST"})
     */
    public function delete(Request $request, Postule $postule, PostuleRepository $postuleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postule->getId(), $request->request->get('_token'))) {
            $postuleRepository->remove($postule);
        }

        return $this->redirectToRoute('app_postule_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
