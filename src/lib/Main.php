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
fgets(STDIN);

echo 'ディーラーに２枚カードを配ります。' . PHP_EOL;
$game->drawCards($deck, $dealer, 2);
$dealer->showOneHand(0);
fgets(STDIN);

$game->showPoints($player1);
$continue = true;
while ($continue) {
    $continue = $player1->hitOrNo($deck, $game);
}

echo PHP_EOL . 'ディーラーのターンです。';
fgets(STDIN);
$dealer->showOneHand(1);
$game->showPoints($dealer);
echo PHP_EOL;
fgets(STDIN);

$continue = true;
while ($continue) {
    $continue = $dealer->hitOrNo($deck, $game);
}
echo 'カードを配り終わりました。' . PHP_EOL . PHP_EOL;
$game->showPoints($player1);
$game->showPoints($dealer);

$game->judgeResult($player1, $dealer);

echo 'ブラックジャックを終了します。' . PHP_EOL;
