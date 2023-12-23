<?php

require_once('Player.php');

class Dealer extends Player
{
    public string $name = 'dealer';
    private int $pointLimit = 17;
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

    public function hitOrStand(Deck $deck, Game $game): bool
    {
        if ($this->totalPoints < $this->pointLimit) {
            $game->drawCards($deck, $this, 1);
            $continue = true;
            if ($this->status !== 'live') {
                $continue = false;
            }
        } else {
            echo 'ディーラーの得点が17点以上なので、ディーラーのターンを終了します。';
            $continue = false;
        }
        fgets(STDIN);
        return $continue;
    }
}
