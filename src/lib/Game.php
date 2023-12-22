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
            if ($drawCount === 1) {
                $this->showDrewCard($drewCard);
            }
            $this->calcPoints($player, $drewCard);
        }
    }
    private function showDrewCard(Card $drewCard): void
    {
        echo $drewCard->suit . 'の' . $drewCard->number . PHP_EOL;
    }

    private function calcPoints(Player $player, Card $drewCard): void
    {
        $player->points += $drewCard->point;
        $this->judgeBust($player);
    }

    private function judgeBust(Player $player): void
    {
        $this->showPoints($player);
        if ($player->points > Game::BUST_LINE) {
            $player->status = 'busted';
            $player->points = 0;
            echo 'bustしました' . PHP_EOL;
        } elseif ($player->points === 21) {
            echo $player->status = 'black jack' . PHP_EOL;
        }
    }

    public function showPoints(Player $player): void
    {
        echo $player->name;
        if ($player->status === 'live') {
            echo 'のポイントは' . $player->points . 'です';
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
        if ($dealer->points > $player->points) {
            $winner = $dealer->name;
        } elseif ($dealer->points < $player->points) {
            $winner = $player->name;
        } elseif ($dealer->points === $player->points) {
          echo '-PUSH-' . PHP_EOL;
        }
        if ($winner) {
            echo $winner . ' WIN!!!!!' . PHP_EOL;
        }
    }
}
