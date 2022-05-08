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
use Symfony\Component\Serializer\SerializerInterface;
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
     * @Route("/certifs", name="mobile_test_certifs", methods={"GET"})
     */
    public function allCertifs(NormalizerInterface $normalizable,EntityManagerInterface $entityManager): Response
    {
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findBy(array(
                'type' => 'Certification',
            ));

            $jsonContent=$normalizable->normalize($tests,'json',['groups'=>['quizz', 'question', 'choix']]);
            return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/newreponse", name="mobile_reponse_new", methods={"POST"})
     */
    public function new(Request $request, NormalizerInterface $normalizable, EntityManagerInterface $entityManager): Response
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


        //$entityManager->persist($evaluation);
        //$entityManager->flush();
        
        if($evaluation->getSuccess())
        {   
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
            return new JsonResponse([
                'success' => true, 
                'score' => $score, 
                'nbrQuestion' => $nbrQuestion, 
                'data' => base64_encode($dompdf->Output())]);
        }
        else{
            return new JsonResponse(['success' => false, 'score' => $score, 'nbrQuestion' => $nbrQuestion]);
        }
        
    }

    /**
     * @Route("/newtest", name="mobile_test_new", methods={"POST"})
     */
    public function newCertif(Request $request, EntityManagerInterface $entityManager): Response
    {
        //$form = $this->createForm(TestType::class, $test);
        //$form->handleRequest($request);
            
 

            $test = new Test();

            $test->setIduser($request->get('userId'));
            $time = new \DateTime('@'.strtotime('now'));
            $test->setDatecreation($time);
            $test->setDatemodification($time);
            $test->setDuree($request->get('duree'));
            $test->setNbrtentative($request->get('nbrTent'));
            $test->settype('Certification');
            $test->setMaxscore(100);
            $test->setTitre($request->get('titre'));
            
            $entityManager->persist($test);
            $entityManager->flush();
            //$id = $test->getId();
        
            return new JsonResponse($test);
                    
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
