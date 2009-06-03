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
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * idIssue actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
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
    $this->issue = Doctrine::getTable('Issue')->getIssueById($request->getParameter('issue_id'));
    
    $this->forward404Unless($this->issue && $this->issue->project_id == $request->getParameter('project_id'));

    $this->pager = new idPager('Issue',10);
    $this->pager->setResultArray($this->issue->related_issue);
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->comment_form = new CommentForm();
    $this->comment_form->setDefault('issue_id', $request->getParameter('issue_id'));
    $this->comment_form->setDefault('profile_id', $this->getUser()->getProfile()->getId());
    $this->comment_form->setDefault('created_at', date('Y-m-d H:i:s', time()));
  }

  /**
   * Executes new action
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
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
    $this->forward404Unless(!is_null(Doctrine::getTable('Project')->find(array($request->getParameter('project_id')))));
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));
    $this->form = new idIssueForm($request->getParameter('project_id'), $issue);
  }

  /**
   * Executes update action
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
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
    $this->forward404Unless(!is_null(Doctrine::getTable('Project')->find(array($request->getParameter('project_id')))));
    $this->forward404Unless($issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id'))), sprintf('Object issue does not exist (%s).', array($request->getParameter('issue_id'))));
    $request->checkCSRFProtection();

    $project_id = $request->getParameter('project_id');

    $issue->delete();

    $this->redirect('@index_issue?project_id='.$project_id);
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
      $issue = $form->save();

      $this->redirect('@index_issue?project_id='.$issue->project_id);
    }
  }
}
