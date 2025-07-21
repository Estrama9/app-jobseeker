<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ResetPasswordRequestController extends AbstractController
{
    #[Route('/api/reset-password-request', name: 'api_reset_password_request', methods: ['POST'])]
    public function __invoke(
        Request $request,
        EntityManagerInterface $em,
        MailerInterface $mailer,
        #[Autowire('%env(APP_FRONTEND_URL)%')] string $frontendUrl // e.g., https://jobseeker.wip
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;

        if (!$email) {
            return new JsonResponse(['error' => 'Email is required'], 400);
        }

        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            // Create token
            $token = Uuid::v4()->toRfc4122();
            $user->setResetToken($token);
            $user->setResetTokenExpiresAt(new \DateTime('+1 hour'));
            $em->flush();

            // Send email
            $resetUrl = $frontendUrl . '/reset-password?token=' . $token;
            $emailMessage = (new Email())
                ->from('cfrodrigues9@gmail.com')
                ->to($user->getEmail())
                ->subject('🔐 Réinitialisation de mot de passe')
                ->html('<p>Cliquez ici pour réinitialiser votre mot de passe : <a href="' . $resetUrl . '">' . $resetUrl . '</a></p>');


            $mailer->send($emailMessage);

        }

        // Always return success to avoid leaking user existence
        return new JsonResponse(['message' => 'If the email exists, a reset link has been sent.']);
    }
}
