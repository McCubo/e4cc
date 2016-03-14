<?php

/**
 * default actions.
 *
 * @package    e4cc
 * @subpackage home
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //$this->getUser()->setAuthenticated(false);
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $resultData = $q->execute("
            SELECT table_name,
            IF(rows_raw>1000000, CONCAT(ROUND(rows_raw/1000000, 2), ' M'), IF(rows_raw>1000, CONCAT(ROUND(rows_raw/1000, 1), ' K'), rows_raw)) AS `# Rows`,
            IF(total_size_raw>1024*1024, CONCAT(ROUND((total_size_raw)/1024/1024, 1), ' MB'), CONCAT(ROUND((total_size_raw)/1024, 1), ' KB')) AS `Total Size`,
            IF(data_size_raw>1024*1024, CONCAT(ROUND((data_size_raw)/1024/1024, 1), ' MB'), CONCAT(ROUND((data_size_raw)/1024, 1), ' KB')) AS `Data Size`,
            IF(index_size_raw>1024*1024, CONCAT(ROUND((index_size_raw)/1024/1024, 1), ' MB'), CONCAT(ROUND((index_size_raw)/1024, 1), ' KB')) AS `Index Size`,
            rows_raw, total_size_raw, data_size_raw, index_size_raw
            FROM (SELECT table_name, table_rows AS rows_raw, data_length+index_length AS total_size_raw, data_length AS data_size_raw, index_length AS index_size_raw
            FROM information_schema.tables
            WHERE table_schema = 'db_e4cc' AND table_type = 'BASE TABLE') AS t
            ORDER BY (table_name) ASC;
        ");
        $this->resultData = $resultData;
    }

    public function executeLogin(sfWebRequest $request) {
        $usr = $request->getParameter("usr");
        $pas = $request->getParameter("pas");

        if ($usr == "admuser" && $pas == "e4ccadmpwd") {
            $return = "TRUE";
            $this->getUser()->setAttribute("has_access", true);
        } else {
            $return = "FALSE";
        }

        $this->getResponse()->setContent($return);
        return sfView::NONE;
    }

    public function executeLogout(sfWebRequest $request) {
        $this->getUser()->setAttribute("has_access", null);
        $this->redirect("home/index");
    }

}
