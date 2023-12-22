<?php

require_once('Deck.php');
require_once('Card.php');

class Game
{
    private const BUST_LINE = 21;

    public function drawCards(Deck $deck, Player $player, int $drawCount): void
    {
        $drewCardNumbers = (array) array_rand($deck->pooledCards, $drawCount) ;
        foreach ($drewCardNumbers as $drewCardNumber) {
            $drewCard = $deck->pooledCards[$drewCardNumber];
            if ($drewCard->number === 1) {
                $player->hasA = true;
            }
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
            echo $player->status = 'black jack' . PHP_EOL;
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

    public function judgeResult(Player $dealer, Player $player): void
    {
        $winner = '';
        if ($dealer->totalPoints > $player->totalPoints) {
            $winner = $dealer->name;
        } elseif ($dealer->totalPoints < $player->totalPoints) {
            $winner = $player->name;
        } elseif ($dealer->totalPoints === $player->totalPoints) {
            echo '-PUSH-' . PHP_EOL;
        }
        if ($winner) {
            echo $winner . ' WIN!!!!!' . PHP_EOL;
        }
    }
}
