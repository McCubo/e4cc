<?php

/**
 * cp_class_room actions.
 *
 * @package    e4cc
 * @subpackage cp_class_room
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cp_class_roomActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $q = Doctrine_Core::getTable("ClassRoom")
                ->createQuery("cr")
                ->where("cr.is_active = ?", 1);
        $list = $q->execute();
        $this->list = $list;
        $this->listInactive = Doctrine::getTable("ClassRoom")->findBy("is_active", 0);
    }

    public function executeGetList(sfWebRequest $request) {
        $is_active = $request->getParameter("is_active");
        $list = Doctrine::getTable("ClassRoom")->findBy("is_active", $is_active);
        $this->list = $list;
    }

    public function executeNew(sfWebRequest $request) {
        $siteArray = Doctrine::getTable("Site")->findBy("is_active", 1);
        $this->siteArray = $siteArray;
    }

    public function executeSave(sfWebRequest $request) {
        $site_id = $request->getParameter("site_id");
        $class_room_name = $request->getParameter("class_room_name");

        $classRoom = new ClassRoom();
        $classRoom->setSiteId($site_id);
        $classRoom->setClassRoomName($class_room_name);
        $classRoom->save();

        return true;
    }

    public function executeEdit(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $object = Doctrine::getTable("ClassRoom")->find($id);
        $this->classRoom = $object;

        $siteArray = Doctrine::getTable("Site")->findBy("is_active", 1);
        $this->siteArray = $siteArray;
    }

    public function executeUpdate(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $site_id = $request->getParameter("site_id");
        $class_room_name = $request->getParameter("class_room_name");
        $is_active = $request->getParameter("is_active");

        $classRoom = new ClassRoom();
        $classRoom = (object) Doctrine::getTable("ClassRoom")->find($id);

        $classRoom->setSiteId($site_id);
        $classRoom->setClassRoomName($class_room_name);
        $classRoom->setIsActive($is_active);
        $classRoom->save();

        return true;
    }

}
