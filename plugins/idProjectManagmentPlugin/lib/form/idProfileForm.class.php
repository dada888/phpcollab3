<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idIssueForm
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 */

/**
 * Form to diplay the right elements that could be related to an issue .
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idProfileForm extends sfGuardUserAdminForm
{
  public function configure()
  {
    parent::configure();

    $username = $this->getObject()->getUsername();
    $this->widgetSchema['username'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['username'] = new sfValidatorChoice(array('choices' => array($username)));

    unset($this['groups_list'], $this['permissions_list'], $this['is_active'], $this['is_super_admin']);
  }
}