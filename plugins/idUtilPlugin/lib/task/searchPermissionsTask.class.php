<?php


class searchPermissionsForActions extends idPermissions {

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
    Permission name format : <module>-<permission>
EOF;

    $this->addOption('dir', null, sfCommandOption::PARAMETER_OPTIONAL, 'directory where the task starts to search. ex: test, plugins/MyPlugin, etc.', sfConfig::get('sf_root_dir'));
    $this->addOption('filenameFormat', null, sfCommandOption::PARAMETER_OPTIONAL, 'with filename the task have to search for : ex. permission.yml, perms.yml, etc.', sfConfig::get('app_searchfor_filename', 'permissions.yml'));
    $this->addOption('depth', null, sfCommandOption::PARAMETER_OPTIONAL, 'tell to the finder how many level deep it has to go in looking for permissions files', sfConfig::get('app_searchfor_deph', '5'));
    $this->addOption('permissionTableName', null, sfCommandOption::PARAMETER_OPTIONAL, 'gives to the database the name of the table where check if a permission exists and store it if it does not', sfConfig::get('app_searchfor_permissionTableName', 'sfGuardPermission'));
    $this->addOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null);
    $this->addOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine');
    $this->addOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev');

    parent::configure();
  }

  protected function configIgnore()
  {
    parent::configIgnore();
    $this->addIgnoreFolder('test');
  }

  protected function cleanPermissionsArrayFromExistentPermissions($permissions)
  {
    $existing_permissions = $this->createArrayOfExistingPermissionsNames($this->getQueryForExistingPermissions($options)
                                                                          ->execute(array(), Doctrine::HYDRATE_ARRAY)
                                                                        );
    $new_permissions = array();
    foreach ($permissions as $permission)
    {
      if (!isset($permission['name']) || empty($permission['name']))
      {
         $this->printErroLogForEmptyName();
         return false;
      }

      if (empty($existing_permissions) || !in_array($permission['name'], $existing_permissions))
      {
        $new_permission = new sfGuardPermission();
        $new_permission->setName($permission['name']);
        $new_permission->setDescription(isset($permission['description']) ? $permission['description'] : null);
        $new_permissions[] = $new_permission;
      }
    }
    return $new_permissions;
  }

  protected function saveNewPermissions($new_permissions)
  {
    $sfGuardGroup_admin = Doctrine::getTable('sfGuardGroup')
                            ->createQuery()
                            ->from('sfGuardGroup sgg')
                            ->where('sgg.name = ?', 'admin')
                            ->fetchOne();

    foreach ($new_permissions as $new_permission)
    {
      $this->logSection('Saving : ','...');
      $new_permission->save();
      $this->logSection($new_permission->getName(),' saved');
      $sfGuardGroupPermission = new sfGuardGroupPermission();
      $sfGuardGroupPermission->group_id = $sfGuardGroup_admin->getId();
      $sfGuardGroupPermission->permission_id = $new_permission->getId();
      $sfGuardGroupPermission->save();
      $this->logSection('Admin permission : ','updated');
    }
  }

  protected function execute($arguments = array(), $options = array())
  {
    if (!isset($options['dir']) || $options['dir'] !== sfConfig::get('sf_root_dir'))
    {
      $options['dir'] = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$options['dir'];
    }

    $this->logSection('Searching : ','Scanning folder '.$options['dir']);

    $permission_files = $this->findPermissionsFiles($options);
    $this->logSection('Searching : ','Searching for new permissions');

    $new_permissions = $this->cleanPermissionsArrayFromExistentPermissions(
                                      $this->retrievePermissionsFromFiles($permission_files)
                                    );

    if ($new_permissions === false || empty($new_permissions))
    {
      $this->logSection('Searching : ','No new permission.');
      return;
    }

    $this->saveNewPermissions($new_permissions);

    $this->logSection('Searching : ','Permissions updated.');
  }

}