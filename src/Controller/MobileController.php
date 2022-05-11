<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\Reponse;
use App\Entity\Evaluation;
use App\Entity\User;
use App\Entity\Choix;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Question;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;




/**
* @Route("/mobile")
*/
class MobileController extends AbstractController
{
    /**
     * @Route("/alltest", name="mobile_test_all", methods={"GET"})
     */
    public function index(Request $request, NormalizerInterface $normalizable,EntityManagerInterface $entityManager): Response
    {
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findAll();

            $jsonContent=$normalizable->normalize($tests,'json',['groups'=>['quizz', 'question', 'choix']]);
            return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/certifs", name="mobile_test_certifss", methods={"GET"})
     */
    public function allCertifs(NormalizerInterface $normalizable,EntityManagerInterface $entityManager): Response
    {
        $user = 7;
        
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findBy(array(
                'type' => 'Certification',
            ));
            for ($i = 0; $i < sizeof($tests); $i++) {
                $evaluations = $entityManager
                ->getRepository(Evaluation::class)
                ->findBy(array(
                    'idtest' => $tests[$i]->getId(),
                    'iduser' => $user
                ));
                if(sizeof($evaluations)<$tests[$i]->getNbrtentative()){
                    $tests[$i]->setNbrtentative($tests[$i]->getNbrtentative() - sizeof($evaluations));
                }else{
                    array_splice($tests, $i, 1); 
                }
            }

            $jsonContent=$normalizable->normalize($tests,'json',['groups'=>['quizz', 'question', 'choix']]);
            return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/quizz/{id}", name="mobile_test_certifs", methods={"GET"})
     */
    public function allQuizz(NormalizerInterface $normalizable,EntityManagerInterface $entityManager, String $id): Response
    {
        
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findBy(array(
                'iduser' => $id,
                'type' => 'Quizz',
            ));


            $jsonContent=$normalizable->normalize($tests,'json',['groups'=>['quizz', 'question', 'choix']]);
            return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/newreponse", name="mobile_reponse_new", methods={"POST"})
     */
    public function newReponse(Request $request, NormalizerInterface $normalizable, EntityManagerInterface $entityManager): Response
    {
        $params = array_values($request->request->all());
        $values = array_values($params);

        $user = $this->getDoctrine()->getRepository(User::class)->find($values[0]);
        $quizz = $entityManager->getRepository(Test::class)->find($values[1]);
        $nbrQuestion = $values[sizeof($values)-1];
        $allReponses = array();
        $score = 0;

        for ($i = 2; $i < sizeof($values)-1; $i++) {
            $reponse = new Reponse();
            $reponse->setIduser($user);
            $reponse->setIdtest($quizz);
            $choix = $entityManager->getRepository(Choix::class)->find($values[$i]);
            $reponse->setIdchoix($choix);
            $reponse->setCorrect($choix->getCorrect());
            if($choix->getCorrect())
                $score++;

            array_push($allReponses, $reponse);
            $entityManager->persist($reponse);
        }
        $evaluation = new Evaluation();
        $evaluation->setIduser($user);
        $evaluation->setIdtest($quizz);
        $evaluation->setNbrquestion($nbrQuestion);
        $evaluation->setScore($score);
        $evaluation->setSuccess($score> $nbrQuestion -3);


        $entityManager->persist($evaluation);
        $entityManager->flush();
        
        if($evaluation->getSuccess())
        { /*  
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            
            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);
            
            
            $month = date("F");
            $day = date("d");
            $year = date("Y");
            // Retrieve the HTML generated in our twig file
            $html = $this->renderView('pdf/mypdf.html.twig', [
                'title' => $quizz->getTitre(),
                'firstname' => $user ->getFirstname(),
                'lastname' => $user-> getLastname(),
                'score' => $evaluation->getScore(),
                'nbrQuestion' => $nbrQuestion,
                'month' => $month,
                'day' => $day,
                'year' => $year,
            ]);
            
            // Load HTML to Dompdf
            $dompdf->loadHtml($html);
            
            //Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser (inline view)
            */
            return new JsonResponse([
                'success' => true, 
                'score' => $score, 
                'nbrQuestion' => $nbrQuestion, 
                //'data' => base64_encode($dompdf->Output())]);
                'data' => null]);
        }   
        else{
            return new JsonResponse(['success' => false, 'score' => $score, 'nbrQuestion' => $nbrQuestion]);
        }
        
    }

    /**
     * @Route("/newtest", name="mobile_test_new", methods={"POST"})
     */
    public function newCertif(Request $request, NormalizerInterface $normalizable, EntityManagerInterface $entityManager): Response
    {
            $test = new Test();
            $user = $entityManager->getRepository(User::class)->find($request->get('userId'));
            $test->setIduser($user);
            //$time = new \DateTime('@'.strtotime('now'));
            //$test->setDatecreation($time);
            //$test->setDatemodification($time);
            $test->setDuree($request->get('duree'));
            $test->setNbrtentative($request->get('nbrTent'));
            $test->settype('Quizz');
            $test->setMaxscore(100);
            $test->setTitre($request->get('titre'));
            
            $entityManager->persist($test);
            $entityManager->flush();
            //$id = $test->getId();
        
            $jsonContent=$normalizable->normalize($test,'json',['groups'=>['quizz','question','choix']]);
            return new JsonResponse([$jsonContent]);
                    
    }

    /**
     * @Route("/edittest/{id}", name="mobile_test_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NormalizerInterface $normalizable, EntityManagerInterface $entityManager, Test $test): Response
    {

       // $time = new \DateTime('@'.strtotime('now'));
        //$test->setDatemodification($time);
        $test->setDuree(30);
        $test->setNbrtentative(3);
        $test->setTitre("test de connaissance");
        
        
        $entityManager->flush();

        

        $jsonContent=$normalizable->normalize($test,'json',['groups'=>['quizz','questions','choix']]);
            return new JsonResponse([$jsonContent]);
    }

    /**
     * @Route("/suppquizz/{id}", name="mobile_test_delete", methods={"POST"})
     */
    public function delete(Request $request, Test $test, EntityManagerInterface $entityManager): Response
    {
            $entityManager->remove($test);
            $entityManager->flush();

        return new Response();
    }

    /**
     * @Route("/newquestion/{testId}", name="mobile_question_newcertif", methods={"GET", "POST"})
     * @ParamConverter("test", options={"id" = "testId"})
     */
    public function newQuestion(Request $request, EntityManagerInterface $entityManager, ?Test $test)
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
            return new Response();

    }
}
