<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idProject actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 */

/**
 * idProject actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idProjectActions extends sfActions
{
  /**
   * Executes show action
   *
   * @param sfWebRequest $request
   */
  public function executeShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProject-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($this->getUser()->isMyProject($request->getParameter('id')));
    
    $this->project = Doctrine::getTable('Project')->getProjectMilestonesAndUsers($request->getParameter('id'));
    $this->recent_activities = $this->recent_activities = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDaysByProjectsIds(3, array($request->getParameter('id')), 'LogDecorator');
  }

   /**
   * Executes roadmap action
   *
   * @param sfWebRequest $request
   */
  public function executeRoadmap(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProject-ViewRoadmap'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($this->getUser()->isMyProject($request->getParameter('id')));
    $this->forward404Unless($this->project = Doctrine::getTable('Project')->getProjectRelatedMilestonesAndIssues($request->getParameter('id')));
  }

  /**
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProject-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $q = null;
    if ($request->hasParameter('project_filters'))
    {
      $form = new ProjectFormFilter();
      $project_filters = $request->getParameter('project_filters');
      $form->bind($project_filters);

      if ($form->isValid())
      {
        $q = $this->getUser()->getQueryForMyProjects();
        
        $from_date = null;
        if(!empty($project_filters['created_at']['year']))
        {
          $from_date = date('Y-m-d H:i:s', strtotime($project_filters['created_at']['year']."-".$project_filters['created_at']['month']."-".$project_filters['created_at']['day']));
        }
        
        !empty($project_filters['name']) ? $q->where('name LIKE ?', "%".$project_filters['name']."%") : null;
        !is_null($from_date) ? $q->andWhere("created_at > '".$from_date."'") : null;
      }
    }
    
    $this->project_list = $this->getUser()->getMyProjects($q);
  }

  /**
   * Executes new action
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProject-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->form = new idProjectForm();
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));
    $this->form->setDefault('starting_date', date('Y-m-d H:i:s', time()));
  }

  /**
   * Executes create action
   *
   * @param sfWebRequest $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProject-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new idProjectForm();
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));
    
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
    $this->forwardUnless($this->getUser()->hasCredential('idProject-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($this->project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('id'))));

    $this->form = new idProjectForm($this->project);
  }

  /**
   * Executes update action
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProject-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($this->project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('id'))));
    
    $this->form = new idProjectForm($this->project);
    
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
    $this->forwardUnless($this->getUser()->hasCredential('idProject-Delete'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $request->checkCSRFProtection();

    $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('id'))));
    $project->delete();

    $this->redirect('idProject/index');
  }

  public function executeStaffList(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProject-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($this->project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('id'))));
  }

  /**
   * sets the update date
   *
   * @param array $form_parameters
   * @return array
   */
  private function setUpdatedAt($form_parameters)
  {
    $date = array('year' => date('Y'), 'month' => date('m'), 'day' => date('d'), 'hour' => date('H'), 'minute' => date('i'));
    $form_parameters['updated_at'] = $date;
    return $form_parameters;
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
    $form_parameters = $this->setUpdatedAt($request->getParameter($form->getName()));
    $form->bind($form_parameters);
    if ($form->isValid())
    {
      $project = $form->save();
      if (!$this->getUser()->isAdmin())
      {
        $user_profile = $this->getUser()->getGuardUser()->getProfile();
        $project->users[0] = $user_profile;
        $project->save();
        $user_profile->refreshRelated();
      }

      $this->redirect('@show_project?id='.$project->getId());
    }
  }
}
