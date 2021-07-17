<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ExternalServiceCallResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api-call-history', name: 'api_call_history', methods: [Request::METHOD_GET])]
final class ApiCallHistoryController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('api_call_history.html.twig', [
            'external_service_call_results' => $this->getDoctrine()
                ->getRepository(ExternalServiceCallResult::class)
                ->findBy([], ['calledAt' => 'desc']),
        ]);
    }
}
