<?php

require_once dirname(__FILE__).'/../../config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::getApplicationConfiguration('fe', 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);

// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_app_cache_dir'));

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../lib/vendor/symfony/lib/helper/HelperHelper.php');
include(sfConfig::get('sf_plugins_dir').'/idProjectManagementPlugin/lib/helper/AutoLinkHelper.php');

$t = new lime_test(3, new lime_output_color());

$text = "pippolo http://google.com and pippo@pippolo.it";

$t->is(auto_link($text, 'all'), 'pippolo <a href="http://google.com">http://google.com</a> and <a href="mailto:pippo@pippolo.it">pippo@pippolo.it</a>', 'all ok');

$t->is(auto_link($text, 'email_addresses'), 'pippolo http://google.com and <a href="mailto:pippo@pippolo.it">pippo@pippolo.it</a>', 'email_addresses ok');

$t->is(auto_link($text, 'urls'), 'pippolo <a href="http://google.com">http://google.com</a> and pippo@pippolo.it', 'urls ok');


