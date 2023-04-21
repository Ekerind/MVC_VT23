<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class QuoteJson extends AbstractController
{
    #[Route("api/quote", name: "quote")]
    public function jsonQuote(): Response
    {
        date_default_timezone_set('Europe/Stockholm');
        $number = random_int(0, 2);
        $date = date("Y-m-d H:i:s");
        $quotes = [
            'The way to get started is to quit talking and begin doing.',
            'The greatest glory in living lies not in never falling, but in rising every time we fall.',
            'Do not go where the path may lead, go instead where there is no path and leave a trail.'
        ];

        $data = [
            'Date' => $date,
            'Quote' => $quotes[$number],
            'Quote index' => $number
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
