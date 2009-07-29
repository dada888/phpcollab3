<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginProfileForm.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 */

/**
 * Class to define the comment form
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
abstract class PluginCommentForm extends BaseCommentForm
{
  /**
   * Override of the original setup of the comment form.
   * This new setup make hidden those fields required but that shouldn't be visible to the user.
   */
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'issue_id'   => new sfWidgetFormInputHidden(),
      'profile_id' => new sfWidgetFormInputHidden(),
      'body'       => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'Comment', 'column' => 'id', 'required' => false)),
      'issue_id'   => new sfValidatorDoctrineChoice(array('model' => 'Issue', 'required' => true)),
      'profile_id' => new sfValidatorDoctrineChoice(array('model' => 'Profile', 'required' => true)),
      'body'       => new sfValidatorString(array('max_length' => 1000, 'required' => true), array('required' => 'Comment cannot be empty', 'max_length' => 'Comment too long. max 1000 characters')),
      'created_at' => new sfValidatorDateTime(array('required' => true)),
    ));

    $this->widgetSchema->setNameFormat('comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}