<?php
/**
 * Player
 * @author Jun Lin
 * @copyright Copyright &copy; 2010-2011
 */


Interface IPlayer {
    public function showCard();
}

class Player Implements IPlayer {

    private $porkerRule;
    private $playerName;
    private $card;
    private $hand; //game rule

    public function __construct($playerName, $card) {

        $this->playerName = $playerName;
        $this->card = $card;
        $this->porkerRule = new PorkerRule();
        $this->sortCard();
    }

    private function sortCard() {
        sort($this->card);
    }

    public function showCard() {
        $cards  = array_slice($this->card, 0, 5, true);
        echo $this->porkerRule->checkPokerType($cards)."\n";

        foreach($cards as $card) {
            echo "\t".$card->color.'-'.$card->num."\n";
        }
        $score = $this->porkerRule->getScore($cards);
        echo "\tScore : ".$score['type'].'.'.$score['num'].$score['color']."\n";
    }

    public function getScore() {

        $cards  = array_slice($this->card, 0, 5, true);
        //print_r($this->card);
        return $this->porkerRule->getScore($cards);
    }

}