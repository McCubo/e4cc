<?php

/**
 * course actions.
 *
 * @package    e4cc
 * @subpackage course
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->list = Doctrine::getTable("Course")->findBy("is_active", 1);
        $this->listInactive = Doctrine::getTable("Course")->findBy("is_active", 0);

        $siteArray = Doctrine::getTable("Site")->findBy("is_active", 1);
        $this->siteArray = $siteArray;

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $levelArray = $q->execute("
            SELECT l.* FROM course c
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            WHERE l.is_active = 1
            GROUP BY l.id
        ");
        $this->levelArray = $levelArray;

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $userArray = $q->execute("
            SELECT u.*, p.first_name, p.last_name FROM course c
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            INNER JOIN user u ON c.user_id = u.id
            INNER JOIN person p ON u.person_id = p.id
            WHERE u.is_active = 1
            GROUP BY u.id
        ");
        $this->userArray = $userArray;
    }

    public function executeGetList(sfWebRequest $request) {
        $site_id = $request->getParameter("site_id");
        $level_id = $request->getParameter("level_id");
        $user_id = $request->getParameter("user_id");
        $is_active = $request->getParameter("is_active");

        $where = $site_id == 0 ? "s.id > 0" : "s.id = $site_id";
        $where .= $level_id == 0 ? " AND l.id > 0" : " AND l.id = $level_id";
        $where .= $user_id == 0 ? " AND u.id > 0" : " AND u.id = $user_id";

        $sql = "SELECT c.id, s.site_name, l.level_name, c.course_name, sc.start, sc.end, sc.description, p.first_name, p.last_name, 
                (SELECT COUNT(i.id) FROM inscription i WHERE i.course_id = c.id AND i.is_active = 1) AS total_inscription
                FROM course c
                INNER JOIN level l ON c.level_id = l.id
                INNER JOIN schedule sc ON c.schedule_id = sc.id
                INNER JOIN class_room cr ON c.class_room_id = cr.id
                INNER JOIN site s ON cr.site_id = s.id
                INNER JOIN user u ON c.user_id = u.id
                INNER JOIN person p ON u.person_id = p.id
                WHERE $where AND c.is_active = $is_active";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute($sql);
        $this->list = $list;
    }

    public function executeGetLevel(sfWebRequest $request) {
        $site_id = $request->getParameter("site_id");

        $where = $site_id == 0 ? "s.id > 0" : "s.id = $site_id";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute("
            SELECT l.* FROM course c
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            WHERE $where AND l.is_active = 1
            GROUP BY l.id
        ");
        $this->list = $list;
    }

    public function executeGetCoach(sfWebRequest $request) {
        $site_id = $request->getParameter("site_id");
        $level_id = $request->getParameter("level_id");

        $where = $site_id == 0 ? "s.id > 0" : "s.id = $site_id";
        $where .= $level_id == 0 ? " AND l.id > 0" : " AND l.id = $level_id";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute("
            SELECT u.*, p.first_name, p.last_name FROM course c
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            INNER JOIN user u ON c.user_id = u.id
            INNER JOIN person p ON u.person_id = p.id
            WHERE $where AND u.is_active = 1
            GROUP BY u.id
        ");
        $this->list = $list;
    }

    public function executeGetClassRoom(sfWebRequest $request) {
        $site_id = $request->getParameter("site_id");

        $q = Doctrine_Core::getTable("ClassRoom")
                ->createQuery("cr")
                ->where("cr.is_active = ?", 1)
                ->andWhere("cr.site_id = ?", $site_id);
        $list = $q->execute();
        $this->list = $list;
    }

    public function executeNew(sfWebRequest $request) {
        $levelArray = Doctrine::getTable("Level")->findBy("is_active", 1);
        $this->levelArray = $levelArray;

        $siteArray = Doctrine::getTable("Site")->findBy("is_active", 1);
        $this->siteArray = $siteArray;

        $scheduleArray = Doctrine::getTable("Schedule")->findBy("is_active", 1);
        $this->scheduleArray = $scheduleArray;

        $userArray = Doctrine::getTable("User")->findBy("is_active", 1);
        $this->userArray = $userArray;
    }

    public function executeSave(sfWebRequest $request) {
        $course_name = $request->getParameter("course_name");
        $level_id = $request->getParameter("level_id");
        $class_room_id = $request->getParameter("class_room_id");
        $schedule_id = $request->getParameter("schedule_id");
        $user_id = $request->getParameter("user_id");

        $course = new Course();
        $course->setLevelId($level_id);
        $course->setUserId($user_id);
        $course->setClassRoomId($class_room_id);
        $course->setScheduleId($schedule_id);
        $course->setCourseName($course_name);
        $course->save();

        $this->getResponse()->setContent($course->getId());
        return sfView::NONE;
    }

    public function executeEdit(sfWebRequest $request) {
        $id = $request->getParameter("id");

        $course = new Course();
        $course = (object) Doctrine::getTable("Course")->find($id);
        $this->course = $course;

        $levelArray = Doctrine::getTable("Level")->findBy("is_active", 1);
        $this->levelArray = $levelArray;

        $siteArray = Doctrine::getTable("Site")->findBy("is_active", 1);
        $this->siteArray = $siteArray;

        $scheduleArray = Doctrine::getTable("Schedule")->findBy("is_active", 1);
        $this->scheduleArray = $scheduleArray;

        $userArray = Doctrine::getTable("User")->findBy("is_active", 1);
        $this->userArray = $userArray;

        $q = Doctrine_Core::getTable("ClassRoom")
                ->createQuery("cr")
                ->where("cr.is_active = ?", 1)
                ->andWhere("cr.site_id = ?", $course->getClassRoom()->getSiteId());
        $classRoomArray = $q->execute();
        $this->classRoomArray = $classRoomArray;

        $q = Doctrine_Core::getTable("Inscription")
                ->createQuery("i")
                ->where("i.is_active = ?", 1)
                ->andWhere("i.course_id = ?", $id);
        $inscriptionArray = $q->execute();
        $this->inscriptionArray = $inscriptionArray;

        $sql = "
            SELECT 
                ins.id,
                ins.student_id,
                per.first_name,
                per.last_name,
                (
                    SELECT edate.evaluation_date 
                    FROM evaluation edate 
                    WHERE edate.inscription_id = ins.id
                    ORDER BY edate.evaluation_date DESC
                    LIMIT 1
                ) AS last_evaluation_date, 
                (
                    SELECT SUM(gra_escore.grade_score)
                    FROM evaluation escore 
                    INNER JOIN grade gra_escore ON escore.id = gra_escore.evaluation_id
                    WHERE escore.inscription_id = ins.id  
                    GROUP BY gra_escore.evaluation_id
                    ORDER BY escore.evaluation_date DESC
                    LIMIT 1
                ) AS last_evaluation_score,
                (
                    SELECT NULLIF(COUNT(*), 0)
                    FROM evaluation etotal
                    WHERE etotal.inscription_id = ins.id
                ) AS total_evaluations,
                (
                    SELECT AVG(gra_eavg.grade_score) * 5
                    FROM evaluation eavg 
                    INNER JOIN grade gra_eavg ON eavg.id = gra_eavg.evaluation_id
                    WHERE eavg.inscription_id = ins.id
                ) AS average_score
            FROM inscription ins 
            INNER JOIN student stu ON stu.id = ins.student_id 
            INNER JOIN person per ON per.id = stu.person_id 
            WHERE ins.course_id = $id AND ins.is_active = 1
        ";
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute($sql);
        $this->list = $list;
    }

    public function executeGetListInscription(sfWebRequest $request) {
        $id = $request->getParameter("id");

        $sql = "
            SELECT 
                ins.id,
                ins.student_id,
                per.first_name,
                per.last_name,
                (
                    SELECT edate.evaluation_date 
                    FROM evaluation edate 
                    WHERE edate.inscription_id = ins.id
                    ORDER BY edate.evaluation_date DESC
                    LIMIT 1
                ) AS last_evaluation_date, 
                (
                    SELECT SUM(gra_escore.grade_score)
                    FROM evaluation escore 
                    INNER JOIN grade gra_escore ON escore.id = gra_escore.evaluation_id
                    WHERE escore.inscription_id = ins.id  
                    GROUP BY gra_escore.evaluation_id
                    ORDER BY escore.evaluation_date DESC
                    LIMIT 1
                ) AS last_evaluation_score,
                (
                    SELECT NULLIF(COUNT(*), 0)
                    FROM evaluation etotal
                    WHERE etotal.inscription_id = ins.id
                ) AS total_evaluations,
                (
                    SELECT AVG(gra_eavg.grade_score) * 5
                    FROM evaluation eavg 
                    INNER JOIN grade gra_eavg ON eavg.id = gra_eavg.evaluation_id
                    WHERE eavg.inscription_id = ins.id
                ) AS average_score
            FROM inscription ins 
            INNER JOIN student stu ON stu.id = ins.student_id 
            INNER JOIN person per ON per.id = stu.person_id 
            WHERE ins.course_id = $id AND ins.is_active = 1
        ";
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute($sql);
        $this->list = $list;
    }

    public function executeUpdate(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $course_name = $request->getParameter("course_name");
        $level_id = $request->getParameter("level_id");
        $class_room_id = $request->getParameter("class_room_id");
        $schedule_id = $request->getParameter("schedule_id");
        $user_id = $request->getParameter("user_id");
        $is_active = $request->getParameter("is_active");

        $course = new Course();
        $course = (object) Doctrine::getTable("Course")->find($id);

        $course->setLevelId($level_id);
        $course->setUserId($user_id);
        $course->setClassRoomId($class_room_id);
        $course->setScheduleId($schedule_id);
        $course->setCourseName($course_name);
        $course->setIsActive($is_active);
        $course->save();

        return true;
    }

    public function executeGetStudent(sfWebRequest $request) {
        $term = $request->getParameter("term");

        $q = Doctrine_Core::getTable("Student")
                ->createQuery("s")
                ->innerJoin("s.Person p")
                ->innerJoin("s.Inscription")
                ->where('p.first_name LIKE ?', "%$term%")
                ->orWhere('p.last_name LIKE ?', "%$term%")
                ->andWhere("s.is_active = ?", 1);
        $list = $q->execute();

        $sql = "
            SELECT 
                    s.id,
                    s.dui,
                    s.person_id,
                    p.first_name,
                    p.last_name,
                    p.email,
                    c.id AS course_id,
                    c.course_name
            FROM student s 
            INNER JOIN person p ON p.id = s.person_id 
            LEFT JOIN course c ON c.id = (
                    SELECT c2.id
                    FROM inscription i 
                    INNER JOIN course c2 ON c2.id = i.course_id 
                    WHERE i.is_active = 1 AND s.id = i.student_id
                    ORDER BY i.inscription_date DESC
                    LIMIT 1
            )
            WHERE s.is_active = 1 AND (p.first_name LIKE '%$term%' OR p.last_name LIKE '%$term%' OR s.dui LIKE '%$term%')
        ";
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute($sql);
        $this->list = $list;

        $response = array();

        foreach ($list as $record) {
            $object = array(
                "key" => $record["person_id"],
                "val" => "{$record["first_name"]} {$record["last_name"]}",
                "firstname" => "{$record["first_name"]}",
                "lastname" => "{$record["last_name"]}",
                "dui" => "{$record["dui"]}",
                "email" => "{$record["email"]}",
                "student_id" => "{$record["id"]}",
                "course_id" => "{$record["course_id"]}",
                "course_name" => "{$record["course_name"]}"
            );

            array_push($response, $object);
        }

        $json_encode = json_encode($response);
        $this->getResponse()->setContent($json_encode);
        return sfView::NONE;
    }

    public function executeEnroll(sfWebRequest $request) {
        $course_id = $request->getParameter("course_id");
        $student_id = $request->getParameter("student_id");
        $delete_inscription = $request->getParameter("delete_inscription");

        if ((bool) $delete_inscription) {
            Doctrine_Query::create()
                    ->update("Inscription i")
                    ->set("i.is_active", "?", 0)
                    ->where("i.student_id = ?", $student_id)
                    ->execute();
        }

        $inscription = new Inscription();
        $inscription->setCourseId($course_id);
        $inscription->setStudentId($student_id);
        $inscription->save();

        return true;
    }

    public function executeViewAction(sfWebRequest $request) {
        $course_id = $request->getParameter("course_id");
        $student_id = $request->getParameter("student_id");

        $sql = "
            SELECT g.*, q.question_name
            FROM grade g
            INNER JOIN evaluation e ON e.id = g.evaluation_id
            INNER JOIN inscription i ON i.id = e.inscription_id
            INNER JOIN question q ON q.id = g.question_id
            WHERE i.course_id = $course_id AND i.student_id = $student_id AND i.is_active = 1
            ORDER BY g.evaluation_id";
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute($sql)->fetchAll();
        $this->list = $list;

        $sql = "
            SELECT 
                ins.id,
                ins.student_id,
                per.first_name,
                per.last_name,
                (
                    SELECT COUNT(*) 
                    FROM evaluation etotal
                    WHERE etotal.inscription_id = ins.id
                ) AS total_evaluations,
                (
                    SELECT IFNULL(AVG(gra_eavg.grade_score) * 5, 0)
                    FROM evaluation eavg 
                    INNER JOIN grade gra_eavg ON eavg.id = gra_eavg.evaluation_id
                    WHERE eavg.inscription_id = ins.id
                ) AS average_score
            FROM inscription ins 
            INNER JOIN student stu ON stu.id = ins.student_id 
            INNER JOIN person per ON per.id = stu.person_id 
            WHERE ins.course_id = $course_id AND ins.student_id = $student_id AND ins.is_active = 1
        ";
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $listInfo = $q->execute($sql)->fetchAll();
        $this->info = end($listInfo);
    }

    public function executeDeleteAction(sfWebRequest $request) {
        $student_id = $request->getParameter("student_id");

        Doctrine_Query::create()
                ->update("Inscription i")
                ->set("i.is_active", "?", 0)
                ->where("i.student_id = ?", $student_id)
                ->execute();

        return true;
    }

    public function executeDeleteAll(sfWebRequest $request) {
        $student_id = $request->getParameter("student_id"); //is array

        Doctrine_Query::create()
                ->update("Inscription i")
                ->set("i.is_active", "?", 0)
                ->whereIn("i.student_id", $student_id)
                ->execute();

        return true;
    }

    public function executeMoveAll(sfWebRequest $request) {
        $student_id = $request->getParameter("student_id"); //is array
        $course_id = $request->getParameter("course_id");

        Doctrine_Query::create()
                ->update("Inscription i")
                ->set("i.is_active", "?", 0)
                ->whereIn("i.student_id", $student_id)
                ->execute();
        $doctrine_Collection = new Doctrine_Collection("Inscription");
        foreach ($student_id as $id) {
            $inscription = new Inscription();
            $inscription->setCourseId($course_id);
            $inscription->setStudentId($id);
            $doctrine_Collection->add($inscription);
        }
        $doctrine_Collection->save();

        return true;
    }

    public function executeGetMoveLevel(sfWebRequest $request) {
        $course_id = $request->getParameter("course_id");
        $site_id = $request->getParameter("site_id");

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute("
            SELECT l.* FROM course c
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            WHERE c.id != $course_id AND s.id = $site_id AND l.is_active = 1 AND c.is_active
            GROUP BY l.id
        ");
        $this->list = $list;
    }

    public function executeGetMoveCourse(sfWebRequest $request) {
        $course_id = $request->getParameter("course_id");
        $site_id = $request->getParameter("site_id");
        $level_id = $request->getParameter("level_id");

        $sql = "SELECT c.id, c.course_name, sc.start, sc.end, sc.description, p.first_name, p.last_name,
                (SELECT COUNT(i.id) FROM inscription i WHERE i.course_id = c.id AND i.is_active = 1) AS total_inscription
                FROM course c
                INNER JOIN level l ON c.level_id = l.id
                INNER JOIN schedule sc ON c.schedule_id = sc.id
                INNER JOIN class_room cr ON c.class_room_id = cr.id
                INNER JOIN site s ON cr.site_id = s.id
                INNER JOIN user u ON c.user_id = u.id
                INNER JOIN person p ON u.person_id = p.id
                WHERE c.id != $course_id AND s.id = $site_id AND l.id = $level_id AND c.is_active = 1";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute($sql);
        $this->list = $list;
    }

}
