<?php

/**
 * StudentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class StudentTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object StudentTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('Student');
    }

    public function isValidDUI($iStudentID, $sDUI) {
        $sDUIOtherStudent = "select count(s.id) as counter from student s"
                . " where s.id not in ({$iStudentID}) and s.dui = '{$sDUI}'";
        $aResult = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sDUIOtherStudent);
        return $aResult[0]["counter"] == 0;
    }

}
