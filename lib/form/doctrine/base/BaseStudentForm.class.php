<?php

/**
 * Student form base class.
 *
 * @method Student getObject() Returns the current form's model object
 *
 * @package    e4cc
 * @subpackage form
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStudentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'person_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Person'), 'add_empty' => false)),
      'dui'               => new sfWidgetFormInputText(),
      'insertion_date'    => new sfWidgetFormDateTime(),
      'confirmation_date' => new sfWidgetFormDateTime(),
      'is_active'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'person_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Person'))),
      'dui'               => new sfValidatorInteger(),
      'insertion_date'    => new sfValidatorDateTime(),
      'confirmation_date' => new sfValidatorDateTime(array('required' => false)),
      'is_active'         => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('student[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Student';
  }

}
