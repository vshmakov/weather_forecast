<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ExternalServiceCallResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ExternalServiceCallResultController extends AbstractController
{
    #[Route('/api-call-history', name: 'api_call_history', methods: ['GET'])]
    public function index(): Response
    {
        $externalServiceCallResults = $this->getDoctrine()
            ->getRepository(ExternalServiceCallResult::class)
            ->findBy([], ['calledAt' => 'desc']);

        return $this->render('external_service_call_result/index.html.twig', [
            'external_service_call_results' => $externalServiceCallResults,
        ]);
    }
}
