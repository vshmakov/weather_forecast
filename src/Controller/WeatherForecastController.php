<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Place;
use App\Exception\InvalidPlaceException;
use App\Form\PlaceType;
use App\Temperature\TemperatureProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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
            try {
                $temperature = $temperatureProvider->getTemperature($place);
            } catch (InvalidPlaceException) {
                $form->addError(new FormError('There is no temperature forecast for this place. Please, change it and try again.'));
            }
        }

        return $this->render('weather_forecast.html.twig', [
            'form' => $form->createView(),
            'temperature' => $temperature,
        ]);
    }
}
