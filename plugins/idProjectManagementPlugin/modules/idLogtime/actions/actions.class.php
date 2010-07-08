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
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->pager = new sfDoctrinePager('LogTime',10);
    $this->pager->setQuery(Doctrine::getTable('LogTime')->createQuery('a')->orderBy('created_at DESC'));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_logtime', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->form = new LogTimeForm();
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));
  }

  public function executeAddToIssue(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
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

      $this->dispatcher->notify(new sfEvent($log_time,
                                            'log_time.add_to_issue',
                                            array('log_message' => LogMessageGenerator::generate($this->getUser(), 'add', $log_time),
                                                  'project_id'  => $issue->project_id)));

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
  
  public function executeReportAllUsersForProject(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-ReadReportForAllUsers'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($this->getUser()->isMyProject($request->getParameter('project_id')));

    $this->project = Doctrine::getTable('Project')->findOneBy('id', $request->getParameter('project_id'));
    $this->form = new projectLogTimeForm($this->project->id);
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));

    $this->pager = new sfDoctrinePager('LogTime',10);
    $this->pager->setQuery(Doctrine::getTable('LogTime')->getQueryForAllLogTimeFronProject($this->project->id));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_logtime', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->logtime_report = Doctrine::getTable('LogTime')->getLogtimeForProjectByUser($request->getParameter('project_id'));
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

    $form_factory = new LogTimeFormFactory();
    $this->form = $form_factory->build($request->getParameter('form_type'));

    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));
    
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->
                                        findOneBy('id', $request->getParameter('id')),
                            sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new LogTimeForm($log_time);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->find(array($request->getParameter('id'))), sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));

    $form_factory = new LogTimeFormFactory();
    $this->form = $form_factory->build($request->getParameter('form_type'), null, $log_time);
    
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idLogotime-Delete'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $request->checkCSRFProtection();

    $this->forward404Unless($log_time = Doctrine::getTable('LogTime')->find(array($request->getParameter('id'))), sprintf('Object log_time does not exist (%s).', array($request->getParameter('id'))));
    $log_time->delete();

    $this->dispatcher->notify(new sfEvent($log_time,
                                            'log_time.delete',
                                            array('log_message' => LogMessageGenerator::generate($this->getUser(), 'delete', $log_time),
                                                  'project_id'  => $log_time->getIssue()->project_id)));

    $this->redirect($this->referer);
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $parameters = $request->getParameter($form->getName());
    unset($parameters['form_type']);
    
    if (!$this->getUser()->isAdmin())
    {
      $parameters['profile_id'] = $this->getUser()->getProfile()->getId();
    }

    $form->bind($parameters);
    if ($form->isValid())
    {
      $operation = $form->getObject()->isNew() ? 'create' : 'update';
      $log_time = $form->save();
      
      $this->getUser()->setFlash('success', 'Log time added');

      $this->dispatcher->notify(new sfEvent($log_time,
                                            'log_time.'.$operation,
                                            array('log_message' => LogMessageGenerator::generate($this->getUser(), $operation, $log_time),
                                                  'project_id'  => $log_time->getIssue()->project_id)));

      $this->redirect($this->referer);
    }
  }
}
