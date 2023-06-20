<?php

namespace App\Controller;

use App\Form\ResetPasswordRequestType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/oubli-pass', name: 'app_forgotten_password')]
    public function forgottenPassword(Request $request, 
    UserRepository $userRepository, 
    TokenGeneratorInterface $tokenGeneratorInterface, 
    EntityManagerInterface $entityManager,
    SendMailService $mail
    ): Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //chercher l'utilisateur par son mail
            // je vais chercher les données qui sont dans le champs email de mon formulaire
            $user = $userRepository->findOneByEmail($form->get('email')->getData());

            //vérifier s'il y a un user
            if ($user) {
                // générer un token de réinitialisation
                $token = $tokenGeneratorInterface->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                // générer un lien de réinitialisation du mdp
                $url = $this->generateUrl('app_reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
              
// créer les données du mail
$context = compact ('url', 'user');

// envoyer le mail
$mail->send(
    'no-reply@flavor-link.fr',
    $user->getEmail(),
    'Demande de réinitialisation du mot de passe',
    'password_reset',
    $context
);

$this->addFlash('success', 'E-mail envoyé avec succès !');

return $this->redirectToRoute('app_login');

            }

            // si $user est nul
            $this->addFlash('danger', 'Un problème est survenu.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route(path: '/oubli-pass/{token}', name: 'app_reset_pass')]
    public function resetPass(
        string $token,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
        
        ): Response
    {
// vérifier si on a ce token dans la bdd
$user = $userRepository->findOneByResetToken($token);

if($user)
{

}

// token absent de la bdd
$this->addFlash('danger', 'Jeton invalide');
return $this->redirectToRoute('app_login');

    }
}
