<?php

require_once('Player.php');

class Dealer extends Player
{
    public string $name = 'dealer';
    public int $pointLimit = 17;
    public function __construct()
    {
    }

    public function showOneHand(int $handsNumber): void
    {
        echo $this->name . 'の' . ($handsNumber + 1) . '枚目の手札は' . PHP_EOL;
        $hand = $this->hands[$handsNumber];
        echo $hand->suit . 'の' . $hand->number . 'です' . PHP_EOL;
        if ($handsNumber === 0) {
            echo 'もう一枚はわかりません。' . PHP_EOL . PHP_EOL;
        }
    }

    public function hitOrNo(Deck $deck, Game $game): bool
    {
        if ($this->totalPoints < 17) {
            $choice = 'y';
        } else {
            echo 'ディーラーの得点が17点以上なので、ディーラーのターンを終了します。';
            $choice = 'n';
        }
        if (strcasecmp($choice, 'y') == 0) {
            $game->drawCards($deck, $this, 1);
            $continue = true;
            if ($this->status !== 'live') {
                $continue = false;
            }
        } else {
            $continue = false;
        }
        fgets(STDIN);
        return $continue;
    }
}
