<?php
include('Point.php');
include('Renderer/Html.php');

class Labyrinth_Base {

    protected $_sizeX = 8;

    protected $_sizeY = 8;

    protected $_tilesMap = array();

    protected $_verticalEdgesMap = array();

    protected $_horizontalEdgesMap = array();

    protected $_startPoint;

    protected $_endPoint;

    /** @var  \Labyrinth_Renderer_Html */
    protected $_renderer;

    public function __construct() {
        $this->_initTileMap();
        $this->_initStartAndStopPoints();
        $this->_initVerticalEdgesMap();
        $this->_initHorizontalEdgesMap();

        $this->_renderer = new Labyrinth_Renderer_Html();
    }

    protected function _initTileMap() {
        for ($i = 0; $i < $this->_sizeX; $i++) {
            $this->_tilesMap[$i] = array();
            for ($j = 0; $j < $this->_sizeY; $j++) {
                $this->_tilesMap[$i][$j] = new Point($i, $j);
            }
        }
    }

    protected function _initStartAndStopPoints() {
        $this->_startPoint = $this->_tilesMap[0][0];
        $this->_endPoint = $this->_tilesMap[7][7];
    }

    protected function _initVerticalEdgesMap() {
        $this->_verticalEdgesMap = array_fill(0, $this->_sizeX, array_fill(0, $this->_sizeY, 0));
        $this->_verticalEdgesMap[0][6] = 1;
        $this->_verticalEdgesMap[1][0] = 1;
        $this->_verticalEdgesMap[1][2] = 1;
        $this->_verticalEdgesMap[1][3] = 1;
        $this->_verticalEdgesMap[1][4] = 1;
        $this->_verticalEdgesMap[1][5] = 1;
        $this->_verticalEdgesMap[2][0] = 1;
        $this->_verticalEdgesMap[2][1] = 1;
        $this->_verticalEdgesMap[2][2] = 1;
        $this->_verticalEdgesMap[2][3] = 1;
        $this->_verticalEdgesMap[2][4] = 1;
        $this->_verticalEdgesMap[2][5] = 1;
        $this->_verticalEdgesMap[2][6] = 1;
        $this->_verticalEdgesMap[3][0] = 1;
        $this->_verticalEdgesMap[3][1] = 1;
        $this->_verticalEdgesMap[3][3] = 1;
        $this->_verticalEdgesMap[3][4] = 1;
        $this->_verticalEdgesMap[4][0] = 1;
        $this->_verticalEdgesMap[4][1] = 1;
        $this->_verticalEdgesMap[4][5] = 1;
        $this->_verticalEdgesMap[4][6] = 1;
        $this->_verticalEdgesMap[5][0] = 1;
        $this->_verticalEdgesMap[5][3] = 1;
        $this->_verticalEdgesMap[5][4] = 1;
        $this->_verticalEdgesMap[5][5] = 1;
        $this->_verticalEdgesMap[6][0] = 1;
        $this->_verticalEdgesMap[6][3] = 1;
        $this->_verticalEdgesMap[6][4] = 1;
        $this->_verticalEdgesMap[6][6] = 1;
        $this->_verticalEdgesMap[7][5] = 1;
        $this->_verticalEdgesMap[7][6] = 1;
    }

    protected function _initHorizontalEdgesMap() {
        $this->_horizontalEdgesMap = array_fill(0, $this->_sizeX, array_fill(0, $this->_sizeY, 0));
        $this->_horizontalEdgesMap[0][1] = 1;
        $this->_horizontalEdgesMap[0][5] = 1;
        $this->_horizontalEdgesMap[1][1] = 1;
        $this->_horizontalEdgesMap[1][3] = 1;
        $this->_horizontalEdgesMap[1][7] = 1;
        $this->_horizontalEdgesMap[2][2] = 1;
        $this->_horizontalEdgesMap[2][6] = 1;
        $this->_horizontalEdgesMap[3][3] = 1;
        $this->_horizontalEdgesMap[3][4] = 1;
        $this->_horizontalEdgesMap[4][2] = 1;
        $this->_horizontalEdgesMap[4][5] = 1;
        $this->_horizontalEdgesMap[4][7] = 1;
        $this->_horizontalEdgesMap[5][1] = 1;
        $this->_horizontalEdgesMap[5][2] = 1;
        $this->_horizontalEdgesMap[5][6] = 1;
        $this->_horizontalEdgesMap[6][2] = 1;
        $this->_horizontalEdgesMap[6][3] = 1;
        $this->_horizontalEdgesMap[6][4] = 1;
    }

    public function render() {
        return $this->_renderer->render($this);
    }

    public function hasLeftEdge($x, $y) {
        if($y == 0) {
            return true;
        }

        if($this->_verticalEdgesMap[$x][$y-1]) {
            return true;
        }

        return false;
    }

    public function hasRightEdge($x, $y) {
        if($y == $this->_sizeY - 1) {
            return true;
        }

        if($this->_verticalEdgesMap[$x][$y]) {
            return true;
        }

        return false;
    }

    public function hasTopEdge($x, $y) {
        if($x == 0) {
            return true;
        }

        if($this->_horizontalEdgesMap[$x-1][$y]) {
            return true;
        }

        return false;
    }

    public function hasBottomEdge($x, $y) {
        if($x == $this->_sizeX - 1) {
            return true;
        }

        if($this->_horizontalEdgesMap[$x][$y]) {
            return true;
        }

        return false;
    }

    /**
     * @param $x
     * @param $y
     * @throws Exception
     * @return \Point
     */
    public function getPoint($x, $y) {
        if($x < 0 || $y < 0) {
            throw new Exception('Cant find point!');
        }
        return $this->_tilesMap[$x][$y];
    }

    /**
     * @return \Point
     */
    public function getStartPoint() {
        return $this->_startPoint;
    }

    /**
     * @return \Point
     */
    public function getEndPoint() {
        return $this->_endPoint;
    }

    /**
     * @param \Point $point
     * @return \Point[]
     */
    public function getAdjacentPoints(\Point $point) {
        $points = array();

        // look left
        if(!$this->hasLeftEdge($point->getX(), $point->getY())) {
            $points [] = $this->getPoint($point->getX(), $point->getY() - 1);
        }

        // look right
        if(!$this->hasRightEdge($point->getX(), $point->getY())) {
            $points [] = $this->getPoint($point->getX(), $point->getY() + 1);
        }

        // look up
        if(!$this->hasTopEdge($point->getX(), $point->getY())) {
            $points [] = $this->getPoint($point->getX() - 1, $point->getY());
        }

        // look down
        if(!$this->hasBottomEdge($point->getX(), $point->getY())) {
            $points [] = $this->getPoint($point->getX() + 1, $point->getY());
        }

        return $points;
    }

    /**
     * @param int $sizeX
     */
    public function setSizeX($sizeX)
    {
        $this->_sizeX = $sizeX;
    }

    /**
     * @return int
     */
    public function getSizeX()
    {
        return $this->_sizeX;
    }

    /**
     * @param int $sizeY
     */
    public function setSizeY($sizeY)
    {
        $this->_sizeY = $sizeY;
    }

    /**
     * @return int
     */
    public function getSizeY()
    {
        return $this->_sizeY;
    }



}