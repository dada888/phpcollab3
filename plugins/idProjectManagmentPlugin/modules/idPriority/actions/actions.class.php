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
  /**
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->priority_list = Doctrine::getTable('Priority')
      ->createQuery('pr')->orderBy('pr.position')
      ->execute();
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
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeOrder(sfWebRequest $request)
  {
    $ordering_list = $request->getParameter('priority');

    if (!is_null($ordering_list) && !empty($ordering_list))
    {
      $priorities_list = Doctrine::getTable('Priority')
      ->createQuery('pr')->orderBy('pr.id')
      ->execute();

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

    return $this->renderPartial('idPriority/order_message', array('response_message' => 'Invalid request', 'class' => 'message warning'));
  }

  /**
   * Executes new action
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
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
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($priority = Doctrine::getTable('Priority')->find(array($request->getParameter('id'))), sprintf('Object priority does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new PriorityForm($priority);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  /**
   * Executes delete action
   *
   * @param sfWebRequest $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($priority = Doctrine::getTable('Priority')->find(array($request->getParameter('id'))), sprintf('Object priority does not exist (%s).', array($request->getParameter('id'))));
    $priority->delete();

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
        $priority->setPosition($status->id);
        $priority->save();
      }

      $this->redirect('@index_priority');
    }
  }
}
