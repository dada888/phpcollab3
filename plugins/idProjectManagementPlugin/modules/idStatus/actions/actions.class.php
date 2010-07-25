<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idStatus actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 */

/**
 * idStatus actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idStatusActions extends sfActions
{
  protected function getQueryForStatusesList()
  {
    return Doctrine::getTable('Status')
      ->getStatusesOrderByPositionQuery();
  }

  /**
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forwardUnless(($this->getUser()->isAdmin() || $this->getUser()->isProjectManager()), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->status_list = $this->getQueryForStatusesList()->execute();
  }


  private function checkPositionParameters($status_list, $ordering_list)
  {
    $status_items_number = count($status_list);

    if ( count($ordering_list) != $status_items_number)
    {
      return false;
    }

    foreach ($ordering_list as $order_key => $value)
    {
      if (!is_int($order_key) || $order_key > $status_items_number)
      {
        return false;
      }
    }

    return true;
  }

  /**
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeOrder(sfWebRequest $request)
  {
      $ordering_list = $request->getParameter('status');
      if (!is_null($ordering_list) && !empty($ordering_list))
      {
        $status_list = $this->getQueryForStatusesList()->execute();

        if (!$this->checkPositionParameters($status_list, $ordering_list))
        {
          return $this->renderPartial('idPriority/order_message', array('response_message' => 'Some error occurred processing your request.', 'class' => 'message error'));
        }

        foreach ($status_list as $status)
        {
          $status->setPosition(array_search($status->id, $ordering_list));
          $status->save();
        }

        return $this->renderPartial('idPriority/order_message', array('response_message' => 'Order updated', 'class' => 'message notice'));
      }

    return $this->renderPartial('idPriority/order_message', array('response_message' => 'Invalid request', 'class' => 'message warning'));
  }

  protected function switchFirstAndSecondPositions($statuses)
  {
    $first_position = (int)$statuses[0]->getPosition();
    $statuses[0]->setPosition((int)$statuses[1]->getPosition());
    $statuses[1]->setPosition($first_position);

    $statuses[0]->save();
    $statuses[1]->save();
  }

  /**
   * Execute order action (not AJAX)
   *
   * @param sfWebRequest $request
   */
  public function executeOrderStatus(sfWebRequest $request)
  {
    $highest_position = Doctrine::getTable('Status')->retrieveHighestPosition();
    if (!is_null($request->getParameter('position'))
                            && $request->getParameter('position') <= $highest_position
                            && $request->getParameter('position') >= 0
                            && $request->getParameter('move')
                            && ($request->getParameter('move') == 'up' || $request->getParameter('move') == 'down')
                           )
    {
      $move = ($request->getParameter('move') == 'up') ? '<' : '>';

      $priorities = $this->getQueryForStatusesList()
                        ->where('s.position '.$move.'= ?', $request->getParameter('position'))
                        ->limit(2)
                        ->execute();

      $this->switchFirstAndSecondPositions($priorities);
      $this->getUser()->setFlash('notice', 'Order updated');

      $this->redirect('idStatus/index');
    }

    $this->getUser()->setFlash('error', 'Some error occurred processing your request.');
    $this->redirect('idStatus/index');

  }


  /**
   * Executes new action
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new StatusForm();
    $this->setTemplate('edit');
  }

  /**
   * Executes create action
   *
   * @param sfWebRequest $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new StatusForm();

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
    $this->forward404Unless($status = Doctrine::getTable('Status')->find(array($request->getParameter('id'))), sprintf('Object status does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new StatusForm($status);
  }

  /**
   * Executes update action
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($status = Doctrine::getTable('Status')->find(array($request->getParameter('id'))), sprintf('Object status does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new StatusForm($status);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  /**
   * This method checks if all the position are in cardinal oreder and if it is not, it will fix them
   *
   */
  protected function checkAndFixPriorityPositions()
  {
    $statuses = $this->getQueryForStatusesList()->execute();
    foreach ($statuses as $key => $status)
    {
      if ($status->getPosition() != $key)
      {
        $status->setPosition($key);
        $status->save();
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
    $request->checkCSRFProtection();

    $this->forward404Unless($status = Doctrine::getTable('Status')->find(array($request->getParameter('id'))), sprintf('Object status does not exist (%s).', array($request->getParameter('id'))));
    $status->delete();

    $this->checkAndFixPriorityPositions();

    $this->redirect('@index_status');
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
      $status = $form->save();

      if ($status->getPosition() == null)
      {
        $highest_position = Doctrine::getTable('Status')->retrieveHighestPosition();
        $status->setPosition($highest_position + 1);
        $status->save();
      }
      $this->redirect('@index_status');
    }
  }
}
