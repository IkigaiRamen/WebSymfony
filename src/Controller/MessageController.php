<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use App\Form\MessageType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
      /**
     * @Route("/message_mobile/{id}", name="message_mobile")
     */
    public function message_mobile($id,NormalizerInterface  $normalizer)
    {
        $repository=$this->getdoctrine()->getrepository(Messages::class);
        $messages=$repository->findBy(array('recipient' => $id));


        $json = $normalizer->normalize($messages, "json",['groups' => ['messages']]);

        return new JsonResponse($json);
    }
       /**
     * @Route("/add_message_mobile/{id}/{ids}/{mess}", name="add_message_mobile")
     */
    public function add_message_mobile($ids,$mess,$id,NormalizerInterface  $normalizer)
    {



        $message = new Messages;
        $repository_user=$this->getdoctrine()->getrepository(User::class);

        $user_s=$repository_user->find($ids);
        $user_r=$repository_user->find($id);

        $message->setRecipient($user_r);
        $message->setSender($user_s);
        $message->setMessage($mess);    
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        $repository=$this->getdoctrine()->getrepository(Messages::class);
        $messages=$repository->findBy(array('recipient' => $id));
       

        $json = $normalizer->normalize($messages, "json",['groups' => ['messages']]);

        return new JsonResponse($json);
    }

     /**
     * @Route("/supp_message_mobile/{id}/{idm}", name="supp_message_mobile")
     */
    public function supp_message_mobile($id,$idm,NormalizerInterface  $normalizer)
    {

        
  


        $repository_m=$this->getdoctrine()->getrepository(Messages::class);

        $message=$repository_m->find($idm);
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        $repository=$this->getdoctrine()->getrepository(Messages::class);
        $messages=$repository->findBy(array('recipient' => $id));
       

        $json = $normalizer->normalize($messages, "json",['groups' => ['messages']]);

        return new JsonResponse($json);
    }
      /**
     * @Route("/pdf", name="pdf",  methods={"GET","POST"})
     */
    public function pdf(Request $request)
    {

// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

// Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repository=$this->getdoctrine()->getrepository(Messages::class);
        $messages=$repository->findAll();

// Retrieve the HTML generated in our twig file
        $html = $this->renderView('message/pdf.html.twig', [
            'title' => "Welcome to our PDF Test", 'messages'=>$messages,
        ]);

// Load HTML to Dompdf
        $dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A2', 'portrait');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        $pdfOptions->set('isRemoteEnabled', true);

    }
    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request):Response
    {
        $this->getDoctrine()->getRepository(Messages::class)->mise_a_jour();
        $message = new Messages;
        $form = $this->createForm(MessageType::class, $message);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $message->setSender($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("message");
        }

        return $this->render("message/send.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        $this->getDoctrine()->getRepository(Messages::class)->mise_a_jour();
        return $this->render('message/received.html.twig');
    }


    /**
     * @Route("/sent", name="sent")
     */
    public function sent(): Response
    {
        $this->getDoctrine()->getRepository(Messages::class)->mise_a_jour();
        return $this->render('message/sent.html.twig');
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Messages $message): Response
    {
        $this->getDoctrine()->getRepository(Messages::class)->mise_a_jour();
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('message/read.html.twig', compact("message"));
    }
    

    /**
     * @Route("/message/{id}/delete",name="message_delete")
     * @param Message $message
     */
    public function delete(Messages $message): Response
    {$this->getDoctrine()->getRepository(Messages::class)->mise_a_jour();

      $em = $this->getDoctrine()->getManager();
      $em->remove($message);
      $em->flush();

      return $this->render('message/received.html.twig');

    }

    
    
}
