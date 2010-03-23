<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginProjectFormFilter.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Filters
 */

/**
 * PluginProject form.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Filters
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginProjectFormFilter extends BaseProjectFormFilter
{
  public function setup()
  {
    parent::setup();
    $this->useFields(array('name', 'starting_date', 'end_date', 'created_at'));

    $this->widgetSchema['created_at'] = new sfWidgetFormDate();
    $this->validatorSchema['created_at'] = new sfValidatorDate(array('required' => false));

    $this->widgetSchema['name'] = new sfWidgetFormInputText();
    $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 64, 'required' => false), array('max_length' => 'Project name %value% is too long (max %max_length% chars).'));
  }
}