<?php

/**
 * Grade filter form base class.
 *
 * @package    e4cc
 * @subpackage filter
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGradeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'question_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Question'), 'add_empty' => true)),
      'evaluation_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Evaluation'), 'add_empty' => true)),
      'grade_score'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'question_comment' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'question_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Question'), 'column' => 'id')),
      'evaluation_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Evaluation'), 'column' => 'id')),
      'grade_score'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'question_comment' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('grade_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Grade';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'question_id'      => 'ForeignKey',
      'evaluation_id'    => 'ForeignKey',
      'grade_score'      => 'Number',
      'question_comment' => 'Text',
    );
  }
}
