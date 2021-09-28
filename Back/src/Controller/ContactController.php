<?php

namespace App\Controller;

use App\Form\ContactType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{
  /**
   * @Route("/contact", name="contact")
   */
  public function contact(Request $request, \Swift_Mailer $mailer)
  {
      $form = $this->createForm( ContactType::class);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $contactFormData = $form->getData();
        $message = (new \Swift_Message('E-Mail: de contact'))
               ->setFrom('register-streamingschool@com4up.fr')
               ->setTo('oulerich.loic@gmail.com')
               ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'contact/email.html.twig',
                    ['nom' => $contactFormData["nom"],
                    'email' => $contactFormData["email"],
                    'objet' => $contactFormData["objet"],
                    'message' => $contactFormData["message"]]
                ),
                'text/html')
           ;

           $mailer->send($message);

            return $this->redirectToRoute('contact');
        }

      return $this->render('contact/contact.html.twig', [
        'our_form' => $form->createView()
      ]);
  }
}
