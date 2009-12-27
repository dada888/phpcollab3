<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Project filters form.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Filters
 */

/**
 * Project filters form.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Filters
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class FormFilters extends PluginProjectFormFilter
{
  /**
   * Configures the form fields
   */
  public function configure()
  {
    unset(
      $this['id'], $this['description'],$this['updated_at']
    );

    $this->widgetSchema['created_at'] = new sfWidgetFormDate();
    $this->widgetSchema['is_public'] = new sfWidgetFormChoice(array('choices' => array('' => 'Public or Private', 1 => 'Public', 0 => 'Private')));
    $this->validatorSchema['created_at'] = new sfValidatorDate(array('required' => false));


    $this->widgetSchema['name'] = new sfWidgetFormInput();
    $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 64, 'required' => false), array('max_length' => 'Project name %value% is too long (max %max_length% chars).'));
  }
}

?>
