<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idIssue actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 */

/**
 * idIssue actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idIssueActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idIssue-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($this->project = Doctrine::getTable('Project')->findOneBy('id', $request->getParameter('project_id')));

    $this->pager = new sfDoctrinePager('Issue',10);
    $this->pager->setQuery(Doctrine::getTable('Issue')->getQueryForProjectIssues($request->getParameter('project_id')));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();
  }

  /**
   * Executes show action
   *
   * @param sfWebRequest $request
   */
  public function executeShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idIssue-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    $this->issue = Doctrine::getTable('Issue')->getIssueById($request->getParameter('issue_id'));
    $this->forward404Unless($this->issue && $this->issue->project_id == $request->getParameter('project_id'));

    $this->pager = new idPager('Issue',10);
    $this->pager->setResultArray($this->issue->issues);
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

//    $this->comment_form = new CommentForm();
//    $this->comment_form->setDefault('issue_id', $request->getParameter('issue_id'));
//    $this->comment_form->setDefault('profile_id', $this->getUser()->getProfile()->getId());
//    $this->comment_form->setDefault('created_at', date('Y-m-d H:i:s', time()));

    $this->estimated_time_form = new idEstimatedTimeForm($this->issue->getProjectId(), $this->issue);

    $this->logtime_form = new issueLogTimeForm();
    $this->logtime_form->setDefault('issue_id', $request->getParameter('issue_id'));
    $this->logtime_form->setDefault('profile_id', $this->getUser()->getGuardUser()->getProfile()->getId());
    $this->logtime_form->setDefault('created_at', date('Y-m-d H:i:s', time()));

    $this->commentForm = new fdCommentForm($this->issue, 'id', $request->getParameter('issue_id'));
    $this->commentForm->setDefault('profile_id', $this->getUser()->getGuardUser()->getProfile()->getId());
  }

  /**
   * Executes new action
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idIssue-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless(!is_null(Doctrine::getTable('Project')->find(array($request->getParameter('project_id')))));
    $this->form = new idIssueForm($request->getParameter('project_id'));
    $this->form->setDefault('project_id', $request->getParameter('project_id'));

    $this->setTemplate('edit');
  }

  /**
   * Executes create action
   *
   * @param sfWebRequest $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idIssue-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    $this->forward404Unless($request->isMethod('post'));
    $this->forward404Unless(!is_null(Doctrine::getTable('Project')->find(array($request->getParameter('project_id')))));

    $this->form = new idIssueForm($request->getParameter('project_id'));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  /**
   * Executes edit action
   *
   * @param sfWebRequest $request
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idIssue-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless(!is_null(Doctrine::getTable('Project')->find(array($request->getParameter('project_id')))));
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));

    $this->forward404Unless($issue->project_id == $request->getParameter('project_id'));
    
    $this->form = new idIssueForm($request->getParameter('project_id'), $issue);
  }

  /**
   * Executes update action
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idIssue-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless(!is_null(Doctrine::getTable('Project')->find(array($request->getParameter('project_id')))));
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));

    $this->form = new idIssueForm($request->getParameter('project_id'), $issue);

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
    $this->forwardUnless($this->getUser()->hasCredential('idIssue-Delete'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless(!is_null(Doctrine::getTable('Project')->find(array($request->getParameter('project_id')))));
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));
    $request->checkCSRFProtection();

    $project_id = $request->getParameter('project_id');

    $issue->delete();
    $this->redirect('@index_issue?project_id='.$project_id);
  }

  public function executeSetEstimatedTime(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idIssue-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));

    $form = new idEstimatedTimeForm($issue->getProjectId(), $issue);
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $issue = $form->save();
      $this->dispatcher->notify(new sfEvent($issue,
                                            'issue.set_estimated_time_success',
                                            array('log_message' => LogMessageGenerator::generate($this->getUser(), 'Set estimated time to '.$issue->estimated_time.' hours', $issue),
                                                  'project_id'  => $issue->project_id)));
      $this->redirect('@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id);
    }

    $this->getUser()->setFlash('error', $form['estimated_time']->renderError());
    $this->redirect('@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id);
  }

  protected function issueIsBeingCloding($parameters)
  {
    return (empty($parameters['ending_date']['month']) &&
            empty($parameters['ending_date']['day']) &&
            empty($parameters['ending_date']['year']) &&
            Doctrine::getTable('Status')->isClosedTypeById($parameters['status_id']));
  }

  protected function issueIsBeingReopen($parameters)
  {
    return (!empty($parameters['ending_date']['month']) &&
            !empty($parameters['ending_date']['day']) &&
            !empty($parameters['ending_date']['year']) &&
            Doctrine::getTable('Status')->isOpenTypeById($parameters['status_id']));
  }

  protected function fixParameterForOpenOrClosedIssue($parameters, $issue)
  {
    if ($issue->isNew())
    {
      return $parameters;
    }

    if (is_array($parameters))
    {
      if ($this->issueIsBeingCloding($parameters))
      {
        list($parameters['ending_date']['year'], $parameters['ending_date']['month'], $parameters['ending_date']['day']) = explode('-',date('Y-m-d', time()));
      }

      if ($this->issueIsBeingReopen($parameters))
      {
        $parameters['ending_date'] = null;
      }

    }

    return $parameters;
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
    $form->bind($this->fixParameterForOpenOrClosedIssue($request->getParameter($form->getName()), $form->getObject()));
    if ($form->isValid())
    {
      $operation = $form->getObject()->isNew() ? 'create' : 'update';
      $issue = $form->save();
      
//      the operation of saving this issue again cannot be done cause of a bug on the embedded for that we thought was solved during the phpday2009
//      $issue->save();
//
//      if ($issue->hasBeenClosed())
//      {
//        $issue->setEndingDate(date('Y-m-d H:i:s', time()));
//      }
//
//      if ($issue->hasBeenReopen())
//      {
//        $issue->setEndingDate(null);
//      }

      

      $this->redirect('@index_issue?project_id='.$issue->project_id);
    }
  }
}
