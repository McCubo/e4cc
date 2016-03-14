<?php

/**
 * Grade form base class.
 *
 * @method Grade getObject() Returns the current form's model object
 *
 * @package    e4cc
 * @subpackage form
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGradeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'question_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Question'), 'add_empty' => false)),
      'evaluation_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Evaluation'), 'add_empty' => false)),
      'grade_score'      => new sfWidgetFormInputText(),
      'question_comment' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'question_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Question'))),
      'evaluation_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Evaluation'))),
      'grade_score'      => new sfValidatorNumber(),
      'question_comment' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('grade[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Grade';
  }

}
