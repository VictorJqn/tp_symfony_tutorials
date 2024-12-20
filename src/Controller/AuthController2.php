<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthController2 extends AbstractController
{
    #[Route('/forgot', name: 'page_forgot_password', methods: ['GET', 'POST'])]
    public function forgotPassword(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        if ($request->isMethod('GET')) {
            return $this->render('auth/forgot.html.twig');
        }

        $email = $request->request->get('_email');

        if (!$email) {
            $this->addFlash('error', 'Veuillez saisir une adresse email.');
            return $this->redirectToRoute('page_forgot_password');
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email.');
            return $this->redirectToRoute('page_forgot_password');
        }

        $resetToken = Uuid::v4()->toRfc4122();
        $user->setResetToken($resetToken);
        $user->setResetTokenExpireAt(new \DateTimeImmutable('+1 hour'));

        $entityManager->flush();

        $resetUrl = $this->generateUrl('page_reset_password', ['token' => $resetToken], 0);

        $emailMessage = (new TemplatedEmail())
            ->from('no-reply@votre-domaine.com')
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')
            ->htmlTemplate('email/reset.html.twig')
            ->context([
                'resetUrl' => $resetUrl,
                'userEmail' => $user->getEmail(), // Utilisation d'un autre nom de clé
            ]);

        $mailer->send($emailMessage);

        $this->addFlash('success', 'Un email de réinitialisation a été envoyé.');
        return $this->redirectToRoute('page_forgot_password');
    }

    #[Route('/reset/{token}', name: 'page_reset_password', methods: ['GET', 'POST'])]
    public function resetPassword(
        string $token,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if (!$user || $user->getResetTokenExpireAt() < new \DateTimeImmutable()) {
            $this->addFlash('error', 'Token invalide ou expiré.');
            return $this->redirectToRoute('page_forgot_password');
        }

        if ($request->isMethod('GET')) {
            return $this->render('auth/reset.html.twig', [
                'token' => $token,
            ]);
        }

        $password = $request->request->get('password');
        $confirmPassword = $request->request->get('confirm_password');

        if (!$password || $password !== $confirmPassword) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
            return $this->render('auth/reset.html.twig', [
                'token' => $token,
            ]);
        }

        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setResetToken(null);

        $entityManager->flush();

        $this->addFlash('success', 'Votre mot de passe a été réinitialisé.');
        return $this->redirectToRoute('app_login');
    }
}
