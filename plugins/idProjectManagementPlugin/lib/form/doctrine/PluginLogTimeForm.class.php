<?php

/**
 * PluginLogTime form.
 *
 * @package    form
 * @subpackage LogTime
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginLogTimeForm extends BaseLogTimeForm
{
  protected $form_type = '';

  public function setup()
  {
    parent::setup();

    $q = Doctrine::getTable('Profile')->retrieveQueryForAllButSuperAdmin();

    $this->widgetSchema['issue_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('issue')));
    $this->validatorSchema['issue_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('issue'), 'required' => true));

    $this->widgetSchema['profile_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('profile'), 'query' => $q, 'method' => 'getShortName'));
    $this->validatorSchema['profile_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('profile'), 'required' => true));

    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['form_type'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['form_type']->setDefault($this->form_type);
  }
}