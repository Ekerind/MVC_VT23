<?php

namespace App\Cards;

class CardGraphic extends Card
{
    private $cardGraphics = "";

    private $suits = array(
        's' => 'A',
        'h' => 'B',
        'd' => 'C',
        'c' => 'D'
    );

    private $values = array(
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => 'A',
        '11' => 'B',
        '12' => 'D',
        '13' => 'E'
    );

    public function __construct($value, $suit)
    {
        parent::__construct($value, $suit);
        $this->cardGraphics = '&#x1F0' . $this->suits[$this->suit] . $this->values[$this->value] . ';';
    }

    public function getCard(): string
    {
        return $this->cardGraphics;
    }
}
