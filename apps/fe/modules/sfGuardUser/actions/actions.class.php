<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * sfGuardUserActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * sfGuardUserActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class sfGuardUserActions extends autoSfGuardUserActions
{
  /**
   * Executes show action
   *
   * @param sfWebRequest $request
   */
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine::getTable('sfGuardUser')->find(array($request->getParameter('id'))));
  }

  public function executeIndex(sfWebRequest $request)
  {
    if ($request->hasParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    $this->setPage($request->getParameter('page', 1));

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
  }

  protected function getPager()
  {
    $pager = $this->configuration->getPager('sfGuardUser');
    $pager->setQuery($this->buildQuery());
    $pager->setPage($this->getPage());
    $pager->setMaxPerPage(!is_null(sfConfig::get('app_itemperpage_users')) ? sfConfig::get('app_itemperpage_users') : 5);
    $pager->init();

    return $pager;
  }
}
