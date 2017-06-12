<?php
/**
 * Dealer
 * @author Blade Lin <blade_lin@gmail.com>
 * @author Jun Lin
 * @copyright Copyright &copy; 2010-2011
 */

class Dealer {

    private $porkerRule; // Porker class
    private $porker;
    private $hand;

    public function __construct($porker) {
        $this->porker = $porker;
        $this->porkerRule = new PorkerRule();
    }

    public function getAllScore() {
        foreach($this->hand as $key => $player) {
            $cards  = array_slice($player, 0, 5, true);
            $score[] = $this->porkerRule->getScore($cards);
        }
        return $score;
    }

    public function showCard() {
        foreach($this->hand as $key => $player) {
            $cards  = array_slice($player, 0, 5, true);
            echo sprintf("Player %d : %s\n", $key+1 , $this->porkerRule->checkPokerType($cards));
            // Show Detail
            foreach($player as $card) {
                echo "\t".$card->color.'-'.$card->num."\n";
            }
            echo "\tScore : ".print_r($this->porkerRule->getScore($cards), true)."\n";
        }
    }

    public function winner() {
        $score = array();
        foreach($this->hand as $key => $player) {
            $cards  = array_slice($player, 0, 5, true);
        }
    }

    public function deal($n = 5) {
        $cards = $this->porker->deal($n);
        $this->hand[] = $cards;
        return $cards;
    }
}
