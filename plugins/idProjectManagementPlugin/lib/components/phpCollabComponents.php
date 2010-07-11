<?php

abstract class phpCollabComponents extends sfComponents
{
  /**
   * Retrieve parameter £parameter_name from request
   * and returns the result of apply php function empty()
   *
   * @param string $parameter_name
   */
  protected function isRequestFieldEmpty($parameter_name)
  {
    $value = $this->getRequest()->getParameter($parameter_name);
    return empty($value);
  }


  protected function retrieveProject($project_identifier = 'project_id')
  {
    if(!$this->isRequestFieldEmpty($project_identifier))
    {
      return Doctrine::getTable('Project')->findOneBy('id', $this->getRequestParameter($project_identifier));
    }
  }

  protected function retrieveProjectReport(Project $project)
  {
    $reports = Doctrine::getTable('Project')->getReportsOnProjectsWithEffortChart(array($project));
    return (count($reports) > 0) ? $reports[$this->project->id] : null;
  }

  protected function retrieveProjectByIssue()
  {
    if(!$this->isRequestFieldEmpty('issue_id'))
    {
      return Doctrine::getTable('Project')->getProjectFromIssueId($this->getRequest()->getParameter('issue_id'));
    }
  }
}

