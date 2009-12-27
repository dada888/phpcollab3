<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{
  /**
   * @see sfForm
   */
  public function configure()
  {
    parent::configure();
    $profileForm = new ProfileForm($this->object->Profile);
    unset($profileForm['sf_guard_user_id'], $profileForm['issues_list'], $profileForm['projects_list']);
    $this->embedForm('Profile', $profileForm);
  }

}
