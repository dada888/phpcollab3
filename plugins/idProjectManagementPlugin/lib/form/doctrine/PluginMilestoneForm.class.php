<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginMilestoneForm.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 */

/**
 * PluginMilestoneForm form.
 * Override of default setup.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
abstract class PluginMilestoneForm extends BaseMilestoneForm
{
  public function setup()
  {
    $today = date('m/d/Y', time());
    $parameters = $this->isNew() ? array('default' => $today) : array();

    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'title'           => new sfWidgetFormInput(),
      'estimated_time'  => new sfWidgetFormInput(),
      'description'     => new sfWidgetFormTextarea(),
      'starting_date'   => new sfWidgetFormDate($parameters),
      'ending_date'     => new sfWidgetFormDate(),
      'project_id'      => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => 'Milestone', 'column' => 'id', 'required' => false)),
      'title'         => new sfValidatorString(array('required' => true , 'max_length' => 3,'max_length' => 64),
                                                            array('required' => 'Title is mandatory', 'min_length' => 'Title is too short', 'max_length' => 'Title is too long')),
      'description'   => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'starting_date' => new sfValidatorDate(array('required' => false)),
      'ending_date'   => new sfValidatorDate(array('required' => false)),
      'project_id'    => new sfValidatorDoctrineChoice(array('model' => 'Project')),
      'estimated_time' => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('milestone[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}