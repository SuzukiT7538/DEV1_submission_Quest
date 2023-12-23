<?php

// require_once('Deck.php');

class Game
{
    private const BUST_LINE = 21;
    public const MAX_CPU_QTY = 2;
    public int $playersQty = 1;

    public function joinCpu(): void
    {
        $continue = true;
        while ($continue) {
            echo 'CPUの数を選んでください（最大2人）：';
            $joinedCpuQty = trim(fgets(STDIN));
            $cpuQtyIsOver = $joinedCpuQty > Game::MAX_CPU_QTY;
            $continue = false;
            if ($cpuQtyIsOver) {
                echo 'CPUは最大2人までです' . PHP_EOL . PHP_EOL;
                $continue = true;
            }
        }
        $this->playersQty += (int) $joinedCpuQty;
        echo PHP_EOL;
    }

    public function drawCards(Deck $deck, Player $player, int $drawCount): void
    {
        $drewCardNumbers = (array) array_rand($deck->pooledCards, $drawCount) ;
        foreach ($drewCardNumbers as $drewCardNumber) {
            $drewCard = $deck->pooledCards[$drewCardNumber];
            $player->hands[] = $drewCard;
            unset($deck->pooledCards[$drewCardNumber]);
            $this->calcPoints($player, $drewCard);
            if ($drawCount === 1) {
                $this->showDrewCard($drewCard);
                $this->showPoints($player);
            }
            $this->judgeBust($player);
        }
    }
    private function showDrewCard(Card $drewCard): void
    {
        echo $drewCard->suit . 'の' . $drewCard->number . PHP_EOL;
    }

    private function calcPoints(Player $player, Card $drewCard): void
    {
        $player->calcPointArray[] = $drewCard->point;
        $player->totalPoints = array_sum($player->calcPointArray);
        $aceCard = array_search(1, $player->calcPointArray);
        if ($aceCard && ($player->totalPoints + 10) <=  21) {
            $player->calcPointArray[$aceCard] = 11;
            $player->totalPoints = array_sum($player->calcPointArray);
        }
        $aceCard = array_search(11, $player->calcPointArray);
        if ($aceCard && $player->totalPoints > 21) {
            $player->calcPointArray[$aceCard] = 1;
            $player->totalPoints = array_sum($player->calcPointArray);
        }
    }

    private function judgeBust(Player $player): void
    {
        if ($player->totalPoints > Game::BUST_LINE) {
            $player->status = 'busted';
            $player->totalPoints = 0;
            echo 'bustしました' . PHP_EOL;
        } elseif ($player->totalPoints === 21) {
            $player->status = 'black jack';
        }
    }

    public function showPoints(Player $player): void
    {
        echo $player->name;
        if ($player->status === 'live') {
            echo 'のポイントは' . $player->totalPoints . 'です';
        } elseif ($player->status === 'black jack') {
            echo 'はBlack Jackです!';
        } elseif ($player->status === 'busted') {
            echo 'はbustしています';
        }
        echo PHP_EOL;
    }

    public function judgeResult(array $players): void
    {
        $dealer = $players[0];
        for ($i = 1; $i <= $this->playersQty; $i++) {
            $judgedPlayer = $players[$i];
            if ($dealer->totalPoints > $judgedPlayer->totalPoints) {
                echo $judgedPlayer->name . ' is Lose' . PHP_EOL;
            } elseif ($dealer->totalPoints < $judgedPlayer->totalPoints) {
                echo $judgedPlayer->name . ' is Win' . PHP_EOL;
            } else {
                echo $judgedPlayer->name . ' is Push' . PHP_EOL;
            }
        }
    }
}
