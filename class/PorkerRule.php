<?php
/**
 * Porker Rule
 * @author Jun Lin
 * @copyright Copyright &copy; 2010-2011
 */

// Porker alias name
const TYPE_ROYAL_FLUSH       = "RF";
const TYPE_STRAIGHT_FLUSH    = "SF";
const TYPE_FOUR_OF_A_KIND    = "4K";
const TYPE_FULL_HOUSE        = "FH";
const TYPE_FLUSH             = "FL";
const TYPE_BROADWAY_STRAIGHT = "BS";
const TYPE_STRAIGHT          = "ST";
const TYPE_THREE_OF_A_KIND   = "3K";
const TYPE_TWO_PAIRS         = "TP";
const TYPE_ONE_PAIR          = "OP";
const TYPE_NONE              = "NO";


class PorkerRule {

    // Power table list
    public $typeScore = array(
        "RF" => 11,
        "SF" => 10,
        "4K" => 9,
        "FH" => 8,
        "FL" => 7,
        "BS" => 6,
        "ST" => 5,
        "3K" => 4,
        "TP" => 3,
        "OP" => 2,
        "NO" => 1
    );

    public function checkFlush($cards) {
        $someKind = array();
        foreach ($cards as $val) {
            $someKind[$val->{'color'}] = $val->{'num'};
        }

        if (count($someKind) == 1) {
            return false;
            return true;//PorkerRule::TYPE_FLUSH;
        }
        return false;
    }

    public function cmpRule($cards) {
        echo $this->getScore($cards);
    }

    public function getColorScore($cards) {
        $score = array();
        $scoreColor = array('B' => 4, 'H' => 3, 'D' => 2 , 'C' => 1);
        foreach($cards as $card)
            $score[] = $scoreColor[$card->color];
        return max($score);
    }

    private function cmpNum($a, $b) {
        if ($a->num == $b->num) return 0;
        return ($a->num > $b->num) ? -1 : 1;
    }

    public function getNumScore($cards) {
        usort($cards, array('PorkerRule', 'cmpNum'));
        return $cards[0]->num;
    }

    public function getScore($cards) {

        $noType = $this->checkPokerType($cards);
        $scoreType  = $this->typeScore[$noType];                  // by type
        $scoreColor = $this->getColorScore($cards);               // by color  1 - 4
        $scoreNum   = $this->getNumScore($cards);                 // by number 1 -13
        return array("type" => $scoreType, "num" => $scoreNum, "color" => $scoreColor);
    }

    /**
     * Check all type
    */
    public function checkPokerType($cards) {

        $isFlush = $this->checkFlush($cards);
        $noType = $this->checkPokerNoType($cards);

        if ($noType == TYPE_BROADWAY_STRAIGHT && $isFlush) {
            return TYPE_ROYAL_FLUSH;
        } else if ($noType == TYPE_STRAIGHT && $isFlush) {
            return TYPE_STRAIGHT_FLUSH;
        } else if ($noType == TYPE_FOUR_OF_A_KIND) {
            return TYPE_FOUR_OF_A_KIND;
        } else if ($noType == TYPE_FULL_HOUSE) {
            return TYPE_FULL_HOUSE;
        } else if ($isFlush) {
            return TYPE_FLUSH;
        } else {
            return $noType;
        }
    }

    // Check all porker no type
    // RETURN Score
    public function checkPokerNoType($cards) {
        $someKind = array();
        $someKindCnt = array();

        foreach ($cards as $val) {
            $someKind[$val->{'num'}] = $val->{'num'};

            if (empty($someKindCnt[$val->{'num'}]))
                $someKindCnt[$val->{'num'}] = 1;
            else
                $someKindCnt[$val->{'num'}]++;
        }
        sort($someKind);
        sort($someKindCnt);
        $noCountStr = implode("",$someKindCnt);

        switch ($noCountStr) {
            case "14":
                return TYPE_FOUR_OF_A_KIND;
            case "23":
                return TYPE_FULL_HOUSE;
            case "113":
                return TYPE_THREE_OF_A_KIND;
            case "122":
                return TYPE_TWO_PAIRS;
            case "1112":
                return TYPE_ONE_PAIR;
            case "11111":
            default:

                $straightStr = join(",", array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13));
                $cardStr = join(",", $someKind);

                //assert($cardStr.''.strpos($straightStr, $cardStr));

                if ($cardStr == join("", array(1, 10, 11, 12, 13))) {
                    return TYPE_BROADWAY_STRAIGHT;
                }
                elseif (strpos($straightStr, $cardStr) > 0) {
                    return  TYPE_STRAIGHT;
                }
                else {
                    return TYPE_NONE;
                }
            break;
        }
    }
}
