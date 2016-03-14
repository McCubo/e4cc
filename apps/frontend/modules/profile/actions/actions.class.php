<?php

/**
 * profile actions.
 *
 * @package    symfony
 * @subpackage profile
 * @author     cubiascaceres@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions {

    public function executeGetMyProfile() {
        $aData = array('message_list' => array(), 'personal_info' => array());
        $oPerson = Doctrine_Core::getTable("Person")->find($this->getUser()->getAttribute("person_id"));
        if ($oPerson->isStudent()) {
            $aData['personal_info']['dui'] = $oPerson->getStudentObject()->getDui();
        }
        $aData['is_student'] = $oPerson->isStudent();
        $aData['personal_info']['fname'] = $oPerson->getFirstName();
        $aData['personal_info']['lname'] = $oPerson->getLastName();
        $aData['personal_info']['username'] = $oPerson->getUsername();
        $aData['personal_info']['bdate'] = $oPerson->getBirthdate();
        $aData['personal_info']['email'] = $oPerson->getEmail();
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

    public function executeDoSave(sfWebRequest $oWebRequest) {
        $aData = array('message_list' => array());
        $aProfile = $oWebRequest->getParameter("oProfile");
        if ($this->getUser()->hasAttribute("student_id")) {
            $bValidDUI = Doctrine_Core::getTable("Student")->isValidDUI($this->getUser()->getAttribute("student_id"), $aProfile["dui"]);
            if (!$bValidDUI) {
                array_push($aData["message_list"], "The DUI provided belongs to another student, please type it again");
            }
        }
        $iPersonId = $this->getUser()->getAttribute("person_id");
        $bValidEmail = Doctrine_Core::getTable("Person")->isValidEmail($iPersonId, $aProfile["email"]);
        $bValidUsername = Doctrine_Core::getTable("Person")->isValidUsername($iPersonId, $aProfile["username"]);
        if (!$bValidEmail) {
            array_push($aData["message_list"], "The email provided is already in use by anohter user, please try again");
        }
        if (!$bValidUsername) {
            array_push($aData["message_list"], "The username you typed is already in use by anohter user, please try again");
        }
        if (count($aData["message_list"]) == 0) {
            $oPerson = Doctrine_Core::getTable("Person")->find($iPersonId);
            if (!$oPerson) {
                array_push($aData["message_list"], "Something went wrong, please try again");
            } else {
                try {
                    $oPerson->setFirstName($aProfile["fname"]);
                    $oPerson->setLastName($aProfile["lname"]);
                    $oPerson->setBirthdate($aProfile["bdate"]);
                    $oPerson->setEmail($aProfile["email"]);
                    $oPerson->setUsername($aProfile["username"]);
                    if (array_key_exists("password", $aProfile)) {
                        $oPerson->setPassword($aProfile["password"]);
                    }
                    $oPerson->save();
                } catch (Exception $exc) {
                    array_push($aData["message_list"], $exc->getCode() . "::" . $exc->getMessage());
                }
            }
            if ($this->getUser()->hasAttribute("student_id")) {
                $oStudent = Doctrine_Core::getTable("Student")->find($this->getUser()->getAttribute("student_id"));
                $oStudent->setDui($aProfile["dui"]);
                $oStudent->save();
            }
        }
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

}
