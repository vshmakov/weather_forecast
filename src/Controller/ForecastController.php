<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Place;
use App\Form\PlaceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ForecastController extends AbstractController
{
    #[Route('/', name: 'forecast')]
    public function index(Request $request): Response
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('forecast/view.html.twig', [
                'place' => $place,
                'temperature' => '+23',
            ]);
        }

        return $this->render('forecast/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
