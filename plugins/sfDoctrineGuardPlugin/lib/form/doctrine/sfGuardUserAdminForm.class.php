<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package form
 * @package sf_guard_user
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{
  public function configure()
  {
    parent::configure();

    $profileForm = new ProfileForm($this->object->Profile);
    unset($profileForm['sf_guard_user_id'], $profileForm['issues_list'], $profileForm['projects_list']);
    $this->embedForm('Profile', $profileForm);
  }
}