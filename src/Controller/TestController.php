<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\User;
use App\Form\TestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/test")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/", name="app_test_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findAll();

        return $this->render('test/index.html.twig', [
            'tests' => $tests,
        ]);
    }

    /**
     * @Route("/new/{userId}", name="app_test_new", methods={"GET", "POST"})
     * @ParamConverter("user", options={"id" = "userId"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ?User $user): Response
    {
        //$form = $this->createForm(TestType::class, $test);
        //$form->handleRequest($request);
            
 
        if ($request->isMethod('POST')) {

            $test = new Test();

            $test->setIduser($user);
            $time = new \DateTime('@'.strtotime('now'));
            $test->setDatecreation($time);
            $test->setDatemodification($time);
            $test->setDuree($request->get('duree'));
            $test->setNbrtentative($request->get('nbrTent'));
            $test->settype("Certification");
            $test->setMaxscore(100);
            $test->setTitre($request->get('titre'));
            
            $entityManager->persist($test);
            $entityManager->flush();
            $id = $test->getId();
            return $this->redirectToRoute('app_question_new', ['testId'=>$id], Response::HTTP_SEE_OTHER);
        }
        return $this->render('test/new.html.twig', [
            
        ]);
        
    }

    /**
     * @Route("/{id}", name="app_test_show", methods={"GET"})
     */
    public function show(Test $test): Response
    {
        
        return $this->render('test/show.html.twig', [
            'test' => $test,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_test_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Test $test, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $time = new \DateTime('@'.strtotime('now'));
            $test->setDatemodification($time);
            $entityManager->flush();

            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('test/edit.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_test_delete", methods={"POST"})
     */
    public function delete(Request $request, Test $test, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getId(), $request->request->get('_token'))) {
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
    }
}
