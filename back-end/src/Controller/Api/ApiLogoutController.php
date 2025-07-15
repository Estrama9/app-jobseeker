<?php
namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ApiLogoutController
{
    #[Route('/api/logout', methods: ['POST'])]
    public function logout(Request $request): JsonResponse
    {
        // You could clear cookie if your token is in a cookie
        $response = new JsonResponse(['message' => 'Logged out successfully']);

        // Example: clear auth cookie (adjust cookie name/path/domain as needed)
        $response->headers->clearCookie('BEARER', '/', '.jobseeker.wip', true, true, 'Lax');


        return $response;
    }
}
