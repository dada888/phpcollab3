<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins(array('sfProtoculousPlugin',
                               'sfDoctrinePlugin',
                               'idRepositoryPlugin',
                               'idProjectManagmentPlugin',
                               'sfDoctrineGuardPlugin',
                               'sfJqueryReloadedPlugin',
                               'fdEventsListenersPlugin',
                               'idEstimatedTimePlugin',
                               'CommentPlugin',
                               'idUtilPlugin'));
    $this->disablePlugins(array('sfPropelPlugin'));
  }
}
