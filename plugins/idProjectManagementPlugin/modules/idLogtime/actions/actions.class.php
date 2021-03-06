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
  public function  preExecute()
  {
    $this->referer = $this->getRequest()->getReferer();
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('LogTime',10);
    $this->pager->setQuery(Doctrine::getTable('LogTime')->createQuery('a')->orderBy('created_at DESC'));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_logtime', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->form = new LogTimeForm();
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));

    $this->setTemplate('report');
  }

  public function executeAddToIssue(sfWebRequest $request)
  {
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));
    $this->forward404Unless($request->isMethod('post'));

    $form = new issueLogTimeForm();

    $parameters = $request->getParameter($form->getName());
    unset($parameters['form_type']);

    $form->bind($parameters);
    if ($form->isValid())
    {
      $log_time = $form->save();

      $this->getUser()->setFlash('success', 'Log time added');

      $this->redirect($this->referer);
    }

    $this->getUser()->setFlash('error', $form->render());
    $this->redirect($this->referer);

  }

  private function checkUserAgainstIssueAndProject(sfWebRequest $request)
  {
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));
    $this->forward404Unless($this->getUser()->isMyProjectByIssue($issue));

    return $issue;
  }

  /**
   * report for single issue and sigle user
   * 
   * @param sfWebRequest $request
   */
  public function executeReportForActualUser(sfWebRequest $request)
  {
    $this->issue = $this->checkUserAgainstIssueAndProject($request);

    $this->pager = new sfDoctrinePager('LogTime',10);
    $this->pager->setQuery(Doctrine::getTable('LogTime')->getQueryForUserLogTimeFromProjectAndIssue($this->getUser()->getGuardUser()->getId(), $this->issue->project_id, $this->issue->id));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_logtime', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->total_time = $this->getUser()->getMyTotalLogtimeForIssue($this->issue->id);

    $this->setTemplate('report');
  }

  /**
   * report for single issue and multiple users
   * 
   * @param sfWebRequest $request 
   */
  public function executeReportForAllUsers(sfWebRequest $request)
  {
    $this->issue = $this->checkUserAgainstIssueAndProject($request);
    
    $this->pager = new sfDoctrinePager('LogTime',10);
    $this->pager->setQuery(Doctrine::getTable('LogTime')->getQueryForAllLogTimeFromProjectAndIssue($this->issue->project_id, $this->issue->id));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_logtime', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->total_time = $this->issue->getTotalLogTime();

    $this->setTemplate('report');
  }

  /**
   * list of all the logtimes of a project
   * 
   * @param sfWebRequest $request
   */
  public function executeReportAllUsersForProject(sfWebRequest $request)
  {
    $this->forward404Unless($this->getUser()->isMyProject($request->getParameter('project_id')));

    $this->project = Doctrine::getTable('Project')->findOneBy('id', $request->getParameter('project_id'));
    $this->form = new projectLogTimeForm($this->project->id);
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));

    $this->pager = new sfDoctrinePager('LogTime',10);
    $this->pager->setQuery(Doctrine::getTable('LogTime')->getQueryForAllLogTimeFromProject($this->project->id));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_logtime', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->logtime_report = Doctrine::getTable('LogTime')->getLogtimeForProjectByUser($request->getParameter('project_id'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new LogTimeForm();
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $form_factory = new LogTimeFormFactory();
    $this->form = $form_factory->build($request->getParameter('form_type'));

    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));
    
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->
                                        findOneBy('id', $request->getParameter('id')),
                            sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));

    $this->project = $log_time->getIssue()->getProject();
    $this->form = new LogTimeForm($log_time);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->find(array($request->getParameter('id'))), sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));

    $form_factory = new LogTimeFormFactory();
    $this->form = $form_factory->build($request->getParameter('form_type'), null, $log_time);
    
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->find(array($request->getParameter('id'))), sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));
    $log_time->delete();

    $this->redirect($this->referer);
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $parameters = $request->getParameter($form->getName());
    unset($parameters['form_type']);
    
    if (!$this->getUser()->isAdmin())
    {
      $parameters['user_id'] = $this->getUser()->getId();
    }

    $form->bind($parameters);
    if ($form->isValid())
    {
      $log_time = $form->save();
      $this->getUser()->setFlash('success', 'Log time added');
      $this->redirect($this->referer);
    }
  }
}
