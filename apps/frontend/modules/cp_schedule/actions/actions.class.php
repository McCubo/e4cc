<?php

/**
 * cp_schedule actions.
 *
 * @package    e4cc
 * @subpackage cp_schedule
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cp_scheduleActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $q = Doctrine_Core::getTable("Schedule")
                ->createQuery("s")
                ->where("s.is_active = ?", 1);
        $list = $q->execute();
        $this->list = $list;
        $this->listInactive = Doctrine::getTable("Schedule")->findBy("is_active", 0);
    }

    public function executeGetList(sfWebRequest $request) {
        $is_active = $request->getParameter("is_active");
        $list = Doctrine::getTable("Schedule")->findBy("is_active", $is_active);
        $this->list = $list;
    }

    public function executeNew(sfWebRequest $request) {
        
    }

    public function executeSave(sfWebRequest $request) {
        $start = $request->getParameter("start");
        $end = $request->getParameter("end");
        $description = $request->getParameter("description");

        $schedule = new Schedule();
        $schedule->setStart($start);
        $schedule->setEnd($end);
        $schedule->setDescription($description);
        $schedule->save();

        return true;
    }

    public function executeEdit(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $object = Doctrine::getTable("Schedule")->find($id);
        $this->schedule = $object;
    }

    public function executeUpdate(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $start = $request->getParameter("start");
        $end = $request->getParameter("end");
        $description = $request->getParameter("description");
        $is_active = $request->getParameter("is_active");

        $dateTimeStart = new DateTime($start);
        $start_time = date_format($dateTimeStart, "H:i:s");
        $dateTimeEnd = new DateTime($end);
        $end_time = date_format($dateTimeEnd, "H:i:s");

        $schedule = new Schedule();
        $schedule = (object) Doctrine::getTable("Schedule")->find($id);

        $schedule->setStart($start_time);
        $schedule->setEnd($end_time);
        $schedule->setDescription($description);
        $schedule->setIsActive($is_active);
        $schedule->save();

        return true;
    }

}
