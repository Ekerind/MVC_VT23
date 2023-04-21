<?php

namespace App\Cards;

class Card
{
    protected $value;
    protected $suit;

    public function __construct($value, $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getSuit(): string
    {
        return "{$this->suit}";
    }

    public function getCard(): string
    {
        return "{$this->value}{$this->suit}";
    }
}
