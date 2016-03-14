<?php

/**
 * cp_level actions.
 *
 * @package    e4cc
 * @subpackage cp_level
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cp_levelActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $q = Doctrine_Core::getTable("Level")
                ->createQuery("l")
                ->where("l.is_active = ?", 1);
        $list = $q->execute();
        $this->list = $list;
        $this->listInactive = Doctrine::getTable("Level")->findBy("is_active", 0);
    }

    public function executeGetList(sfWebRequest $request) {
        $is_active = $request->getParameter("is_active");
        $list = Doctrine::getTable("Level")->findBy("is_active", $is_active);
        $this->list = $list;
    }

    public function executeNew(sfWebRequest $request) {
        
    }

    public function executeSave(sfWebRequest $request) {
        $level_name = $request->getParameter("level_name");

        $level = new Level();
        $level->setLevelName($level_name);
        $level->save();

        return true;
    }

    public function executeEdit(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $object = Doctrine::getTable("Level")->find($id);
        $this->level = $object;
    }

    public function executeUpdate(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $level_name = $request->getParameter("level_name");
        $is_active = $request->getParameter("is_active");

        $level = new Level();
        $level = (object) Doctrine::getTable("Level")->find($id);

        $level->setLevelName($level_name);
        $level->setIsActive($is_active);
        $level->save();

        return true;
    }

}
