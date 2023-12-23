<?php

require_once('Game.php');
require_once('Deck.php');
require_once('Card.php');

class Player
{
    public array $hands = array();
    public array $calcPointArray = [0];
    public int $totalPoints = 0;
    public string $status = 'live';


    public function __construct(public string $name)
    {
    }

    public function showAllHands(): void
    {
        echo $this->name . 'の手札は' . PHP_EOL;
        foreach ($this->hands as $hand) {
            echo $hand->suit . 'の' . $hand->number . PHP_EOL;
        }
        echo 'です' . PHP_EOL . PHP_EOL;
    }

    public function hitOrStand(Deck $deck, Game $game): bool
    {
        echo 'もう一枚ひきますか？（Y/N）：';
        $choice = (trim(fgets(STDIN)));

        if (strcasecmp($choice, 'y') == 0) {
            $game->drawCards($deck, $this, 1);
            $continue = true;
            if ($this->status !== 'live') {
                $continue = false;
            }
        } else {
            $continue = false;
        }
        return $continue;
    }
}
