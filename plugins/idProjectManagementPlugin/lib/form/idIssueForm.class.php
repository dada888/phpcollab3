<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idIssueForm
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Forms
 */

/**
 * Form to diplay the right elements that could be related to an issue .
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Forms
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */

class idIssueForm extends IssueForm
{
  protected $project_id;

  /**
   * Adds orderby option to the query on the <field_name>
   *
   * @param Doctrine_Query $q
   */
  private function addOrderByPositionOption(Doctrine_Query $q, $table_alias = 't', $filed_name = 'position')
  {
    $q->addOrderBy($table_alias.'.'.$filed_name);
  }

  private function getQueryForPriorityList()
  {
    $q = Doctrine_Query::create()
      ->from('Priority t');
    $this->addOrderByPositionOption($q);

    return $q;
  }


  private function getQueryForStatusesList()
  {
    $q = Doctrine_Query::create()
      ->from('Status t');
    $this->addOrderByPositionOption($q);

    return $q;
  }

  /**
   * Add to a Doctrine_Query object the options for a query that selects users from a project.
   * The project is specified at the creation of the form by its identifier.
   * If that is not given the query returns every single user of the system.
   *
   * @access private
   * @return Doctrine_Query
   */
  private function getQueryForUsers()
  {
    $q = Doctrine_Query::create()
      ->from('sfGuardUser u')
      ->leftJoin('u.Projects pj')
      ->where('pj.id = '.$this->project_id);

    return $q;
  }

  /**
   * Add to a Doctrine_Query object the options for a query that selects project milestones.
   * The project is specified at the creation of the form by its identifier.
   *
   * @access private
   * @return Doctrine_Query
   */
  private function getQueryForMilestones()
  {
    $q = Doctrine_Query::create()
      ->from('Milestone m')
      ->leftJoin('m.project pj')
      ->where('pj.id = '.$this->project_id);

    return $q;
  }

  /**
   * Add to a Doctrine_Query object the options for a query that selects project issues.
   * The project is specified at the creation of the form by its identifier.
   *
   * @access private
   * @return Doctrine_Query
   */
  private function getQueryForRelatedIssue()
  {
    $q = Doctrine_Query::create()
      ->from('Issue i')
      ->where('i.project_id = '.$this->project_id);

    if (!$this->getObject()->isNew())
    {
      $q->addWhere('i.id <> '.$this->getObject()->id);
    }

    return $q;
  }

  private function getQueryForProjectTrakers()
  {
    $q = Doctrine_Query::create()
      ->from('Tracker t')
      ->leftJoin('t.projects p')
      ->where('p.id = '.$this->project_id);

    return $q;
  }

  /**
   * Inizialize the project identifier and call the parent construct method.
   *
   * @param mixed $project_id
   */
  public function __construct($project_id = null, $object = null, $options = array(), $CSRFSecret = null)
  {
    $this->project_id = $project_id;
    parent::__construct($object, $options, $CSRFSecret);
  }

  /**
   * Configures the form fields
   */
  public function configure()
  {
    $this->widgetSchema['status_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'Status', 'query' => $this->getQueryForStatusesList()));
    $this->widgetSchema['priority_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'Priority', 'query' => $this->getQueryForPriorityList()));
    $this->widgetSchema['tracker_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'Tracker', 'add_empty' => true, 'query' => $this->getQueryForProjectTrakers()));
    
    $today = date('m/d/Y', time());
    $parameters = $this->isNew() ? array('default' => $today) : array();
    $this->widgetSchema['starting_date'] = new sfWidgetFormDate($parameters);

    $this->widgetSchema['title'] = new sfWidgetFormInputText();
    $this->widgetSchema['tracker_id']->setOption('add_empty', false);
    $this->widgetSchema['description']->setAttribute('rows', 4);
    $this->widgetSchema['users_list']->setAttribute('size', 5);
    
    $this->widgetSchema['ending_date'] = new sfWidgetFormDate();
    $this->widgetSchema['project_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['users_list'] = new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'multiple' => true, 'query' => $this->getQueryForUsers()));
    $this->widgetSchema['milestone_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'Milestone', 'add_empty' => true, 'query' => $this->getQueryForMilestones()));
    $this->widgetSchema['issues_list'] = new sfWidgetFormDoctrineChoice(array('model' => 'Issue', 'multiple' => true, 'query' => $this->getQueryForRelatedIssue()));
    $this->widgetSchema['issues_list']->setAttribute('size', 5);


    $this->validatorSchema['status_id'] = new sfValidatorDoctrineChoice(array('model' => 'Status', 'column' => 'id', 'required' => true));
    $this->validatorSchema['priority_id'] = new sfValidatorDoctrineChoice(array('model' => 'Priority', 'column' => 'id', 'required' => true));
    $this->validatorSchema['starting_date'] = new sfValidatorDate(array('required' => false));
    $this->validatorSchema['ending_date'] = new sfValidatorDate(array('required' => false));
    $this->validatorSchema['project_id'] = new sfValidatorDoctrineChoice(array('model' => 'Project', 'column' => 'id', 'required' => true));
    $this->validatorSchema['users_list'] = new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'multiple' => true, 'query' => $this->getQueryForUsers(), 'required' => false));
    $this->validatorSchema['milestone_id'] = new sfValidatorDoctrineChoice(array('model' => 'Milestone', 'query' => $this->getQueryForMilestones(), 'required' => false));
    $this->validatorSchema['title'] = new sfValidatorString(array('required' => true,'max_length' => 256), array('required' => 'Title is mandatory'));
    $this->validatorSchema['issues_list'] = new sfValidatorDoctrineChoice(array('model' => 'Issue', 'multiple' => true, 'required' => false, 'query' => $this->getQueryForRelatedIssue()));
    $this->validatorSchema['estimated_time'] = new sfValidatorNumber(array('min' => '0', 'required' => false), array('min' => 'You cannot set a negative estimated time'));

    unset($this['created_at']);
    unset($this['updated_at']);

    parent::configure();
  }
}