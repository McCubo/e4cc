<?php

/**
 * Schedule form base class.
 *
 * @method Schedule getObject() Returns the current form's model object
 *
 * @package    e4cc
 * @subpackage form
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseScheduleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'start'       => new sfWidgetFormTime(),
      'end'         => new sfWidgetFormTime(),
      'description' => new sfWidgetFormInputText(),
      'is_active'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'start'       => new sfValidatorTime(),
      'end'         => new sfValidatorTime(),
      'description' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'is_active'   => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('schedule[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Schedule';
  }

}
