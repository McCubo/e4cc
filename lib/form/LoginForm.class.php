<?php

class LoginForm extends BaseForm {

    public function configure() {
        $this->disableLocalCSRFProtection();
        $this->widgetSchema['username'] = new sfWidgetFormInputText(array(), array('id' => 'username'));
        $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('id' => 'password'));
        $this->validatorSchema['username'] = new sfValidatorString(
                array(
            'required' => true,
            'min_length' => 4
                ), array(
            'required' => 'You must type your email or username',
            'min_length' => '"%value%" is not a valid username, it must be at least %min_length% characters long'
        ));
        $this->validatorSchema['password'] = new sfValidatorString(array('required' => true), array('required' => 'Type your password'));
        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateLoginUser'))));
    }

    public function validateLoginUser($validator, $aValues) {
        if ($aValues['username'] && $aValues['password']) {
            $oUser = Doctrine_Core::getTable("Person")->findOneByUsernameOrEmail($aValues['username'], $aValues['username'], Doctrine_Core::HYDRATE_RECORD);
            if ($oUser) {
                if ($oUser->getPassword() != $aValues['password']) {
                    $sfValidatorError = new sfValidatorError($validator, 'The password you provided doesn\'t match with the password in our database');
                    throw new sfValidatorErrorSchema($validator, array('username' => $sfValidatorError));
                }
                $this->validateActive($oUser, $validator, $aValues);
                sfContext::getInstance()->getUser()->getAttributeHolder()->clear();
                sfContext::getInstance()->getUser()->clearCredentials();
                sfContext::getInstance()->getUser()->setAuthenticated(true);
                sfContext::getInstance()->getUser()->setAttribute('username', $oUser->getUsername());
                sfContext::getInstance()->getUser()->setAttribute('person_id', $oUser->getId());
                sfContext::getInstance()->getUser()->setAttribute('fullname', $oUser->getFullName());
                sfContext::getInstance()->getUser()->setAttribute('email', $oUser->getEmail());
                // verify if the person is a student or user
                if ($oUser->getStudent()->count() > 0) {
                    sfContext::getInstance()->getUser()->addCredential('student');
                    sfContext::getInstance()->getUser()->setAttribute('student_id', $oUser->getStudent()->getFirst()->getId());
                }
                if ($oUser->getUser()->count() > 0) {
                    sfContext::getInstance()->getUser()->addCredential(strtolower($oUser->getUser()->getFirst()->getRole()->getRoleName()));
                    sfContext::getInstance()->getUser()->setAttribute('user_id', $oUser->getUser()->getFirst()->getId());
                }
            } else {
                $sfValidatorError = new sfValidatorError($validator, 'The username you typed (' . $aValues['username'] . ') does not exists');
                throw new sfValidatorErrorSchema($validator, array('username' => $sfValidatorError));
            }
        }
        return $aValues;
    }

    private function validateActive($Person, $oValidator, $aValues) {
        if ($Person->getStudent()->count() > 0) {
            if (!$Person->getStudent()->getFirst()->isActive()) {
                $sfValidatorError = new sfValidatorError($oValidator, 'The username you typed (' . $aValues['username'] . ') is not active in the system');
                throw new sfValidatorErrorSchema($oValidator, array('username' => $sfValidatorError));
            }
        }
        if ($Person->getUser()->count() > 0) {
            if (!$Person->getUser()->getFirst()->isActive()) {
                $sfValidatorError = new sfValidatorError($oValidator, 'The username you typed (' . $aValues['username'] . ') is not active in the system');
                throw new sfValidatorErrorSchema($oValidator, array('username' => $sfValidatorError));
            }
        }
    }

}

?>