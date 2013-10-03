<?php
class Point {

    protected $x;

    protected $y;

    protected $state = 0;

    protected $_partOfWay = false;

    public function __construct($x, $y) {
        $this->setX($x);
        $this->setY($y);
    }

    /**
     * @param int $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param int $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    public function equals(\Point $point) {
        return $this->getX() == $point->getX() && $this->getY() == $point->getY();
    }

    /**
     * @param $state
     * @return $this
     */
    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    public function getState() {
        return $this->state;
    }

    /**
     * @param boolean $partOfWay
     * @return $this
     */
    public function setPartOfWay($partOfWay) {
        $this->_partOfWay = $partOfWay;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getPartOfWay() {
        return $this->_partOfWay;
    }



}