<?php

/**
 * Course form base class.
 *
 * @method Course getObject() Returns the current form's model object
 *
 * @package    e4cc
 * @subpackage form
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCourseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'level_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Level'), 'add_empty' => false)),
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'class_room_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ClassRoom'), 'add_empty' => false)),
      'schedule_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Schedule'), 'add_empty' => false)),
      'course_name'   => new sfWidgetFormInputText(),
      'is_active'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'level_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Level'))),
      'user_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'class_room_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ClassRoom'))),
      'schedule_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Schedule'))),
      'course_name'   => new sfValidatorString(array('max_length' => 45)),
      'is_active'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('course[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Course';
  }

}
