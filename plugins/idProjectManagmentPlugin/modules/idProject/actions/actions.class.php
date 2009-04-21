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
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * idProject actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
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
    $this->forward404Unless($this->getUser()->isMyProject($request->getParameter('id')) && $this->project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))));
    $this->users = $this->project->getProjectUsers();
  }

  /**
   * Executes index action
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new FormFilters();
    $q = null;

    if ($request->hasParameter('project_filters'))
    {
      $project_filters = $request->getParameter('project_filters');
      $this->form->bind($project_filters);

      if ($this->form->isValid())
      {
        $q = $this->getUser()->getQueryForMyProjects();
        
        $from_date = null;
        if(!empty($project_filters['created_at']['year']))
        {
          $from_date = date('Y-m-d H:i:s', strtotime($project_filters['created_at']['year']."-".$project_filters['created_at']['month']."-".$project_filters['created_at']['day']));
        }

        !empty($project_filters['name']) ? $q->where('name LIKE ?', "%".$project_filters['name']."%") : null;
        $project_filters['is_public'] != '' ? $q->andWhere('is_public = ?', $project_filters['is_public']) : null;
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
    $this->getUser()->setAttribute('creation_date', date('Y-m-d H:i:s', time()));
    
    $this->form = new idProjectForm();
  }

  /**
   * Executes create action
   *
   * @param sfWebRequest $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new idProjectForm();
    
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
    $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('id'))));
    $this->getUser()->setAttribute('creation_date', $project->getCreatedAt());

    $this->form = new idProjectForm($project);
  }

  /**
   * Executes update action
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('id'))));
    
    $this->form = new idProjectForm($project);
    
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

    $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', array($request->getParameter('id'))));
    $project->delete();

    $this->redirect('idProject/index');
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
    $form_parameters['id'] ? $form_parameters['updated_at'] = $date : null;
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

      $this->redirect('idProject/show/?id='.$project->getId());
    }
  }
}
