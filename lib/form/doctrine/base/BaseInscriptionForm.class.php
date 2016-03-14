<?php

/**
 * Inscription form base class.
 *
 * @method Inscription getObject() Returns the current form's model object
 *
 * @package    e4cc
 * @subpackage form
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInscriptionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'course_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => false)),
      'student_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => false)),
      'inscription_date' => new sfWidgetFormDateTime(),
      'is_active'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'course_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'))),
      'student_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Student'))),
      'inscription_date' => new sfValidatorDateTime(),
      'is_active'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('inscription[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Inscription';
  }

}
