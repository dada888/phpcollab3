<?php


class syncPermissionsForActions extends idPermissions {

  protected function configure()
  {
    $this->namespace        = 'phpCollab';
    $this->name             = 'sync-permissions';
    $this->briefDescription = 'This task will deleted old permission no longer needed';

    $this->detailedDescription = <<<EOF
    This task will compare permissions into the database and permissions contained in the symfony project.
    It will delete those permission that are in the database but not in the files.
EOF;

    $this->addOption('filenameFormat', null, sfCommandOption::PARAMETER_OPTIONAL, 'with filename the task have to search for : ex. permission.yml, perms.yml, etc.', sfConfig::get('app_searchfor_filename', 'permissions.yml'));
    $this->addOption('permissionTableName', null, sfCommandOption::PARAMETER_OPTIONAL, 'gives to the database the name of the table where check if a permission exists and store it if it does not', sfConfig::get('app_searchfor_permissionTableName', 'sfGuardPermission'));
    $this->addOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null);
    $this->addOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine');
    $this->addOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev');

    parent::configure();
  }

  protected function deletePermissionByName($name)
  {
    return Doctrine::getTable('sfGuardPermission')
      ->createQuery()
      ->delete('sfGuardPermission p')
      ->where('p.name = ?', $name)
      ->execute();
  }

  protected function deleteOldPermissions($permissions)
  {
    $existing_permissions = $this->createArrayOfExistingPermissionsNames(
                                                                          $this->getQueryForExistingPermissions($options)
                                                                            ->where('p.name <> ? AND p.name <> ?', array('admin', 'user'))
                                                                            ->execute(array(), Doctrine::HYDRATE_ARRAY)
                                                                        );

    foreach ($permissions as $permission)
    {
      if (!isset($permission['name']))
      {
         $this->printErroLogForEmptyName();
         return false;
      }

      $key = array_search($permission['name'], $existing_permissions);
      if ($key !== false)
      {
        unset($existing_permissions[$key]);
      }
    }

    if (count($existing_permissions) > 0)
    {
      foreach ($existing_permissions as $permission)
      {
        $this->logSection('Deleting permissions : ','...');
        $this->deletePermissionByName($permission);
        $this->logSection($permission, ' deleted.');
      }

      return true;
    }

    return false;
  }


  protected function execute($arguments = array(), $options = array())
  {
    $this->logSection('Scanning folder '.$dir, '');

    $permission_files = $this->findPermissionsFiles($options);

    if (!$this->deleteOldPermissions($this->retrievePermissionsFromFiles($permission_files)))
    {
      $this->logSection('No permissions deleted.','');
    }
  }

}