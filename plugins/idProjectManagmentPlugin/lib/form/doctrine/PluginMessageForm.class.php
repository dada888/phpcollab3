<?php

/**
 * PluginMessage form.
 *
 * @package    form
 * @subpackage Message
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginMessageForm extends BaseMessageForm
{
  public function setup()
  {
    parent::setup();
    
    unset(
      $this['profile_id'], $this['project_id'], $this['created_at']
    );

    $this->validatorSchema['title'] = new sfValidatorString(array('max_length' => 512, 'required' => true), array('required' => 'Title cannot be empty'));
    $this->validatorSchema['body'] = new sfValidatorString(array('max_length' => 3000, 'required' => true), array('required' => 'Body cannot be empty'));

  }
}