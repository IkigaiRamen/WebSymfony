<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Form\ReponseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Test;
use App\Entity\Choix;
use App\Entity\Evaluation;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/reponse")
 */
class ReponseController extends AbstractController
{
    /**
     * @Route("/", name="app_reponse_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reponses = $entityManager
            ->getRepository(Reponse::class)
            ->findAll();

        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponses,
        ]);
    }

    /**
     * @Route("/new", name="app_reponse_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
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
            $dompdf->stream("mypdf.pdf", [
                "Attachment" => false
            ]);
        }
        else{
            return $this->render('evaluation/failure.html.twig', ['evaluation' => $evaluation]);
        }


        
    }

    /**
     * @Route("/{id}", name="app_reponse_show", methods={"GET"})
     */
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_reponse_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponse/edit.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_reponse_delete", methods={"POST"})
     */
    public function delete(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
    }

    public function makePDF(){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('default/mypdf.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
}

