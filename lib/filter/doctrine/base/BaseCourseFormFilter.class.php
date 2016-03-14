<?php

/**
 * Course filter form base class.
 *
 * @package    e4cc
 * @subpackage filter
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCourseFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'level_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Level'), 'add_empty' => true)),
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'class_room_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ClassRoom'), 'add_empty' => true)),
      'schedule_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Schedule'), 'add_empty' => true)),
      'course_name'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'level_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Level'), 'column' => 'id')),
      'user_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'class_room_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ClassRoom'), 'column' => 'id')),
      'schedule_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Schedule'), 'column' => 'id')),
      'course_name'   => new sfValidatorPass(array('required' => false)),
      'is_active'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('course_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Course';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'level_id'      => 'ForeignKey',
      'user_id'       => 'ForeignKey',
      'class_room_id' => 'ForeignKey',
      'schedule_id'   => 'ForeignKey',
      'course_name'   => 'Text',
      'is_active'     => 'Number',
    );
  }
}
