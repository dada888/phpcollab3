<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginStatusForm.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 */

/**
 * PluginStatus form.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginStatusForm extends BaseStatusForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInput(),
      'status_type' => new sfWidgetFormSelect(array('choices' => sfConfig::get('app_statuses_types'))),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => 'Status', 'column' => 'id', 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'status_type' => new sfValidatorChoice(array('choices' => array_keys(sfConfig::get('app_statuses_types')))),
    ));

    $this->widgetSchema->setNameFormat('status[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    //parent::setup();
  }
}