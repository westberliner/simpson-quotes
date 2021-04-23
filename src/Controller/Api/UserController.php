<?php

namespace App\Controller\Api;

use App\Entity\Quotation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/user', name: 'api_user_index')]
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $result = $repository->findAll();

        // Avoid circular reference exception.
        // Better way would be via normalizer.
        return $this->json($result, Response::HTTP_OK, [], ['ignored_attributes' => ['quotations']]);
    }

    #[Route('/api/user/{user}/quotation', name: 'api_user_quotation')]
    public function quotation(User $user): JsonResponse
    {
        $quotes = [];
        foreach ($user->getQuotations() as $quote) {
            $quotes[] = $quote->getQuotation();
        }

        return $this->json($quotes);
    }
}
