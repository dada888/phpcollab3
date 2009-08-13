<?php

/**
 * PluginLogTime form.
 *
 * @package    form
 * @subpackage LogTime
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginLogTimeForm extends BaseLogTimeForm
{
  public function setup()
  {
    parent::setup();
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
  }
}