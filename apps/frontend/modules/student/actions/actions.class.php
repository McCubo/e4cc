<?php

/**
 * student actions.
 *
 * @package    e4cc
 * @subpackage student
 * @author     cubiascaceres@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class studentActions extends sfActions {

    /**
     * Executes index action
     *
     */
    public function executeIndex() {
        if (!$this->getUser()->getAttribute("student_id")) {
            $this->redirect("not_found");
        }
        $this->oStudent = Doctrine_Core::getTable("Student")->find($this->getUser()->getAttribute("student_id"));
        $this->oEvaluation = $this->oStudent->getLastEvaluation();
    }

    public function executeViewFullHistory() {
        if (!$this->getUser()->getAttribute("student_id")) {
            $this->redirect("not_found");
        }
        $statement = "CALL `sp_grades_pivot`('{$this->getUser()->getAttribute("student_id")}')";
        $this->aEvaluationGrades = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll($statement);
    }

    public function executeRenderEvaluation(sfWebRequest $oRequest) {
        $aData = array('message_list' => array());
        $iEvaluationId = $oRequest->getParameter("eva_id");
        if ($iEvaluationId) {
            $oEvaluation = Doctrine_Core::getTable("Evaluation")->find($iEvaluationId);
            if (!$oEvaluation) {
                $sHtml = $this->getPartial("ErrorWhileRetrieving");
            } else {
                $sHtml = $this->getPartial("EvaluationInformation", array('oEvaluation' => $oEvaluation));
            }
        } else {
            $sHtml = $this->getPartial("ErrorWhileRetrieving");
        }
        $aData['html'] = $sHtml;
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

    public function executeBuildLineChartOverall() {
        $oStudent = Doctrine_Core::getTable("Student")->find($this->getUser()->getAttribute("student_id"));
        $aCategories = Doctrine_Core::getTable("Question")->getQuestionArray();
        $aData = array(
            'categories' => $aCategories,
            'serie_data' => array(
                array(
                    'name' => 'Target',
                    'data' => array(2, 2, 2, 2, 2),
                    'pointPlacement' => 'on',
                    'color' => '#78FF00'
                )
            )
        );
        #$oStudent = new Student();
        $oInscription = new Inscription();
        foreach ($oStudent->getInscription() as $oInscription) {
            foreach ($oInscription->getEvaluation() as $oEvaluation) {
                $studentLineChart = new StudentLineChart($oEvaluation, $aCategories);
                array_push($aData['serie_data'], $studentLineChart->getSerieArray());
            }
        }
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

    public function executeBuildLineChart() {
        $aData = array(
            'categories' => array(),
            'serie_data' => array(
                'target' => array(
                    'name' => 'Max Grade',
                    'data' => array(2, 2, 2, 2, 2),
                    'pointPlacement' => 'on',
                    'color' => '#78FF00'
                ),
                'last_eva' => array(
                    'name' => 'Grade obtained',
                    'data' => array(),
                    'pointPlacement' => 'on'
                )
            )
        );
        $oStudent = Doctrine_Core::getTable("Student")->find($this->getUser()->getAttribute("student_id"));
        $oEvaluation = $oStudent->getLastEvaluation();
        foreach ($oEvaluation->getGrade() as $oGrade) {
            array_push($aData['categories'], $oGrade->getQuestion()->getQuestionName());
            array_push($aData['serie_data']['last_eva']['data'], doubleval($oGrade->getGradeScore()));
        }
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

}
