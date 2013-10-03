<?php
include('Interface.php');

class Labyrinth_Renderer_Html implements Labyrinth_Renderer_Interface {

    const BORDER_STYLE = '1px solid black;';

    const TILE_PATTERN = '<td style="%s %s %s %s" class="%s"><span class="state">%s</span></td>';

    /** @var \Labyrinth_Base */
    protected $_labyrinth;

    public function render(\Labyrinth_Base $labyrinth) {
        $this->_labyrinth = $labyrinth;
        return $this;
    }

    public function __toString() {
        $html = '<table>';

        for($i = 0; $i < $this->_labyrinth->getSizeX(); $i++) {
            $html .= '<tr>';
            for($j = 0; $j < $this->_labyrinth->getSizeY(); $j++) {
                $leftEdge = $this->_labyrinth->hasLeftEdge($i, $j) ? 'border-left: ' . self::BORDER_STYLE : '';
                $rightEdge = $this->_labyrinth->hasRightEdge($i, $j) ? 'border-right: ' . self::BORDER_STYLE : '';
                $topEdge = $this->_labyrinth->hasTopEdge($i, $j) ? 'border-top: ' . self::BORDER_STYLE : '';
                $bottomEdge = $this->_labyrinth->hasBottomEdge($i, $j) ? 'border-bottom: ' . self::BORDER_STYLE : '';

                $currentPoint = $this->_labyrinth->getPoint($i, $j);
                $keyPointClass = '';
                if($currentPoint->equals($this->_labyrinth->getStartPoint())) {
                    $keyPointClass = 'startPoint ';
                } elseif($currentPoint->equals($this->_labyrinth->getEndPoint())) {
                    $keyPointClass = 'endPoint ';
                }

                $keyPointClass .= $currentPoint->getPartOfWay() ? 'partOfWay' : '';

                $point = $this->_labyrinth->getPoint($i, $j);

                $html .= sprintf(self::TILE_PATTERN, $leftEdge, $rightEdge, $topEdge, $bottomEdge, $keyPointClass, $point->getState());
            }
            $html .= '</tr>';
        }

        $html .= '</table>';

        $html .= '<style type="text/css">
            table {
                border-collapse: collapse;
            }
            td{
                width: 20px;
                height:20px;
                margin: 0px;
                padding: 0px;
            }

            tr {
                margin: 0px;
                padding: 0px;
            }

            .startPoint {
                background-color: #eee !important;
            }

            .endPoint {
                background-color: #999;
            }

            .partOfWay {
                background-color: green;
            }
        </style>';

        return $html;
    }

}