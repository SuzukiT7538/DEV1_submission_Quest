<?php

require_once('Game.php');
require_once('Player.php');
require_once('CpuPlayer.php');
require_once('Dealer.php');
require_once('Deck.php');

$game = new Game();
$game->joinCpu();

$players = array();
$players[] = new Dealer();
$players[] = new Player('Player1');
for ($i = 1; $i < $game->playersQty; $i++) {
    $cpuName = 'CPU' . ($i);
    $players[] = new CpuPlayer($cpuName);
}
$deck = new Deck();

echo 'ブラックジャックを開始します。' . PHP_EOL;
echo 'すべてのプレイヤーに2枚ずつカードを配ります。' . PHP_EOL;
for ($i = 1; $i <= $game->playersQty; $i++) {
    $currentTurnPlayer = $players[$i];
    $game->drawCards($deck, $currentTurnPlayer, 2);
    $currentTurnPlayer->showAllHands();
    $game->showPoints($currentTurnPlayer);
    fgets(STDIN);
}

echo 'ディーラーに2枚カードを配ります。' . PHP_EOL;
$game->drawCards($deck, $players[0], 2);
$players[0]->showOneHand(0);
fgets(STDIN);

for ($i = 1; $i <= $game->playersQty; $i++) {
    if ($players[$i]->status === 'black jack') {
        echo $players[$i]->name . ' はすでにBlackJackです。' . PHP_EOL;
        $continue = false;
    } else {
        echo $players[$i]->name . ' のターンです。' . PHP_EOL;
        $game->showPoints($players[$i]);
        echo PHP_EOL;
        $continue = true;
    }
    while ($continue) {
        $continue = $players[$i]->hitOrStand($deck, $game);
        echo PHP_EOL;
    }
    echo $players[$i]->name . ' のターンが終了しました。' . PHP_EOL;
    fgets(STDIN);
}

echo PHP_EOL . 'ディーラーのターンです。';
fgets(STDIN);
$players[0]->showOneHand(1);
$game->showPoints($players[0]);
echo PHP_EOL;
fgets(STDIN);

$continue = true;
while ($continue) {
    $continue = $players[0]->hitOrStand($deck, $game);
}
echo 'カードを配り終わりました。' . PHP_EOL . PHP_EOL;
for ($i = 0; $i <= $game->playersQty; $i++) {
    $game->showPoints($players[$i]);
}

echo PHP_EOL;
$game->judgeResult($players);

echo PHP_EOL . 'ブラックジャックを終了します。' . PHP_EOL;
