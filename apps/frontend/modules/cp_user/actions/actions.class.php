<?php

/**
 * cp_user actions.
 *
 * @package    e4cc
 * @subpackage cp_user
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cp_userActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $q = Doctrine_Core::getTable("User")
                ->createQuery("u")
                ->where("u.is_active = ?", 1);
        $list = $q->execute();
        $this->list = $list;
        $this->listInactive = Doctrine::getTable("User")->findBy("is_active", 0);
    }

    public function executeGetList(sfWebRequest $request) {
        $is_active = $request->getParameter("is_active");
        $list = Doctrine::getTable("User")->findBy("is_active", $is_active);
        $this->list = $list;
    }

    public function executeNew(sfWebRequest $request) {
        $this->roleArray = Doctrine::getTable("Role")->findBy("is_active", 1);
    }

    public function executeSave(sfWebRequest $request) {
        $first_name = $request->getParameter("first_name");
        $last_name = $request->getParameter("last_name");
        $birthdate = $request->getParameter("birthdate");
        $email = $request->getParameter("email");
        $username = $request->getParameter("username");
        $password = $request->getParameter("password");
        $role_id = $request->getParameter("role_id");

        $person = new Person();
        $person->setUsername($username);
        $person->setPassword($password);
        $person->setFirstName($first_name);
        $person->setLastName($last_name);
        $person->setBirthdate($birthdate);
        $person->setEmail($email);
        $person->save();

        $user = new User();
        $user->setRoleId($role_id);
        $user->setPersonId($person->getId());
        $user->save();

        return true;
    }

    public function executeEdit(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $object = Doctrine::getTable("User")->find($id);
        $this->user = $object;
        $this->person = $this->user->getPerson();
        $this->roleArray = Doctrine::getTable("Role")->findBy("is_active", 1);
    }

    public function executeValidateUser(sfWebRequest $request) {
        $username = $request->getParameter("username");
        $collection = Doctrine::getTable("Person")->findBy("username", $username);
        $response = $collection->count() == 0 ? "1" : "0";
        $this->getResponse()->setContent($response);
        return sfView::NONE;
    }

    public function executeValidateUserEdit(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $username = $request->getParameter("username");

        $q = Doctrine_Core::getTable("Person")
                ->createQuery("p")
                ->where("p.username = ?", $username)
                ->andWhere("p.id != ?", $id);
        $collection = $q->execute();

        $response = $collection->count() == 0 ? "1" : "0";
        $this->getResponse()->setContent($response);
        return sfView::NONE;
    }

    public function executeUpdate(sfWebRequest $request) {
        $id = $request->getParameter("id");
        $first_name = $request->getParameter("first_name");
        $last_name = $request->getParameter("last_name");
        $birthdate = $request->getParameter("birthdate");
        $email = $request->getParameter("email");
        $username = $request->getParameter("username");
        $role_id = $request->getParameter("role_id");
        $is_active = $request->getParameter("is_active");

        $user = new User();
        $user = (object) Doctrine::getTable("User")->find($id);

        $person = new Person();
        $person = (object) $user->getPerson();
        $person->setUsername($username);
        $person->setFirstName($first_name);
        $person->setLastName($last_name);
        $person->setBirthdate($birthdate);
        $person->setEmail($email);
        $person->save();

        $user->setRoleId($role_id);
        $user->setIsActive($is_active);
        $user->save();

        return true;
    }

}
