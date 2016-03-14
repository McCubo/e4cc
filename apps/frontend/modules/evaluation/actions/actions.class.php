<?php

/**
 * evaluation actions.
 *
 * @package    e4cc
 * @subpackage evaluation
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class evaluationActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $course_id = $request->getParameter("course_id");
        //$course_id = 1;
        $student_id = $request->getParameter("student_id");
        //$student_id = 1;

        $course = new Course();
        $course = (object) Doctrine::getTable("Course")->find($course_id);
        $this->course = $course;

        $student = new Student();
        $student = (object) Doctrine::getTable("Student")->find($student_id);
        $this->student = $student;

        $person = new Person();
        $person = (object) $student->getPerson();
        $this->person = $person;

        $questionArray = Doctrine::getTable("Question")->findAll();
        $this->questionArray = $questionArray;
    }

    public function executeSave(sfWebRequest $request) {
        $user_id = $this->getUser()->getAttribute("user_id");
        $course_id = $request->getParameter("course_id");
        $student_id = $request->getParameter("student_id");
        $grade_array = $request->getParameter("grade_array");
        $additional_comments_array = $request->getParameter("additional_comments_array");

        $inscription = new Inscription();
        $inscription = (object) Doctrine_Core::getTable("Inscription")
                        ->createQuery("i")
                        ->where("i.is_active = ?", 1)
                        ->andWhere("i.student_id = ?", $student_id)
                        ->andWhere("i.course_id = ?", $course_id)
                        ->execute()->getLast();

        $evaluation = new Evaluation();
        $evaluation->setUserId($user_id);
        $evaluation->setInscriptionId($inscription->getId());
        $evaluation->save();

        foreach ($grade_array as $gVal) {
            $grade = new Grade();
            $grade->setQuestionId($gVal[0]);
            $grade->setEvaluationId($evaluation->getId());
            $grade->setGradeScore($gVal[1]);
            $grade->setQuestionComment($gVal[2]);
            $grade->save();

            foreach ($additional_comments_array as $cVal) {
                if ($cVal[0] == $gVal[0]) {
                    $checkboxes = new Checkboxes();
                    $checkboxes = (object) Doctrine::getTable("Checkboxes")->find($cVal[1]);

                    $additionalComments = new AdditionalComments();
                    $additionalComments->setGradeId($grade->getQuestionId());
                    $additionalComments->setAdditionalComment($checkboxes->getCheckboxName());
                    $additionalComments->save();
                }
            }
        }

        return true;
    }

}
