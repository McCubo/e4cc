<?php

/**
 * Person
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    e4cc
 * @subpackage model
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Person extends BasePerson {

    public function getFullName() {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    public function isStudent() {
        return $this->getStudent()->count() > 0;
    }

    public function getStudentObject() {
        return $this->getStudent()->getFirst();
    }

}