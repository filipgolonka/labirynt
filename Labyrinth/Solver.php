<?php
class Labyrinth_Solver {

    /** @var \Labyrinth_Base */
    protected $_labyrinth;

    /** @var \Point[] */
    protected $_queue = array();

    public function __construct(\Labyrinth_Base $labyrinth) {
        $this->_labyrinth = $labyrinth;
        $this->_queue [] = $this->_labyrinth->getStartPoint()->setState(1);
    }

    public function solve() {
        /** @var $point \Point */
        while($point = array_shift($this->_queue)) {
            $this->_visitAdjacentPoints($point);
        }

        $point = $this->_labyrinth->getEndPoint();
        while(!$point->equals($this->_labyrinth->getStartPoint())) {
            $point = $this->_markPreviousPointAsPartOfWay($point);
        }
    }

    /**
     * @param \Point $point
     */
    protected function _visitAdjacentPoints(\Point $point) {
        foreach ($this->_labyrinth->getAdjacentPoints($point) as $adjacentPoint) {
            if ($adjacentPoint->getState() == 0 || $adjacentPoint->getState() > $point->getState()) {
                $this->_queue [] = $adjacentPoint->setState($point->getState() + 1);
            }
        }
    }

    /**
     * @param $point
     * @return Point
     */
    protected function _markPreviousPointAsPartOfWay($point) {
        foreach ($this->_labyrinth->getAdjacentPoints($point) as $adjacentPoint) {
            if ($adjacentPoint->getState() < $point->getState()) {
                $adjacentPoint->setPartOfWay(true);
                $point = $adjacentPoint;
                break;
            }
        }
        return $point;
    }

}