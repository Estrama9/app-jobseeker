<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/api/reset-password', name: 'api_reset_password', methods: ['POST'])]
    public function __invoke(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        try {
        $data = json_decode($request->getContent(), true);
        $token = $data['token'] ?? null;
        $newPassword = $data['password'] ?? null;

        if (!$token || !$newPassword) {
            return new JsonResponse(['error' => 'Token and password are required'], 400);
        }

        $user = $em->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if (!$user || $user->getResetTokenExpiresAt() < new \DateTime()) {
            return new JsonResponse(['error' => 'Invalid or expired token'], 400);
        }

        // Hash and set the new password
        // $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);
        $user->setPlainPassword($newPassword);

        // Clear reset token
        $user->setResetToken(null);
        $user->setResetTokenExpiresAt(null);

        $em->flush();

        return new JsonResponse(['message' => 'Password successfully updated']);
    }
    catch (\Exception $e) {
        return new JsonResponse(['error' => $e->getMessage()], 500);
    }
}

}
