<?php
/**
 * Porker Game
 * Card -> Porker -> Dealer (Porker, PorkerRule) <- Player(PorkerRule)
 *                                   BigTwo or other game
 * Porker Rule
 * @author Jun Lin
 * @copyright Copyright &copy; 2010-2011
 */

class Card {
    protected $color;
    protected $num;
    protected $state = true;

    public function __set($name, $value) {
        $this->{$name} = $value;
    }

    public function __get($name) {
        return $this->{$name};
    }

    public function __construct($color, $num) {
        $this->color = $color;
        $this->num = $num;
    }
}

Interface IPorker {
    public function deal($num);
    public function rand();
}

class Porker Implements IPorker {

    protected $colors = array('B', 'H', 'D', 'C');
    private $cnt = 52;
    private $card = array();
    private $spCard = array(
            //1  => 'A',
            //11 => 'J',
            //12 => 'Q',
            //13 => 'K',
        );

    public function __construct() {
        foreach ($this->colors as $color) {
            for ($i = 1; $i <= 13; $i++) {

                $f = isset($this->spCard[$i]) ? $this->spCard[$i] : $i;
                $this->card[] = new Card($color, $f);
            }
        }
        $this->rand();
    }

    public function deal($num){
        $this->rand();
        $deal = array();

        foreach ( $this->card as $key => $val) {
            if ($val->state) {
                $deal[] = $val;
                $this->card[$key]->{'state'} = false;
            }
            if (count($deal) == $num) return $deal;
        }
        return $deal;
    }

    function noRand2($tmp, $begin=0, $end=51, $limit=13) {

        while (count($tmp)< $limit){
            $tmp[] = mt_rand($begin, $end);
            $tmp = array_unique($tmp);
        }
        return $tmp;
    }

    public function rand() {
        shuffle($this->card);
    }

    public function showCard() {
        $i = 0;
        assert($this->card);
        foreach ($this->card as $val) {
            if ($val->state) {
                echo $val->color.'-'.$val->num."\n";
                $i++;
            }
        }
        assert(sprintf("Rest %d cards\n", $i));
    }
}
