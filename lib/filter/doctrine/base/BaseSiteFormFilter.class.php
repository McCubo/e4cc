<?php

/**
 * Site filter form base class.
 *
 * @package    e4cc
 * @subpackage filter
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSiteFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'site_name'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'panel_color' => new sfWidgetFormFilterInput(),
      'is_active'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'site_name'   => new sfValidatorPass(array('required' => false)),
      'panel_color' => new sfValidatorPass(array('required' => false)),
      'is_active'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('site_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Site';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'site_name'   => 'Text',
      'panel_color' => 'Text',
      'is_active'   => 'Number',
    );
  }
}
