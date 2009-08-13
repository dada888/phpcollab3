<?php

/**
 * idLogtime actions.
 *
 * @package    PHPCollab3
 * @subpackage idLogtime
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class idLogtimeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('LogTime',10);
    $this->pager->setQuery(Doctrine::getTable('LogTime')->createQuery('a'));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_logtime', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();
    
  }

  public function executeAddToIssue(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));
    $this->forward404Unless($request->isMethod('post'));

    $form = new issueLogTimeForm();

    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $log_time = $form->save();

      $this->getUser()->setFlash('success', 'Log time added');
      $this->redirect('@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id);
    }

    $this->getUser()->setFlash('error', $form['log_time']->renderError());
    $this->redirect('@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id);

  }

  private function checkUserAgainstIssueAndProject(sfWebRequest $request)
  {
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));
    $this->forward404Unless($this->getUser()->isMyProjectByIssue($issue));

    return $issue;
  }

  public function executeReportForActualUser(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-ReadReport'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->issue = $this->checkUserAgainstIssueAndProject($request);
    
    $this->logtime_report = Doctrine::getTable('LogTime')->getLogTimeByIssueAndProfile($this->issue->id, $this->getUser()->getGuardUser()->Profile->id);
  }

  public function executeReportForAllUsers(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-ReadReportForAllUsers'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->issue = $this->checkUserAgainstIssueAndProject($request);
    $this->logtime_report = $this->issue->logtimes;
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->form = new LogTimeForm();
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new LogTimeForm();
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));
    
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->find(array($request->getParameter('id'))), sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new LogTimeForm($log_time);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->find(array($request->getParameter('id'))), sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new LogTimeForm($log_time);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Delete'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $request->checkCSRFProtection();

    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->find(array($request->getParameter('id'))), sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));
    $log_time->delete();

    $this->redirect('idLogtime/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $log_time = $form->save();

      $this->redirect('idLogtime/edit?id='.$log_time->getId());
    }
  }
}
