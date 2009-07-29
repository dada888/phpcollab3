<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idPriority actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * idPriority actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idPriorityActions extends sfActions
{

  protected function getQueryForPrioritiesList()
  {
    return Doctrine::getTable('Priority')
      ->getPrioritiesOrderByPositionQuery();
  }

  /**
   * Retrieve a priority list ordered by position field
   *
   * @return <type>
   */
  protected function retrievePrioritiesList()
  {
    return $this->getQueryForPrioritiesList()->execute();
  }

  /**
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idPriority-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->priority_list = $this->retrievePrioritiesList();
  }

  private function checkPositionParameters($priorities_list, $ordering_list)
  {
    $priorities_items_number = count($priorities_list);

    if ( count($ordering_list) != $priorities_items_number)
    {
      return false;
    }

    foreach ($ordering_list as $order_key => $value)
    {
      if (!is_int($order_key) || $order_key > $priorities_items_number)
      {
        return false;
      }
    }

    return true;
  }

  /**
   * Executes order action (AJAX)
   *
   * @param sfWebRequest $request
   */
  public function executeOrder(sfWebRequest $request)
  {
    if ($this->getUser()->hasCredential('idPriority-Edit'))
    {
      $ordering_list = $request->getParameter('priority');
      if (!is_null($ordering_list) && !empty($ordering_list))
      {
        $priorities_list = $this->retrievePrioritiesList();

        if (!$this->checkPositionParameters($priorities_list, $ordering_list))
        {
          return $this->renderPartial('idPriority/order_message', array('response_message' => 'Some error occurred processing your request.', 'class' => 'message error'));
        }

        foreach ($priorities_list as $priority)
        {
          $priority->setPosition(array_search($priority->id, $ordering_list));
          $priority->save();
        }
        return $this->renderPartial('idPriority/order_message', array('response_message' => 'Order updated', 'class' => 'message notice'));
      }
    }

    return $this->renderPartial('idPriority/order_message', array('response_message' => 'Invalid request', 'class' => 'message warning'));
  }

  protected function switchFirstAndSecondPositions($priorities)
  {
    $first_position = (int)$priorities[0]->getPosition();
    $priorities[0]->setPosition((int)$priorities[1]->getPosition());
    $priorities[1]->setPosition($first_position);

    $priorities[0]->save();
    $priorities[1]->save();
  }

  /**
   * Execute order action (not AJAX)
   *
   * @param sfWebRequest $request
   */
  public function executeOrderPriority(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idPriority-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $highest_position = Doctrine::getTable('Priority')->retrieveHighestPosition();
    if (!is_null($request->getParameter('position'))
                            && $request->getParameter('position') <= $highest_position
                            && $request->getParameter('position') >= 0
                            && $request->getParameter('move')
                            && ($request->getParameter('move') == 'up' || $request->getParameter('move') == 'down')
                           )
    {
      $move = ($request->getParameter('move') == 'up') ? '<' : '>';

      $priorities = $this->getQueryForPrioritiesList()
                        ->where('pr.position '.$move.'= ?', $request->getParameter('position'))
                        ->limit(2)
                        ->execute();
      
      $this->switchFirstAndSecondPositions($priorities);
      $this->getUser()->setFlash('notice', 'Order updated');
      $this->redirect('idPriority/index');
    }

    $this->getUser()->setFlash('error', 'Some error occurred processing your request.');
    $this->redirect('idPriority/index');

  }


  /**
   * Executes new action
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idPriority-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->form = new PriorityForm();
    $this->setTemplate('edit');
  }

  /**
   * Executes create action
   *
   * @param sfWebRequest $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idPriority-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PriorityForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  /**
   * Executes edit action
   *
   * @param sfWebRequest $request
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idPriority-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($priority = Doctrine::getTable('Priority')->find(array($request->getParameter('id'))), sprintf('Object priority does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new PriorityForm($priority);
  }

  /**
   * Executes update action
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idPriority-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($priority = Doctrine::getTable('Priority')->find(array($request->getParameter('id'))), sprintf('Object priority does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new PriorityForm($priority);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  /**
   * This method checks if all the position are in cardinal oreder and if it is not, it will fix them
   * 
   */
  protected function checkAndFixPriorityPositions()
  {
    $priorities = $this->getQueryForPrioritiesList()->execute();
    foreach ($priorities as $key => $priority)
    {
      if ($priority->getPosition() != $key)
      {
        $priority->setPosition($key);
        $priority->save();
      }
    }
  }

  /**
   * Executes delete action
   *
   * @param sfWebRequest $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idPriority-Delete'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $request->checkCSRFProtection();

    $this->forward404Unless($priority = Doctrine::getTable('Priority')->find(array($request->getParameter('id'))), sprintf('Object priority does not exist (%s).', array($request->getParameter('id'))));
    $priority->delete();

    $this->checkAndFixPriorityPositions();

    $this->redirect('idPriority/index');
  }

  /**
   * checks if the form is valid and redirect to the right page
   *
   * @access protected
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $priority = $form->save();

      if ($priority->getPosition() == null)
      {
        $highest_position = Doctrine::getTable('Priority')->retrieveHighestPosition();
        $priority->setPosition($highest_position + 1);
        $priority->save();
      }

      $this->redirect('@index_priority');
    }
  }
}
