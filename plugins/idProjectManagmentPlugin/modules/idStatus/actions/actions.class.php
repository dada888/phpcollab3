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
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * idStatus actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idStatusActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->status_list = Doctrine::getTable('Status')
      ->createQuery('st')->orderBy('st.position')
      ->execute();
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
      $status_list = Doctrine::getTable('Status')
      ->createQuery('st')->orderBy('st.id')
      ->execute();

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
   * Executes delete action
   *
   * @param sfWebRequest $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($status = Doctrine::getTable('Status')->find(array($request->getParameter('id'))), sprintf('Object status does not exist (%s).', array($request->getParameter('id'))));
    $status->delete();

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
        $status->setPosition($status->id);
        $status->save();
      }
      $this->redirect('@index_status');
    }
  }
}
