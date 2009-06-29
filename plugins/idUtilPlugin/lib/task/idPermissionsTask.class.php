<?php


class searchPermissionsForActions extends sfBaseTask {



  protected function configure()
  {
    $this->namespace        = 'phpCollab';
    $this->name             = 'search-permissions';
    $this->briefDescription = 'this task will look for modules actions permissions';

    $this->detailedDescription = <<<EOF
    This task will look for modules actions permissions.
    If they are foud:
      - it will check if they are already loaded into the database;
      - It will load those that are new;
      - It will delete those that are not anymore on the system;
EOF;

    $this->addOption('dir', null, sfCommandOption::PARAMETER_OPTIONAL, 'directory where the task starts to search. ex: test, plugins/MyPlugin, etc.', sfConfig::get('sf_root_dir'));
    $this->addOption('filenameFormat', null, sfCommandOption::PARAMETER_OPTIONAL, 'with filename the task have to search for : ex. permission.yml, perms.yml, etc.', sfConfig::get('app_searchfor_filename', 'permissions.yml'));
    $this->addOption('depth', null, sfCommandOption::PARAMETER_OPTIONAL, 'tell to the finder how many level deep it has to go in looking for permissions files', sfConfig::get('app_searchfor_deph', '5'));
    $this->addOption('permissionTableName', null, sfCommandOption::PARAMETER_OPTIONAL, 'gives to the database the name of the table where check if a permission exists and store it if it does not', sfConfig::get('app_searchfor_permissionTableName', 'sfGuardPermission'));
  }

  protected function cleanPermissionsArrayFromExistentPermissions($permissions)
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
  }

  protected function execute($arguments = array(), $options = array())
  {
    if (!isset($options['dir']) || $options['dir'] !== sfConfig::get('sf_root_dir'))
    {
      $options['dir'] = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$options['dir'];
    }
    
    $this->logSection('Scanning folder '.$options['dir'], '');

    $permission_files = sfFinder::type('file')
                          ->maxdepth($options['depth'])
                          ->name('permissions.yml')
                          ->in($options['dir']);

    if (empty($permission_files))
    {
      $this->logSection('Search response : ', 'no '.$options['filenameformat'].' file found.');
      return;
    }

    $permissions = array();
    foreach ($permission_files as $file_path)
    {
      $permissions = array_merge($permissions, sfYamlConfigHandler::parseYaml($file_path));
    }

    var_dump($permissions);die();
    $this->logSection('Searching for new permissions', '');
    $new_permissions = $this->cleanPermissionsArrayFromAlreadyPresentPermissions($permissions);

    if (empty($new_permissions))
    {
      $this->logSection('No new permission.', '');
      return;
    }
  }

}