<?php

namespace App\Controller;

use App\Cards\Card;
use App\Cards\CardGraphic;
use App\Cards\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameJSON extends AbstractController
{
    #[Route("api/deck", name: "json_deck", methods: ['GET'])]
    public function jsonDeck(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("deck");
        $data = [
            "deck" => $deck->groupBySuit(),
            "count" => $deck->countDeck()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("api/deck/shuffle", name: "json_shuffle")]
    public function jsonShuffle(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("deck");
        $deck->shuffle();
        $session->set("deck", $deck);
        $data = [
            "deck" => $deck->showAll(),
            "count" => $deck->countDeck()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("api/deck/draw", name: "json_draw_single", methods: ['GET', 'POST'])]
    public function jsonDraw(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("deck");
        $data = [
            "draw" => $deck->draw(),
            "count" => $deck->countDeck()
        ];
        $deck = $session->set("deck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw-many", name: "draw_json_get", methods: ['GET'])]
    public function drawInit(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");
        $count = $deck->countDeck();
        return $this->render('json_draw_form.html.twig', ["count" => $count]);
    }

    #[Route("/api/deck/draw-many", name: "draw_json_post", methods: ['POST'])]
    public function drawCallback(
        Request $request
    ): Response {
        $num = $request->request->get("num_cards");
        return $this->redirectToRoute("json_draw_many", ["num" => $num]);
    }

    #[Route("api/deck/draw/{num<\d+>}", name: "json_draw_many")]
    public function jsonDrawMany(
        int $num,
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("deck");
        $data = [
            "draw" => $deck->draw($num),
            "count" => $deck->countDeck()
        ];
        $deck = $session->set("deck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
