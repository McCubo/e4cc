<?php

/**
 * lookup actions.
 *
 * @package    e4cc
 * @subpackage lookup
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lookupActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        //site
        $sql = "SELECT site_id, site_name FROM vw_lookup GROUP BY site_id ORDER BY site_name";
        $siteList = $q->execute($sql);
        $this->siteList = $siteList;

        //level
        $sql = "SELECT level_id, level_name FROM vw_lookup GROUP BY level_id ORDER BY level_name";
        $levelList = $q->execute($sql);
        $this->levelList = $levelList;

        //course
        $sql = "SELECT course_id, course_name FROM vw_lookup GROUP BY course_id ORDER BY course_name";
        $courseList = $q->execute($sql);
        $this->courseList = $courseList;

        //schedule
        $sql = "SELECT schedule_id, schedule FROM vw_lookup GROUP BY schedule_id ORDER BY schedule";
        $scheduleList = $q->execute($sql);
        $this->scheduleList = $scheduleList;

        //coach
        $sql = "SELECT coach_id, coach FROM vw_lookup GROUP BY coach_id ORDER BY coach";
        $coachList = $q->execute($sql);
        $this->coachList = $coachList;

        //evaluator
        $sql = "SELECT evaluator_id, evaluator FROM vw_lookup GROUP BY evaluator_id ORDER BY evaluator";
        $evaluatorList = $q->execute($sql);
        $this->evaluatorList = $evaluatorList;

        //score
        $sql = "SELECT score FROM vw_lookup GROUP BY score ORDER BY score";
        $scoreList = $q->execute($sql);
        $this->scoreList = $scoreList;

        //list
        $sql = "SELECT * FROM vw_lookup WHERE is_active = 1 ORDER BY site_name, level_name, course_name, schedule, coach, evaluator, score";
        $list = $q->execute($sql);
        $this->list = $list;

        $this->listInactive = Doctrine::getTable("Student")->findBy("is_active", 0);
    }

    public function executeGetList(sfWebRequest $request) {
        $site_id = $request->getParameter("site_id");
        $level_id = $request->getParameter("level_id");
        $course_id = $request->getParameter("course_id");
        $schedule_id = $request->getParameter("schedule_id");
        $coach_id = $request->getParameter("coach_id");
        $evaluator_id = $request->getParameter("evaluator_id");
        $score = $request->getParameter("score");
        $is_active = $request->getParameter("is_active");

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        $where = "is_active = $is_active";
        $where .= $site_id == "0" ? " AND (site_id > 0 OR site_id IS NULL)" : ($site_id == "NULL" ? " AND site_id IS NULL" : " AND site_id = $site_id");
        $where .= $level_id == "0" ? " AND (level_id > 0 OR level_id IS NULL)" : ($level_id == "NULL" ? " AND level_id IS NULL" : " AND level_id = $level_id");
        $where .= $course_id == "0" ? " AND (course_id > 0 OR course_id IS NULL)" : ($course_id == "NULL" ? " AND course_id IS NULL" : " AND course_id = $course_id");
        $where .= $schedule_id == "0" ? " AND (schedule_id > 0 OR schedule_id IS NULL)" : ($schedule_id == "NULL" ? " AND schedule_id IS NULL" : " AND schedule_id = $schedule_id");
        $where .= $coach_id == "0" ? " AND (coach_id > 0 OR coach_id IS NULL)" : ($coach_id == "NULL" ? " AND coach_id IS NULL" : " AND coach_id = $coach_id");
        $where .= $evaluator_id == "0" ? " AND (evaluator_id > 0 OR evaluator_id IS NULL)" : ($evaluator_id == "NULL" ? " AND evaluator_id IS NULL" : " AND evaluator_id = $evaluator_id");
        $where .= $score == "0" ? " AND (score > 0 OR score IS NULL)" : ($score == "NULL" ? " AND score IS NULL" : " AND score = $score");

        $sql = "SELECT * FROM vw_lookup WHERE $where ORDER BY site_name, level_name, course_name, schedule, coach, evaluator, score";
        $list = $q->execute($sql);
        $this->list = $list;
    }

    public function executeEdit(sfWebRequest $request) {
        $id = $request->getParameter("id");

        $student = new Student();
        $student = (object) Doctrine::getTable("Student")->find($id);
        $this->student = $student;

        $person = new Person();
        $person = (object) $student->getPerson();
        $this->person = $person;
    }

    public function executeUpdate(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $dui = $request->getParameter("dui");
        $first_name = $request->getParameter("first_name");
        $last_name = $request->getParameter("last_name");
        $birthdate = $request->getParameter("birthdate");
        $email = $request->getParameter("email");
        $is_active = $request->getParameter("is_active");

        $student = new Student();
        $student = (object) Doctrine::getTable("Student")->find($id);
        $student->setDui($dui);
        $student->setIsActive($is_active);
        $student->save();

        $person = new Person();
        $person = (object) $student->getPerson();
        $person->setFirstName($first_name);
        $person->setLastName($last_name);
        $person->setBirthdate($birthdate);
        $person->setEmail($email);
        $person->save();

        return true;
    }

}
