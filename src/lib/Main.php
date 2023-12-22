<?php

require_once('Game.php');
require_once('Player.php');
require_once('Dealer.php');
require_once('Deck.php');


$player1 = new Player('player1');
$dealer = new Dealer();
$deck = new Deck();
$theNumberOfCurrentPlayers = 1;
$game = new Game();
echo 'ブラックジャックを開始します。' . PHP_EOL;
echo 'あなたに２枚カードを配ります。' . PHP_EOL;
$game->drawCards($deck, $player1, 2);
$player1->showAllHands();
$game->drawCards($deck, $dealer, 2);
$dealer->showOneHand(0);
$game->showPoints($player1);
$choiceHit = true;
while ($choiceHit) {
    $choiceHit = $player1->hitOrNo($deck, $game);
}

echo PHP_EOL . 'ディーラーのターンです。';
fgets(STDIN);
$dealer->showOneHand(1);
$game->showPoints($dealer);
echo PHP_EOL;

fgets(STDIN);
$choiceHit = true;
while ($choiceHit) {
    $choiceHit = $dealer->hitOrNo($deck, $game);
}
echo 'カードが配り終わりました。' . PHP_EOL . PHP_EOL;
$game->showPoints($player1);
$game->showPoints($dealer);

$game->judgeResult($player1, $dealer);

echo 'ブラックジャックを終了します。' . PHP_EOL;
