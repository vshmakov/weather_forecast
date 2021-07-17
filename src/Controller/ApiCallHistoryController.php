<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ExternalServiceCallResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api-call-history', name: 'api_call_history', methods: ['GET'])]
final class ApiCallHistoryController extends AbstractController
{
    public function __invoke(): Response
    {
        $externalServiceCallResults = $this->getDoctrine()
            ->getRepository(ExternalServiceCallResult::class)
            ->findBy([], ['calledAt' => 'desc']);

        return $this->render('api_call_history.html.twig', [
            'external_service_call_results' => $externalServiceCallResults,
        ]);
    }
}
