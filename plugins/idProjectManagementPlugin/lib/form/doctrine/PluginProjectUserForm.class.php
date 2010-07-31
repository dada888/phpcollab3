<?php

/**
 * PluginProjectUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginProjectUserForm extends BaseProjectUserForm
{
  public function  setup() {
    parent::setup();

    $this->widgetSchema['role'] = new sfWidgetFormChoice(array('choices' => ProjectUser::getCodesAndRolesNoAdmin()));
    $this->validatorSchema['role'] = new sfValidatorChoice(array('choices' => array_keys(ProjectUser::getCodesAndRolesNoAdmin()), 'required' => true));
  }

  public static function generateFormsForProject(Project $project)
  {
    $forms = array();
    foreach ($project->getUsers() as $profile)
    {
      $project_user = Doctrine::getTable('ProjectUser')->findOneByProjectIdAndProfileId($project->id, $profile->id);
      $forms[] = new ProjectUserForm($project_user);
    }
    return $forms;
  }
}
