<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Role', 'doctrine');

/**
 * BaseRole
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $role_name
 * @property integer $is_active
 * @property Doctrine_Collection $User
 * 
 * @method integer             getId()        Returns the current record's "id" value
 * @method string              getRoleName()  Returns the current record's "role_name" value
 * @method integer             getIsActive()  Returns the current record's "is_active" value
 * @method Doctrine_Collection getUser()      Returns the current record's "User" collection
 * @method Role                setId()        Sets the current record's "id" value
 * @method Role                setRoleName()  Sets the current record's "role_name" value
 * @method Role                setIsActive()  Sets the current record's "is_active" value
 * @method Role                setUser()      Sets the current record's "User" collection
 * 
 * @package    e4cc
 * @subpackage model
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRole extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('role');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('role_name', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 45,
             ));
        $this->hasColumn('is_active', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '1',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('User', array(
             'local' => 'id',
             'foreign' => 'role_id'));
    }
}