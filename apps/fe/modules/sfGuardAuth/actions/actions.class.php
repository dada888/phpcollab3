<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * sfGuardAuth/action.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * 
 */
require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

/**
 * sfGuardAuth actions
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  /**
   * Set the referer of the incoming user and show the signin page
   *
   * @param sfWebRequest $request
   */
  public function executeSignin($request)
  {
    $this->getUser()->setReferer($request->getUri());

    parent::executeSignin($request);
  }

  /**
   * Sets the status code of the page to 403
   */
  public function executeSecure()
  {
    $this->getResponse()->setStatusCode(403);
  }
}
