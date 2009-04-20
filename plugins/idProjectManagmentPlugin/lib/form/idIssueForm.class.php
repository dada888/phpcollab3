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
 * @subpackage idProjectManagmentPlugin Forms
 */

/**
 * Form to diplay the right elements that could be related to an issue .
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */

class idIssueForm extends IssueForm
{
  private $project_id;


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
      ->from('Profile p');

    if (!is_null($this->project_id))
    {
      $q->leftJoin('p.projects pj')
        ->where('pj.id = '.$this->project_id);
    }

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
    $this->widgetSchema['status_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'Status'));
    $this->widgetSchema['priority_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'Priority'));
    $this->widgetSchema['starting_date'] = new sfWidgetFormDate();
    $this->widgetSchema['ending_date'] = new sfWidgetFormDate();
    $this->widgetSchema['project_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['users_list'] = new sfWidgetFormDoctrineChoiceMany(array('model' => 'Profile', 'query' => $this->getQueryForUsers()));



    $this->validatorSchema['status_id'] = new sfValidatorDoctrineChoice(array('model' => 'Status', 'column' => 'id', 'required' => true));
    $this->validatorSchema['priority_id'] = new sfValidatorDoctrineChoice(array('model' => 'Priority', 'column' => 'id', 'required' => true));
    $this->validatorSchema['starting_date'] = new sfValidatorDate(array('required' => false));
    $this->validatorSchema['ending_date'] = new sfValidatorDate(array('required' => false));
    $this->validatorSchema['project_id'] = new sfValidatorDoctrineChoice(array('model' => 'Project', 'column' => 'id', 'required' => true));
    $this->validatorSchema['users_list'] = new sfValidatorDoctrineChoiceMany(array('model' => 'Profile', 'alias' => '' ,'query' => $this->getQueryForUsers(), 'required' => false));

    parent::configure();
  }
}