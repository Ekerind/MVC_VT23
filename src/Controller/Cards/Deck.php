<?php

namespace App\Cards;

use App\Cards\Card;

class Deck
{
    private $deck = [];

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function sortDeck(): void
    {
        sort($this->deck);
    }

    public function reset(string $cardType = ''): void // Argument 'plain' choses a different set of cards for the deck
    {
        $this->deck = [];
        $suits = ['s', 'h', 'd', 'c']; //Spades, hearts, diamonds, clubs

        if ($cardType == 'plain') {
            foreach ($suits as $suit) {
                for ($i = 1; $i <= 13; $i++) {
                    $card = new Card($i, $suit);
                    $this->deck[] = $card;
                }
            }
        } else {
            foreach ($suits as $suit) {
                for ($i = 1; $i <= 13; $i++) {
                    $card = new CardGraphic($i, $suit);
                    $this->deck[] = $card;
                }
            }
        }
    }

    public function draw(int $amount = 1): array
    {
        $drawnCards = [];
        for ($i = 0; $i < $amount; $i++) {
            $card = array_shift($this->deck);
            $drawnCards[] = $card->getCard();
        }
        return $drawnCards;
    }

    public function showAll(): array
    {
        $allCards = [];
        foreach ($this->deck as $card) {
            $allCards[] = $card->getCard();
        }
        return $allCards;
    }

    public function groupBySuit(): array
    {
        $allCards = $this->showAll();
        $grouped = array_reduce($allCards, function ($suit, $card) {
            $prefix = substr($card, 0, -2);
            $suit[$prefix][] = $card;
            return $suit;
        }, array());

        foreach ($grouped as &$suits) {
            sort($suits);
        }

        return $grouped;
    }

    public function countDeck(): int
    {
        return count($this->deck);
    }
}
