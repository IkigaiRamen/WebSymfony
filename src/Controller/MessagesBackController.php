<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/messages/back")
 */
class MessagesBackController extends AbstractController
{
    /**
     * @Route("/", name="app_messages_back_index", methods={"GET"})
     */
    public function index(MessagesRepository $messagesRepository): Response
    {
        return $this->render('messages_back/index.html.twig', [
            'messages' => $messagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_messages_back_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Messages();
        $form = $this->createForm(Message::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_messages_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('messages_back/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_messages_back_show", methods={"GET"})
     */
    public function show(Messages $message): Response
    {
        return $this->render('messages_back/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_messages_back_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Messages $message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_messages_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('messages_back/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_messages_back_delete", methods={"POST"})
     */
    public function delete(Request $request, Messages $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_messages_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
