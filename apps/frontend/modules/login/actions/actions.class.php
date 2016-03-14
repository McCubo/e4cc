<?php

/**
 * login actions.
 *
 * @package    e4cc
 * @subpackage login
 * @author     cubiascaceres@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class loginActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex() {
        $this->oLoginForm = new LoginForm();
    }

    public function executeDoLogin(sfWebRequest $oWebRequest) {
        $oLoginForm = new LoginForm();
        $aResponseData = array('message_list' => array());
        if ($oWebRequest->getMethod(sfRequest::POST)) {
            $aRequestparameters = $oWebRequest->getParameterHolder()->getAll();
            $oLoginForm->bind($aRequestparameters['user']);
            if (!$oLoginForm->isValid()) {
                $aResponseData['message_list'] = $oLoginForm->getErrorList();
            }
        }
        $aResponseData['is_student'] = $this->getUser()->hasCredential('student');
        $this->getResponse()->setContent(json_encode($aResponseData));
        return sfView::NONE;
    }

    public function executeLogout() {
        if ($this->getUser()->isAuthenticated() || $this->getUser()->getAttribute('auth')) {
            $userAttributeList = $this->getUser()->getAttributeHolder()->getAll();
            $userAttributeKeyList = array_keys($userAttributeList);
            foreach ($userAttributeKeyList as $attrKey) {
                $this->getUser()->getAttributeHolder()->remove($attrKey);
            }
            $this->getUser()->setAuthenticated(false);
            $this->getUser()->clearCredentials();
        }
        return $this->redirect('homepage');
    }

    public function executeResetPassword(sfWebRequest $oWebRequest) {
        $aData = array('message_list' => array());
        $oResetForm = $oWebRequest->getParameter("oResetForm");
        $oPerson = Doctrine_Core::getTable("Person")->findOneByEmailOrUsername($oResetForm['username_email'], $oResetForm['username_email']);
        if (!$oPerson || !$oPerson->isStudent()) {
            array_push($aData['message_list'], 'We could not find an user with the information you provided');
        } else {
            $sHash = md5(date("Y-m-d H:i:s") . $oPerson->getStudent());
            $oLink = new Link();
            $oLink->setStudent($oPerson->getStudentObject());
            $oLink->setToken($sHash);
            $oLink->setExpirationDate(date("Y-m-d H:i:s", strtotime("+7 days")));
            $oLink->save();
            $sUrl = "http://localhost" . $this->generateUrl('restore_password', array('token' => $sHash));
            $sBody = $this->getPartial("email_body_reset_password", array('sUrl' => $sUrl, 'oPerson' => $oPerson));
            $oMail = new MailHelper();
            $bSent = $oMail->sendMail("English 4 Call Centers - Reset Password Request " . date("Y-M-D"), array($oPerson->getEmail() => $oPerson->getFullName()), $sBody, array(sfConfig::get('sf_upload_dir') . "/english4callcenters.png"));
            if (!$bSent) {
                array_push($aData['message_list'], 'Email was not sent, please try again');
            }
        }
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

    public function executeRestore(sfWebRequest $oWebRequest) {
        $sToken = $oWebRequest->getParameter("token");
        if (!$sToken) {
            $this->redirect("not_found");
        }
        $oLink = Doctrine_Core::getTable("Link")->findOneByToken($sToken);
        if (!$oLink) {
            $this->redirect("not_found");
        } elseif ($oLink->getIsActive() == 0 || date("Y-m-d H:i:s") > $oLink->getExpirationDate()) {
            $this->redirect("not_found");
        }
    }

    public function executeDoRestorePassword(sfWebRequest $oWebRequest) {
        $aData = array('message_list' => array());
        $aForm = $oWebRequest->getParameter("oForm");
        $oLink = Doctrine_Core::getTable("Link")->findOneByToken($aForm['token']);
        if (!$oLink) {
            array_push($aData['message_list'], "An unexpected problema was found, please try again");
        } elseif ($oLink->getIsActive() == 0 || date("Y-m-d H:i:s") > $oLink->getExpirationDate()) {
            array_push($aData['message_list'], "The link you provided has expired or it has been already used");
        } elseif ($aForm["password"] != $aForm["cpassword"]) {
            array_push($aData['message_list'], "Password and Confirm Password do not match");
        } else {
            $oLink->setIsActive(0);
            $oLink->save();
            $oStudent = $oLink->getStudent();
            $oStudent->getPerson()->setPassword($aForm['password']);
            $oStudent->save();
        }
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

    public function executeDoInsertStudent(sfWebRequest $oWebRequest) {
        $aData = array('message_list' => array());
        try {
            $oSingupForm = $oWebRequest->getParameter("oSingupForm");
            $oPerson = new Person();
            $oPerson->setUsername($oSingupForm['username']);
            $oPerson->setPassword($oSingupForm['password']);
            $oPerson->setFirstName($oSingupForm['fname']);
            $oPerson->setLastName($oSingupForm['lname']);
            $oPerson->setBirthdate($oSingupForm['bdate']);
            $oPerson->setEmail($oSingupForm['usermail']);
            $oStudent = new Student();
            $oStudent->setPerson($oPerson);
            $oStudent->setDui($oSingupForm['udui']);
            $oStudent->setInsertionDate(date('Y-m-d H:i:s'));
            $oStudent->setIsActive(0);
            # save link and send email
            $sHash = md5(date("Y-m-d H:i:s") . $oStudent->getId());
            $oLink = new Link();
            $oLink->setStudent($oStudent);
            $oLink->setToken($sHash);
            $oLink->setExpirationDate(date("Y-m-d H:i:s", strtotime("+7 days")));
            $oLink->save();
            $sUrl = "http://localhost" . $this->generateUrl('activate_student', array('token' => $sHash));
            $sBody = $this->getPartial("email_body", array('sUrl' => $sUrl, 'oPerson' => $oPerson));
            $oMail = new MailHelper();
            $bSent = $oMail->sendMail(
                    "English 4 Call Centers - Evaluation system (User Activation) " . date("Y-M-D"), array($oPerson->getEmail() => $oPerson->getFullName()), $sBody, array(sfConfig::get('sf_upload_dir') . "/english4callcenters.png"));
            if (!$bSent) {
                array_push($aData['message_list'], 'Email was not sent, please try again');
            }
        } catch (Exception $exc) {
            array_push($aData['message_list'], $exc->getCode() . " :: " . $exc->getMessage());
        }
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

    public function executeActivate(sfWebRequest $oWebRequest) {
        $sToken = $oWebRequest->getParameter("token");
        if (!$sToken) {
            $this->redirect("not_found");
        }
        $oLink = Doctrine_Core::getTable("Link")->findOneByToken($sToken);
        if (!$oLink) {
            $this->redirect("not_found");
        } elseif ($oLink->getIsActive() == 0 || date("Y-m-d H:i:s") > $oLink->getExpirationDate()) {
            $this->redirect("not_found");
        }
        $oLink->setIsActive(0);
        $oLink->save();
        $oStudent = Doctrine_Core::getTable("Student")->find($oLink->getStudentId());
        $oStudent->setConfirmationDate(date("Y-m-d H:i:s"));
        $oStudent->setIsActive(1);
        $oStudent->save();
        $this->redirect("activate_user");
    }

}
