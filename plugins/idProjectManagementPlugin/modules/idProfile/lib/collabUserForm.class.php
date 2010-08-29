<?php


class collabUserForm extends sfGuardUserAdminForm
{
  public function  configure() {
    parent::configure();

    unset(
            $this['groups_list'],
            $this['permissions_list'],
            $this['projects_list'],
            $this['issues_list'],
            $this['is_active'],
            $this['is_super_admin']
         );

    $this->widgetSchema['username'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['email_address'] = new sfValidatorEmail(array('required' => true), array('required' => 'email is mandatory', 'invalid' => 'Email Address is invalid'));
  }
}
