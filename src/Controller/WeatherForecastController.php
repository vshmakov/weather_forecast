<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Place;
use App\Form\PlaceType;
use App\Temperature\TemperatureProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'weather_forecast')]
final class WeatherForecastController extends AbstractController
{
    public function __invoke(Request $request, TemperatureProviderInterface $temperatureProvider): Response
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);
        $temperature = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $temperature = $temperatureProvider->getTemperature($place);
        }

        return $this->render('weather_forecast.html.twig', [
            'form' => $form->createView(),
            'temperature' => $temperature,
        ]);
    }
}
