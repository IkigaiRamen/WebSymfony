<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\User;
use App\Entity\Evaluation;
use App\Form\TestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use random_int;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Security;

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
     * @Route("/certifs", name="app_test_certifs", methods={"GET"})
     */
    public function allCertifs(EntityManagerInterface $entityManager): Response
    {
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findBy(array(
                'type' => 'Certification',
            ));

        return $this->render('test/listCertifs.html.twig', [
            'tests' => $tests,
        ]);
    }

    /**
     * @Route("/listquizz", name="app_test_listquizz", methods={"GET"})
     */
    public function userQuizz(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findBy(array(
                'iduser' => $user->getId(),
            ));

        return $this->render('test/listquizz.html.twig', [
            'tests' => $tests,
        ]);
    }
    
    /**
     * @Route("/new", name="app_test_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        //$form = $this->createForm(TestType::class, $test);
        //$form->handleRequest($request);
            
 
        if ($request->isMethod('POST')) {

            $test = new Test();

            $test->setIduser($this->getUser());
            $time = new \DateTime('@'.strtotime('now'));
            $test->setDatecreation($time);
            $test->setDatemodification($time);
            $test->setDuree($request->get('duree'));
            $test->setNbrtentative($request->get('nbrTent'));
            $test->settype("Quizz");
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
     * @Route("/newcertif", name="app_test_newcertif", methods={"GET", "POST"})
     */
    public function newCertif(Request $request, EntityManagerInterface $entityManager): Response
    {
        //$form = $this->createForm(TestType::class, $test);
        //$form->handleRequest($request);
            
 
        if ($request->isMethod('POST')) {

            $test = new Test();

            $test->setIduser($this->getUser());
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
            return $this->redirectToRoute('app_question_newcertif', ['testId'=>$id], Response::HTTP_SEE_OTHER);
        }
        return $this->render('test/newCertif.html.twig', [
            
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

    /**
     * @Route("/pass/{id}", name="app_test_pass", methods={"GET", "POST"})
     */
    public function pass(Request $request, Test $test): Response
    {      
        foreach($test->getQuestions() as $q){
            $list = $q->getChoices()->toArray();
            shuffle($list);
            $reordered = new ArrayCollection($list);
            $q->setChoices($reordered);
        }  

        return $this->render('test/passTest.html.twig', [
            'test' => $test,
        ]);
    }

    /**
     * @Route("/candidats/{id}", name="app_test_candidats", methods={"GET", "POST"})
     */
    public function modifierCandidats(Request $request, Test $quizz, EntityManagerInterface $entityManager): Response
    {      
        if ($request->isMethod('POST')) {
            $time = new \DateTime('@'.strtotime('now'));
            $quizz->setDatemodification($time);
            $participant = $request->get("addParticipant");
            if($participant!== "")
            {
                $user = $entityManager
                ->getRepository(User::class)
                ->find($participant);
                if(array_search($user->getId(), $quizz->getCandidats()) == false){
                    $c = $quizz->getCandidats();
                    array_push($c,$user->getId());
                    $quizz->setCandidats($c);
                }
                    
            }
            
            $elimine = $request->get("removeParticipant");
            if( $elimine !== "")
            {
                $user = $entityManager
                ->getRepository(User::class)
                ->find($elimine);
                if ($key = array_search($user->getId(), $quizz->getCandidats()) !== false) {
                    $c = $quizz->getCandidats();
                    array_splice($c, $key, 1);
                    $quizz->setCandidats($c);    
                }

            }

            $entityManager->flush();

            return $this->redirectToRoute('app_test_listquizz', [], Response::HTTP_SEE_OTHER);
        }
        
        $user = $this->getUser();
        
        return $this->render('test/testCandidats.html.twig', [
            'user' => $user,
            'quizz' => $quizz,
        ]);
    }

    /**
     * @Route("/quizz/dispo", name="app_test_quizzdispo", methods={"GET"})
     */
    public function quizzDispo(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findBy(array(
                'type' => "Quizz"
            ));
        $quizz = [];
        for ($i = 0; $i < sizeof($tests); $i++) {
            if( array_search($user->getId(), $tests[$i]->getCandidats()) != false)
            {
                array_push($quizz, $tests[$i]);
            }
        }
        

        return $this->render('test/quizzDispo.html.twig', [
            'tests' => $quizz,
        ]);
    }
}
