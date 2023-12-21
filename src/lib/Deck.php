<?php

require_once('Card.php');

class Deck
{
    public array $pooledCards = array();
    private array $suits = ['spade', 'club', 'heart', 'diamond'];
    public function __construct()
    {
        foreach ($this->suits as $suit) {
            for ($i = 1; $i <= 13; $i++) {
                $this->pooledCards[] = new Card($i, $suit,);
            }
            $this->assignPointsToCards();
        }
    }
    private function assignPointsToCards(): void
    {
        $is10PointCards = [10, 11, 12, 13];
        foreach ($this->pooledCards as $card) {
            if (in_array($card->number, $is10PointCards)) {
                $card->point = 10;
            } else {
                $card->point = $card->number;
            }
        }
    }
}
