<?php

require_once '/usr/local/symfony_repository/1.2/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins(array('sfDoctrinePlugin', 'idRepositoryPlugin', 'idProjectManagmentPlugin', 'sfDoctrineGuardPlugin'));
    $this->disablePlugins(array('sfPropelPlugin'));
  }
}
