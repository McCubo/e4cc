<?php

/**
 * cp_site actions.
 *
 * @package    e4cc
 * @subpackage cp_site
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cp_siteActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $q = Doctrine_Core::getTable("Site")
                ->createQuery("s")
                ->where("s.is_active = ?", 1);
        $list = $q->execute();
        $this->list = $list;
        $this->listInactive = Doctrine::getTable("Site")->findBy("is_active", 0);
    }

    public function executeGetList(sfWebRequest $request) {
        $is_active = $request->getParameter("is_active");
        $list = Doctrine::getTable("Site")->findBy("is_active", $is_active);
        $this->list = $list;
    }

    public function executeNew(sfWebRequest $request) {
        
    }

    public function executeSave(sfWebRequest $request) {
        $site_name = $request->getParameter("site_name");

        $site = new Site();
        $site->setSiteName($site_name);
        $site->save();

        return true;
    }

    public function executeEdit(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $object = Doctrine::getTable("Site")->find($id);
        $this->site = $object;
    }

    public function executeUpdate(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $site_name = $request->getParameter("site_name");
        $is_active = $request->getParameter("is_active");

        $site = new Site();
        $site = (object) Doctrine::getTable("Site")->find($id);

        $site->setSiteName($site_name);
        $site->setIsActive($is_active);
        $site->save();

        return true;
    }

}
