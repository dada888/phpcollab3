<?php

require_once dirname(__FILE__).'/../../config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::getApplicationConfiguration('fe', 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);

// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_app_cache_dir'));

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../lib/vendor/symfony/lib/helper/HelperHelper.php');
include(dirname(__FILE__).'/../../lib/vendor/symfony/lib/helper/UrlHelper.php');
include(dirname(__FILE__).'/../../lib/vendor/symfony/lib/helper/TagHelper.php');
include(sfConfig::get('sf_plugins_dir').'/idProjectManagementPlugin/lib/helper/DashboardHelper.php');

$t = new lime_test(2, new lime_output_color());

//$link = link_project('Project', 2);
//$t->is($link, '<a href="/en/idProject/show/2">Project</a>', 'link_project works correctly');

$link = link_project('Project', null);
$t->is($link, 'Project', 'link_project works correctly');

$link = link_project(null, null);
$t->is(null, $link, 'link_project works correctly');

