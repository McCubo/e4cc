<?php

/**
 * course_coach actions.
 *
 * @package    e4cc
 * @subpackage course_coach
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class course_coachActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $user_id = $this->getUser()->getAttribute("user_id");

        $list = Doctrine_Core::getTable("Course")
                ->createQuery("c")
                ->where("c.is_active = ?", 1)
                ->andWhere("c.user_id = ?", $user_id)
                ->execute();
        $this->list = $list;
        $listAll = Doctrine_Core::getTable("Course")
                ->createQuery("c")
                ->where("c.is_active = ?", 1)
                ->execute();
        $this->listAll = $listAll;

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        $sql = "SELECT s.* FROM course c 
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            WHERE s.is_active = 1 
            AND c.is_active = 1 
            AND c.user_id = $user_id
            GROUP BY s.id";
        $siteArray = $q->execute($sql);
        $this->siteArray = $siteArray;
        $sql = "SELECT s.* FROM course c 
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            WHERE s.is_active = 1 
            AND c.is_active = 1 
            GROUP BY s.id";
        $siteAllArray = $q->execute($sql);
        $this->siteAllArray = $siteAllArray;

        $sql = "SELECT l.* FROM course c 
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            WHERE l.is_active = 1 
            AND c.is_active = 1 
            AND c.user_id = $user_id
            GROUP BY l.id";
        $levelArray = $q->execute($sql);
        $this->levelArray = $levelArray;
        $sql = "SELECT l.* FROM course c 
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            WHERE l.is_active = 1 
            AND c.is_active = 1 
            GROUP BY l.id";
        $levelAllArray = $q->execute($sql);
        $this->levelAllArray = $levelAllArray;

        $sql = "SELECT u.*, p.first_name, p.last_name FROM course c
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            INNER JOIN user u ON c.user_id = u.id
            INNER JOIN person p ON u.person_id = p.id
            WHERE u.is_active = 1 
            AND c.is_active = 1 
            GROUP BY u.id";
        $userAllArray = $q->execute($sql);
        $this->userAllArray = $userAllArray;
    }

    public function executeGetLevel(sfWebRequest $request) {
        $user_id = $this->getUser()->getAttribute("user_id");
        $type = $request->getParameter("type");
        $site_id = $request->getParameter("site_id");

        $where = $site_id == 0 ? "s.id > 0" : "s.id = $site_id";
        if ("self" == $type) {
            $where .= " AND c.user_id = $user_id";
        }

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute("
            SELECT l.* FROM course c
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            WHERE $where AND l.is_active = 1 AND c.is_active = 1
            GROUP BY l.id
        ");
        $this->list = $list;
    }

    public function executeGetCoach(sfWebRequest $request) {
        $user_id = $this->getUser()->getAttribute("user_id");
        $type = $request->getParameter("type");
        $site_id = $request->getParameter("site_id");
        $level_id = $request->getParameter("level_id");

        $where = $site_id == 0 ? "s.id > 0" : "s.id = $site_id";
        $where .= $level_id == 0 ? " AND l.id > 0" : " AND l.id = $level_id";
        if ("self" == $type) {
            $where .= " AND c.user_id = $user_id";
        }

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute("
            SELECT u.*, p.first_name, p.last_name FROM course c
            INNER JOIN level l ON c.level_id = l.id
            INNER JOIN schedule sc ON c.schedule_id = sc.id
            INNER JOIN class_room cr ON c.class_room_id = cr.id
            INNER JOIN site s ON cr.site_id = s.id
            INNER JOIN user u ON c.user_id = u.id
            INNER JOIN person p ON u.person_id = p.id
            WHERE $where AND u.is_active = 1 AND c.is_active = 1
            GROUP BY u.id
        ");
        $this->list = $list;
    }

    public function executeGetList(sfWebRequest $request) {
        $type = $request->getParameter("type");
        $user_id = "self" == $type ? $this->getUser()->getAttribute("user_id") : $request->getParameter("user_id");
        $site_id = $request->getParameter("site_id");
        $level_id = $request->getParameter("level_id");

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
                WHERE $where AND c.is_active = 1";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $list = $q->execute($sql);
        $this->list = $list;

        $this->type = $type;
    }

    public function executeView(sfWebRequest $request) {
        $id = $request->getParameter("id");

        $course = new Course();
        $course = (object) Doctrine::getTable("Course")->find($id);
        $this->course = $course;

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

}
