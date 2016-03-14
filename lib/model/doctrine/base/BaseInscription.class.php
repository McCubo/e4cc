<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Inscription', 'doctrine');

/**
 * BaseInscription
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $course_id
 * @property integer $student_id
 * @property timestamp $inscription_date
 * @property integer $is_active
 * @property Course $Course
 * @property Student $Student
 * @property Doctrine_Collection $Evaluation
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method integer             getCourseId()         Returns the current record's "course_id" value
 * @method integer             getStudentId()        Returns the current record's "student_id" value
 * @method timestamp           getInscriptionDate()  Returns the current record's "inscription_date" value
 * @method integer             getIsActive()         Returns the current record's "is_active" value
 * @method Course              getCourse()           Returns the current record's "Course" value
 * @method Student             getStudent()          Returns the current record's "Student" value
 * @method Doctrine_Collection getEvaluation()       Returns the current record's "Evaluation" collection
 * @method Inscription         setId()               Sets the current record's "id" value
 * @method Inscription         setCourseId()         Sets the current record's "course_id" value
 * @method Inscription         setStudentId()        Sets the current record's "student_id" value
 * @method Inscription         setInscriptionDate()  Sets the current record's "inscription_date" value
 * @method Inscription         setIsActive()         Sets the current record's "is_active" value
 * @method Inscription         setCourse()           Sets the current record's "Course" value
 * @method Inscription         setStudent()          Sets the current record's "Student" value
 * @method Inscription         setEvaluation()       Sets the current record's "Evaluation" collection
 * 
 * @package    e4cc
 * @subpackage model
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseInscription extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('inscription');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('course_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('student_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('inscription_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
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
        $this->hasOne('Course', array(
             'local' => 'course_id',
             'foreign' => 'id'));

        $this->hasOne('Student', array(
             'local' => 'student_id',
             'foreign' => 'id'));

        $this->hasMany('Evaluation', array(
             'local' => 'id',
             'foreign' => 'inscription_id'));
    }
}