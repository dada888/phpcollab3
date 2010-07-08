<?php

class projectLogTimeForm extends PluginLogTimeForm
{
  protected $form_type = 'project';

  protected $project_id;

  public function  __construct($project_id, $object = null, $options = array(), $CSRFSecret = null)
  {
    $this->project_id = $project_id;
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure()
  {
    if (!isset($this->project_id))
    {
      throw new Exception('Cannnot use '.__CLASS__.' without setting the project id. [use setProjectId($project_id) method]');
    }
    
    parent::configure();
    $this->widgetSchema['issue_id']->setOption('query', Doctrine::getTable('Issue')->getQueryForProjectIssues($this->project_id));
    $this->widgetSchema['profile_id']->setOption('query', Doctrine::getTable('Profile')->getQueryForProjectUsers($this->project_id));
    
    $this->validatorSchema['issue_id']->setOption('query', Doctrine::getTable('Issue')->getQueryForProjectIssues($this->project_id));
    $this->validatorSchema['profile_id']->setOption('query', Doctrine::getTable('Profile')->getQueryForProjectUsers($this->project_id));
  }
}
