<?php

require_once('Player.php');

class CpuPlayer extends Player
{
    public function hitOrStand(Deck $deck, Game $game): bool
    {
        $cpuChoice = ['y', 'n'];
        $choiceKey = array_rand($cpuChoice, 1);
        $choice = $cpuChoice[$choiceKey];
        if (strcasecmp($choice, 'y') == 0) {
            $game->drawCards($deck, $this, 1);
            $continue = true;
            if ($this->status !== 'live') {
                $continue = false;
            }
        } else {
            echo $this->name . '：スタンド' . PHP_EOL;
            $continue = false;
        }
        return $continue;
    }
}
