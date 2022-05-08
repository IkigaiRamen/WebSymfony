<?php

namespace App\Controller;

use App\Entity\Friends;
use App\Form\FriendsType;
use App\Repository\FriendsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/friends")
 */
class FriendsController extends AbstractController
{
    /**
     * @Route("/", name="app_friends_index", methods={"GET"})
     */
    public function index(FriendsRepository $friendsRepository): Response
    {
        return $this->render('friends/index.html.twig', [
            'friends' => $friendsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_friends_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FriendsRepository $friendsRepository): Response
    {
        $friend = new Friends();
        $form = $this->createForm(FriendsType::class, $friend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $friendsRepository->add($friend);
            return $this->redirectToRoute('app_friends_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('friends/new.html.twig', [
            'friend' => $friend,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_friends_show", methods={"GET"})
     */
    public function show(Friends $friend): Response
    {
        return $this->render('friends/show.html.twig', [
            'friend' => $friend,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_friends_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Friends $friend, FriendsRepository $friendsRepository): Response
    {
        $form = $this->createForm(FriendsType::class, $friend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $friendsRepository->add($friend);
            return $this->redirectToRoute('app_friends_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('friends/edit.html.twig', [
            'friend' => $friend,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_friends_delete", methods={"POST"})
     */
    public function delete(Request $request, Friends $friend, FriendsRepository $friendsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$friend->getId(), $request->request->get('_token'))) {
            $friendsRepository->remove($friend);
        }

        return $this->redirectToRoute('app_friends_index', [], Response::HTTP_SEE_OTHER);
    }
}
