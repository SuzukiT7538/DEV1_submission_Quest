<?php

class Card
{
    public int $point = 0 ;
    public function __construct(public int $number, public string $suit)
    {
    }
}
