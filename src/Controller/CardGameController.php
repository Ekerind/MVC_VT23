<?php

namespace App\Controller;

use App\Cards\Card;
use App\Cards\CardGraphic;
use App\Cards\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card/init", name: "init")]
    public function init(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $deck = new Deck();
        $deck->reset();
        $session->set("deck", $deck);

        return $this->redirectToRoute('card_index');
    }

    #[Route("/card", name: "card_index")]
    public function home(): Response
    {
        return $this->render('cards/index.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
    public function showDeck(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("deck");
        $data = [
            "deck" => $deck->groupBySuit(),
            "count" => $deck->countDeck()
        ];
        return $this->render('cards/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response
    {
        $deck = new Deck();
        $deck->reset();
        $deck->shuffle();
        $session->set("deck", $deck);
        $data = [
            "deck" => $deck->showAll(),
            "count" => $deck->countDeck()
        ];
        return $this->render('cards/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw_single")]
    public function drawSingle(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("deck");
        $data = [
            "draw" => $deck->draw(),
            "count" => $deck->countDeck()
        ];
        $deck = $session->set("deck", $deck);
        return $this->render('cards/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw-many", name: "draw_get", methods: ['GET'])]
    public function drawInit(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("deck");
        $count = $deck->countDeck();
        return $this->render('cards/draw_form.html.twig', ["count" => $count]);
    }

    #[Route("/card/deck/draw-many", name: "draw_post", methods: ['POST'])]
    public function drawCallback(
        Request $request
    ): Response
    {
        $num = $request->request->get("num_cards");
        return $this->redirectToRoute("draw_many", ["num" => $num]);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "draw_many")]
    public function drawMany(
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
        return $this->render('cards/draw.html.twig', $data);
    }
}
