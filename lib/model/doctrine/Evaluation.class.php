<?php

/**
 * Evaluation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    e4cc
 * @subpackage model
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Evaluation extends BaseEvaluation {

    public function getFinalScore() {
        $iFinalScore = 0;
        foreach ($this->getGrade() as $oGrade) {
            $iFinalScore += $oGrade->getGradeScore();
        }
        return $iFinalScore;
    }

    public function getPanelClass() {
        if ($this->getFinalScore() > 8.5) {
            return "panel-success";
        } elseif ($this->getFinalScore() > 6) {
            return "panel-info";
        } elseif ($this->getFinalScore() > 4) {
            return "panel-warning";
        } else {
            return "panel-danger";
        }
    }

}
