<?php

/**
 * idTracker actions.
 *
 * @package    PHPCollab3
 * @subpackage idTracker
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class idTrackerActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('Tracker',10);
    $this->pager->setQuery(Doctrine::getTable('Tracker')->createQuery('a'));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_trakers', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TrackerForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new TrackerForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($tracker = Doctrine::getTable('Tracker')->find(array($request->getParameter('id'))), sprintf('Object tracker does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new TrackerForm($tracker);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($tracker = Doctrine::getTable('Tracker')->find(array($request->getParameter('id'))), sprintf('Object tracker does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new TrackerForm($tracker);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($tracker = Doctrine::getTable('Tracker')->find(array($request->getParameter('id'))), sprintf('Object tracker does not exist (%s).', array($request->getParameter('id'))));
    $tracker->delete();

    $this->redirect('idTracker/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $tracker = $form->save();
      $this->redirect('idTracker/index');
    }
  }
}
