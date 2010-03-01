<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idMilestoneActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 */

/**
 * idMilestoneActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idMilestoneActions extends sfActions
{
  /**
   * Shows a single milestone and related issues
   *
   * @param sfWebRequest $request
   */
  public function executeShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMilestone-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($this->milestone = Doctrine::getTable('Milestone')->find(array($request->getParameter('milestone_id'))), sprintf('Object milestone does not exist (%s).', array($request->getParameter('milestone_id'))));
    $this->forward404Unless($this->milestone->getProjectId() == $request->getParameter('project_id'));

    $this->project = $this->milestone->getProject();

    $this->pager = new sfDoctrinePager('Issue',10);
    $this->pager->setQuery(Doctrine::getTable('Issue')->getQueryForMilstoneIssues($this->project->getId(), $this->milestone->getId()));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->issues_estimated_time = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProjectMilestone($this->milestone->getProjectId(), $this->milestone->getId());
  }

  /**
   * Shows a list of mileste for a project
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMilestone-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    $this->forward404Unless($this->project = Doctrine::getTable('Project')->find(array($request->getParameter('project_id'))), sprintf('Object milestone does not exist (%s).', array($request->getParameter('project_id'))));
    $this->milestone_list = $this->project->getMilestones();
  }

  /**
   * Shows the creation form for a milestone
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMilestone-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($this->project = Doctrine::getTable('Project')->find(array($request->getParameter('project_id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('project_id'))));

    $this->form = new MilestoneForm();
    $this->form->setDefault('project_id', $this->project->getId());

    $this->setTemplate('edit');
  }

  /**
   * Checks if a form is valid and if it is not returns an error and the form
   *
   * @param sfWebRequest $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMilestone-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($request->isMethod('post'));
    $this->forward404Unless($this->project = Doctrine::getTable('Project')->find(array($request->getParameter('project_id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('project_id'))));

    $this->form = new MilestoneForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  /**
   * Shows the update form for a milestone
   *
   * @param sfWebRequest $request
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMilestone-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($milestone = Doctrine::getTable('Milestone')->find(array($request->getParameter('milestone_id'))), sprintf('Object milestone does not exist (%s).', array($request->getParameter('milestone_id'))));

    $this->project = $milestone->getProject();

    $this->form = new MilestoneForm($milestone);
  }

  /**
   * Chekcs if an updated form is valid and if it is not returns an error and the form
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMilestone-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($milestone = Doctrine::getTable('Milestone')->find(array($request->getParameter('milestone_id'))), sprintf('Object milestone does not exist (%s).', array($request->getParameter('milestone_id'))));

    $this->project = $milestone->getProject();

    $this->form = new MilestoneForm($milestone);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  /**
   * Deltes a particular milestone given the project id and the milestone id
   *
   * @param sfWebRequest $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMilestone-Delete'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $request->checkCSRFProtection();

    $this->forward404Unless($milestone = Doctrine::getTable('Milestone')->find(array($request->getParameter('milestone_id'))), sprintf('Object milestone does not exist (%s).', array($request->getParameter('milestone_id'))));
    $this->forward404Unless($milestone->getProjectId() == $request->getParameter('project_id'));

    $milestone->delete();

    $this->dispatcher->notify(new sfEvent($this, 'milestone.delete',
                                          array('user_id'=> $this->getUser()->getGuardUser()->getId(),
                                                'milestone_id' => $milestone->id
                                               )));

    $this->redirect('@show_project?id='.$milestone->getProjectId());
  }

  /**
   * Process the given form with the parameter from the request to verify if it is valid
   *
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $operation = $form->getObject()->isNew() ? 'creation' : 'update';
      $milestone = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'milestone.'.$operation.'_success',
                                                    array('user_id'=> $this->getUser()->getGuardUser()->getId(),
                                                          'milestone_id' => $milestone->id,
                                                          'form_parameters' => $request->getParameter($form->getName())
                                                         )));

      $this->redirect('@show_project?id='.$milestone->getProjectId());
    }
  }
}
