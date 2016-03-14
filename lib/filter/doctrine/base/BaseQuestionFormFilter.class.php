<?php

/**
 * Question filter form base class.
 *
 * @package    e4cc
 * @subpackage filter
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseQuestionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'question_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'score'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'   => new sfWidgetFormFilterInput(),
      'is_active'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'question_name' => new sfValidatorPass(array('required' => false)),
      'score'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'description'   => new sfValidatorPass(array('required' => false)),
      'is_active'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('question_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Question';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'question_name' => 'Text',
      'score'         => 'Number',
      'description'   => 'Text',
      'is_active'     => 'Number',
    );
  }
}
