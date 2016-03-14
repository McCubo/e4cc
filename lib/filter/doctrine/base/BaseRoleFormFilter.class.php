<?php

/**
 * Role filter form base class.
 *
 * @package    e4cc
 * @subpackage filter
 * @author     jorgezfx@gmail.com
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRoleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'role_name' => new sfValidatorPass(array('required' => false)),
      'is_active' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('role_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Role';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'role_name' => 'Text',
      'is_active' => 'Number',
    );
  }
}
