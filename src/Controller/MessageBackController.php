<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\Messages1Type;
use App\Repository\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\EntityManagerInterface;

/**
 * @Route("/message/back")
 */
class MessageBackController extends AbstractController
{
    /**
     * @Route("/", name="app_message_back_index", methods={"GET"})
     */
    public function index(MessagesRepository $messagesRepository): Response
    {
        return $this->render('message_back/index.html.twig', [
            'messages' => $messagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_message_back_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $message = new Messages();
        $form = $this->createForm(Messages1Type::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_message_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message_back/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_message_back_show", methods={"GET"})
     */
    public function show(Messages $message): Response
    {
        return $this->render('message_back/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_message_back_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Messages $message): Response
    {
        $form = $this->createForm(Messages1Type::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_message_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message_back/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_message_back_delete", methods={"POST"})
     */
    public function delete(Request $request, Messages $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
