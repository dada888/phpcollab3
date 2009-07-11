<?php

abstract class idPermissions extends sfBaseTask {

  protected function createArrayOfExistingPermissionsNames($existing_permissions)
  {
    $names_array = array();
    foreach ($existing_permissions as $permission)
    {
      $names_array[] = $permission['name'];
    }
    return $names_array;
  }

  protected function getQueryForExistingPermissions($options)
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $table = isset($options['permissionTableName']) ? $options['permissionTableName'] : 'sfGuardPermission';

    return Doctrine::getTable($table)
            ->createQuery()
            ->select('p.name as name')
            ->from($table.' p');
  }

  protected function findPermissionsFiles($options)
  {
    $permissions_files = sfFinder::type('file')
                          ->maxdepth(isset($options['depth']) ? $options['depth'] : 6 )
                          ->name(isset($options['filenameFormat']) ? $options['filenameFormat'] : 'permissions.yml')
                          ->in(isset($options['dir']) ? $options['dir'] : sfConfig::get('sf_root_dir') );

    if (empty($permissions_files))
    {
      $this->printErrorFilesNotFound($options);
      return array();
    }
    return $permissions_files;
  }

  protected function checkPermissionNameFormat($name)
  {
    list($module, $permission) = split('-', $name, 2);
    
    if (!empty($module) && !empty($permission))
    {
      return true;
    }
    
    return false;
  }

  protected function checkPermissionsFormat($permissions)
  {
    foreach ($permissions as $permission)
    {
      if (!$this->checkPermissionNameFormat($permission['name']))
      {
        $this->printErroLogForNameFormat($permission['name']);
        return false;
      }
    }
    return true;
  }



  protected function retrievePermissionsFromFiles($permissions_files)
  {
    if (empty($permissions_files))
    {
      return array();
    }

    $permissions = array();
    foreach ($permissions_files as $file_path)
    {
      $permissions = array_merge($permissions, sfYamlConfigHandler::parseYaml($file_path));
    }

    if ($this->checkPermissionsFormat($permissions))
    {
      return $permissions;
    }

    return array();
  }

  protected function printErroLogForEmptyName()
  {
    $this->logSection('Checking format', 'Cannot fetch permission without a name parameter.', null, 'ERROR');
  }

  protected function printErroLogForNameFormat($name)
  {
    $this->logSection('Checking format', 'Invalid format : '.$name, null, 'ERROR');
  }

  protected function printErrorFilesNotFound($options)
  {
    $this->logSection('Search response : ', 'no '.(isset($options['filenameFormat']) ? $options['filenameFormat'] : 'permissions.yml') .' file found.', null,'ERROR');
  }

}
