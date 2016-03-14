<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Person', 'doctrine');

/**
 * BasePerson
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property date $birthdate
 * @property string $email
 * @property Doctrine_Collection $Student
 * @property Doctrine_Collection $User
 * 
 * @method integer             getId()         Returns the current record's "id" value
 * @method string              getUsername()   Returns the current record's "username" value
 * @method string              getPassword()   Returns the current record's "password" value
 * @method string              getFirstName()  Returns the current record's "first_name" value
 * @method string              getLastName()   Returns the current record's "last_name" value
 * @method date                getBirthdate()  Returns the current record's "birthdate" value
 * @method string              getEmail()      Returns the current record's "email" value
 * @method Doctrine_Collection getStudent()    Returns the current record's "Student" collection
 * @method Doctrine_Collection getUser()       Returns the current record's "User" collection
 * @method Person              setId()         Sets the current record's "id" value
 * @method Person              setUsername()   Sets the current record's "username" value
 * @method Person              setPassword()   Sets the current record's "password" value
 * @method Person              setFirstName()  Sets the current record's "first_name" value
 * @method Person              setLastName()   Sets the current record's "last_name" value
 * @method Person              setBirthdate()  Sets the current record's "birthdate" value
 * @method Person              setEmail()      Sets the current record's "email" value
 * @method Person              setStudent()    Sets the current record's "Student" collection
 * @method Person              setUser()       Sets the current record's "User" collection
 * 
 * @package    e4cc
 * @subpackage model
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePerson extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('person');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('username', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 45,
             ));
        $this->hasColumn('password', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('first_name', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('last_name', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('birthdate', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('email', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 45,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Student', array(
             'local' => 'id',
             'foreign' => 'person_id'));

        $this->hasMany('User', array(
             'local' => 'id',
             'foreign' => 'person_id'));
    }
}