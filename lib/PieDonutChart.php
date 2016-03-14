<?php

/**
 * Description of PieDonutChart
 *
 * @author cubiascaceres@gmail.com
 */
class PieDonutChart {

    public $y = 0;
    public $aCategories = array();
    public $aData = array();

    public function addY($iValue) {
        $this->y += $iValue;
    }

    function addCategory($sCategory) {
        array_push($this->aCategories, $sCategory);
    }

    function addData($dData) {
        array_push($this->aData, $dData);
    }

}
