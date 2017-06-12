<?php

class PokerRuleTest extends PokerTestCase {

    public function setUp() {
        //$this->_porkerRule = new porkerRule();
    }

    public function testFourPlayerGame() {
        // Real case
        $dealer = new Dealer(new Porker(52));
        $p1 = new Player('blade', $dealer->deal(5));
        $p2 = new Player('jeff',  $dealer->deal(5));
        $p3 = new Player('jason', $dealer->deal(5));
        $p4 = new Player('jimmy', $dealer->deal(5));
        $dealer->showCard();
        $dealer->winner();
    }

    public function testAlotCases(){
        // Test Cases
        $cnt = 1;
        $i = 0;
        while($i < $cnt) {
            $this->aDealGame();
            $i++;
        }
    }

    /* 
     * Test cases 
     * 1. deal to n player
     * 2. get the score and store to array
     * 3. sort the score array
     * 4. show result
     * 5. repeat 1-5 step.
    */
    private function aDealGame() {
        $cmpBox = array();
        $highScore = 0;

        $dealer = new Dealer(new Porker(52));
        $n = 10;

        for ($i = 0; $i < $n; $i++) {
            $p1 = new Player($i, $dealer->deal(5));

            $score = $p1->getScore();
            if ($i == 0 )  $winner = $p1;

            $cmpBox[$i] = sprintf("%d.%d%d",$score['type'], $score['num'], $score['color']);

            //if($cmpBox[$i] >= 5 )
            //    print_r($p1->showCard());

            if (max($cmpBox) > $highScore) {
                $highScore = max($cmpBox);
                $winner = $p1;
            }

        }
        $winner->showCard();
    }
}