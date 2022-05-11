<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Choix;
use App\Entity\Test;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Test as EntityTest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/question")
 */
class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="app_question_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $questions = $entityManager
            ->getRepository(Question::class)
            ->findAll();

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/new/{testId}", name="app_question_new", methods={"GET", "POST"})
     * @ParamConverter("test", options={"id" = "testId"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ?Test $test)
    {
        if ($request->isMethod('post')) {
            
            $question = new Question();
            $question->setEnonce($request->get('enonce'));
            $question->setTest($test);
            $question->setScore(1);

            $time = new \DateTime('@'.strtotime('now'));
            $question->setDatecreation($time);
            $question->setDatemodification($time);
            $entityManager->persist($question);
            $entityManager->flush();

            $this->forward('App\Controller\ChoixController::newChoixQuestion', [
                'choices'  => [$request->get('choix1'),$request->get('choix2'),$request->get('choix3')],
                'question' => $question,
            ]);            
        
        }
            return $this->render('question/new.html.twig', ['testId'=>$test->getId()]);

    }
    /**
     * @Route("/newcertif/{testId}", name="app_question_newcertif", methods={"GET", "POST"})
     * @ParamConverter("test", options={"id" = "testId"})
     */
    public function newCertif(Request $request, EntityManagerInterface $entityManager, ?Test $test)
    {
        if ($request->isMethod('post')) {
            
            $question = new Question();
            $question->setEnonce($request->get('enonce'));
            $question->setTest($test);


            $time = new \DateTime('@'.strtotime('now'));
            $question->setDatecreation($time);
            $question->setDatemodification($time);
            $entityManager->persist($question);
            $entityManager->flush();

            $this->forward('App\Controller\ChoixController::newChoixQuestion', [
                'choices'  => [$request->get('choix1'),$request->get('choix2'),$request->get('choix3')],
                'question' => $question,
            ]);            
        
        }
            return $this->render('question/newQuesCertif.html.twig', ['testId'=>$test->getId()]);

    }
            

    /**
     * 
     * @Route("/newg", name="app_question_newg", methods={"GET", "POST"})
     */
    public function newGeneric(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('post')) {
            
            $question = new Question();
            $question->setEnonce($request->get('enonce'));
            $certif = $this->getDoctrine()->getRepository(Test::class)->find($request->get('certif'));
            $question->setTest($certif);

            $time = new \DateTime('@'.strtotime('now'));
            $question->setDatecreation($time);
            $question->setDatemodification($time);
            $entityManager->persist($question);
            $entityManager->flush();

            $this->forward('App\Controller\ChoixController::newChoixQuestion', [
                'choices'  => [$request->get('choix1'),$request->get('choix2'),$request->get('choix3')],
                'question' => $question,
            ]);            

            return $this->redirectToRoute('app_question_index', []); 
        }

            $certifs = $entityManager->getRepository(Test::class)->findAll();
            return $this->render('question/newGeneric.html.twig', ["certifs"=>$certifs]);
    }

    /**
     * @Route("/{id}", name="app_question_show", methods={"GET"})
     */
    public function show(Question $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_question_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_question_delete", methods={"POST"})
     */
    public function delete(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
