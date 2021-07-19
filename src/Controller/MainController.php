<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/qui-sommes-nous", name="team")
     */
    public function team(): Response
    {
        return $this->render('main/team.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

     /**
     * @Route("/contacts", name="contact")
     */
    public function contact(Request $request, ContactNotification $contactNotification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $contactNotification->notify($contact);
            $this->addFlash('success', 'votre email a bien été envoyé');
            return $this->redirectToRoute('home');
        }

        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/mentions-legales", name="notice")
     */
    public function notice(): Response
    {
        return $this->render('main/notice.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

}
