<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Project form.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 */

/**
 * Project form.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Forms
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idProjectForm extends ProjectForm
{
  /**
   * Configures the form fields
   */
  public function configure()
  {
    $date = sfContext::getInstance()->getUser()->getAttribute('creation_date');
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['created_at'] = new sfValidatorChoice(array('choices' => array($date)));
    $this->setDefault('created_at', $date);

    $this->validatorSchema['name'] = new sfValidatorString(
                                            array('max_length' => 64, 'min_length' => 3,'required' => true),
                                            array('max_length' => 'Project name %value% is too long (max %max_length% chars).',
                                                  'min_length' => 'Project name %value% is too short (min 3 chars).',
                                                  'required' => 'Project name is required'
                                                  )
                                                );
    $this->validatorSchema['description'] = new sfValidatorString(array('max_length' => 512, 'required' => false),
                                            array('max_length' => 'Project description is too long (max %max_length% chars).'
                                                  )
                                                );
    $this->validatorSchema['is_public'] = new sfValidatorBoolean(array('required' => false),
                                            array('invalid' => 'invalid'
                                                  )
                                                );
    
    parent::configure();
  }
}