<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\Authenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, Authenticator $authenticator, EntityManagerInterface $entityManager, SendMailService $sendMailService, JWTService $jWTService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $user->setCreatedAt(new \DateTimeImmutable);
                $user->setModifiedAt(new \DateTimeImmutable);
                $user->setRoles(['ROLE_USER']);

                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email

                // Génération du JWT de l'utilisateur
                // créer le header
                $header = [
                    'typ' => 'JWT',
                    'alg' => 'HS256'
                ];

                //créer le payload
                $payload = [
                    'user_id' => $user->getId()
                ];

                // générer le token
                $token = $jWTService->generate($header, $payload, $this->getParameter('app.jwtsecret'));

                // dd($token);

                //envoi d'un mail
                $sendMailService->send(
                    'amandine.dubreuil76@gmail.com',
                    $user->getEmail(),
                    'Activation de votre compte Flavor Link',
                    'register',
                    compact('user', 'token')
                );


                return $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
            } else {
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                    'passError' => 'Les mots de passe ne sont pas identiques.'
                ]);
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/{token}', name: 'app_verify_user')]
    public function verifyUser($token, JWTService $jWTService, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        // vérifier si le token est valide, n'a pas expiré et n'a pas été modifié

        if ($jWTService->isValidToken($token) && !$jWTService->isExpiredToken($token) && $jWTService->checkSignatureToken($token, $this->getParameter('app.jwtsecret'))) {
            // récupération du payload
            $payload = $jWTService->getPayload($token);

            // récupération du user du token
            $user = $userRepository->find($payload['user_id']);

            //vérification que le user existe et n'a pas encore activé so compte
            if ($user && !$user->getIsVerified()) {
                $user->setIsVerified(true);
                $entityManager->flush($user);
                $this->addFlash('success', 'Compte utilisateur activé');
                return $this->redirectToRoute('app_user_index');
            }
        }
        // ici un problème dans le token
        $this->addFlash('danger', 'Le Token est invalide ou a expiré.');
        return $this->redirectToRoute('app_login');
    }

    // renvoi de la vérification
    #[Route('/renvoiverif', name: 'app_resend_verif')]
    public function resendVerif(JWTService $jWTService, SendMailService $sendMailService, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        // vérifie que l'utilisateur est connecté
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page.');
            return $this->redirectToRoute('app_login');
        }

        //vérifie que l'utilisateur n'a pas déjà été vérifié
        if ($user->getIsVerified()) {
            $this->addFlash('warning', 'Ce compte utilisateur est déjà activé.');
            return $this->redirectToRoute('app_user_index');
        }

        // Génération du JWT de l'utilisateur
        // créer le header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        //créer le payload
        $payload = [
            'user_id' => $user->getId()
        ];

        // générer le token
        $token = $jWTService->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        // dd($token);

        //envoi d'un mail
        $sendMailService->send(
            'amandine.dubreuil76@gmail.com',
            $user->getEmail(),
            'Activation de votre compte Flavor Link',
            'register',
            compact('user', 'token')
        );
        $this->addFlash('success', 'Un e-mail vient de vous être envoyé à l\'adresse que vous nous avez communiquée.');
        return $this->redirectToRoute('app_login');

    }
}
