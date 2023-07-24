<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactsController extends AbstractController
{
    #[Route('/contacts', name: 'app_contacts_index')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
       MailerInterface $mailer
    ): Response {
        $contact = new Contacts();
        if ($this->getUser()) {
            $contact->setPseudo($this->getUser()->getPseudo())
                ->setEmail($this->getUser()->getEmail());
        }

        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
      
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

//E-mail

$email = (new TemplatedEmail())
->from($form->getData()->getEmail())
->to('admin@admin.frcom')
->subject($form->getData()->getSujet())
->text($form->getData()->getMessage())
->htmlTemplate('emails/contact.html.twig')
->context([
    'contact' => $contact,
    
])
;

$mailer->send($email);

            $this->addFlash(
                'success',
                "Ta demande de contact a bien été envoyée."
            );
            return $this->redirectToRoute('app_contacts_index');
        }
        return $this->render('contacts/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
