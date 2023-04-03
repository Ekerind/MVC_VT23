<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    #[Route("/lucky", name: "lucky")]
    public function color(): Response
    {
        $number = random_int(0, 2);
        $colors = [
            '#FF0000',
            '#00FF00',
            '#0000FF'
        ];
        $selected_color = $colors[$number];
        $rotation = random_int(1, 7);
        $position = $rotation * 45;

        return $this->render('lucky.html.twig', [
            'selected_color' => $selected_color,
            'position' => $position
        ]);
    }
}
