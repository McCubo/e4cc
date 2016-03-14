<?php

/**
 * Description of StudentLineChart
 *
 * @author cubiascaceres@gmail.com
 * 
 */
class StudentLineChart {

    private $_oEvaluation;
    private $_aCategories;

    public function __construct($oEvaluation, $aCategories) {
        $this->_oEvaluation = $oEvaluation;
        $this->_aCategories = $aCategories;
    }

    public function getSerieArray() {
        $aData = array_fill(0, count($this->_aCategories), 0);
        foreach ($this->_oEvaluation->getGrade() as $oGrade) {
            $aData[array_search($oGrade->getQuestion()->getQuestionName(), $this->_aCategories)] = floatval($oGrade->getGradeScore());
        }
        $aSerie = array(
            'name' => date("l - F jS, Y", strtotime($this->_oEvaluation->getEvaluationDate())),
            'data' => $aData
        );
        return $aSerie;
    }

}
