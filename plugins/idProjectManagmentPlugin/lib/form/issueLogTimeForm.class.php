<?php

class issueLogTimeForm extends LogTimeForm
{
  public function configure()
  {
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['issue_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['profile_id'] = new sfWidgetFormInputHidden();

    $this->validatorSchema['log_time'] = new sfValidatorNumber(array('min' => '0', 'required' => false), array('min' => 'You cannot set a negative log time'));
  }
}