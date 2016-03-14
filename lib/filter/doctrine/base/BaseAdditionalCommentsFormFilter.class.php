<?php

/**
 * AdditionalComments filter form base class.
 *
 * @package    e4cc
 * @subpackage filter
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAdditionalCommentsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'grade_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'add_empty' => true)),
      'additional_comment' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'grade_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Grade'), 'column' => 'id')),
      'additional_comment' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('additional_comments_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdditionalComments';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'grade_id'           => 'ForeignKey',
      'additional_comment' => 'Text',
    );
  }
}
