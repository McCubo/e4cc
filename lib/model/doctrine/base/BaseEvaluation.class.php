<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Evaluation', 'doctrine');

/**
 * BaseEvaluation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property integer $inscription_id
 * @property timestamp $evaluation_date
 * @property Inscription $Inscription
 * @property User $User
 * @property Doctrine_Collection $Grade
 * 
 * @method integer             getId()              Returns the current record's "id" value
 * @method integer             getUserId()          Returns the current record's "user_id" value
 * @method integer             getInscriptionId()   Returns the current record's "inscription_id" value
 * @method timestamp           getEvaluationDate()  Returns the current record's "evaluation_date" value
 * @method Inscription         getInscription()     Returns the current record's "Inscription" value
 * @method User                getUser()            Returns the current record's "User" value
 * @method Doctrine_Collection getGrade()           Returns the current record's "Grade" collection
 * @method Evaluation          setId()              Sets the current record's "id" value
 * @method Evaluation          setUserId()          Sets the current record's "user_id" value
 * @method Evaluation          setInscriptionId()   Sets the current record's "inscription_id" value
 * @method Evaluation          setEvaluationDate()  Sets the current record's "evaluation_date" value
 * @method Evaluation          setInscription()     Sets the current record's "Inscription" value
 * @method Evaluation          setUser()            Sets the current record's "User" value
 * @method Evaluation          setGrade()           Sets the current record's "Grade" collection
 * 
 * @package    e4cc
 * @subpackage model
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEvaluation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('evaluation');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('inscription_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('evaluation_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Inscription', array(
             'local' => 'inscription_id',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('Grade', array(
             'local' => 'id',
             'foreign' => 'evaluation_id'));
    }
}