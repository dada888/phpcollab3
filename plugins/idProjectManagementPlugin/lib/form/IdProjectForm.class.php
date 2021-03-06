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
 * @subpackage idProjectManagementPlugin Forms
 */

/**
 * Project form.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Forms
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idProjectForm extends ProjectForm
{
  /**
   * Proxy method for retriving a query that select all the user but the super admin
   *
   * @return <type>
   */
  private function retriveAllButSuperAdmin()
  {
    return Doctrine_Query::create()
            ->from('sfGuardUser u')
            ->where('u.is_super_admin = 0');
  }

  /**
   * Configures the form fields
   */
  public function configure()
  {
    $this->widgetSchema['users_list'] = new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'multiple' => true, 'query' => $this->retriveAllButSuperAdmin()));
    
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
    $this->validatorSchema['users_list'] = new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'multiple' => true, 'required' => false, 'query' => $this->retriveAllButSuperAdmin()));
    
    parent::configure();

    unset($this['costs']);
    unset($this['created_at']);
    unset($this['updated_at']);
    unset($this['is_public']);
  }
}