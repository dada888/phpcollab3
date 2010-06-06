<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$t = new lime_test(7, new lime_output_color());


$commenti_utente = Doctrine::getTable('fdComment')->getQueryForListByModelAndFieldAndValue('Message', 'id', '1')->execute();
$t->is(count($commenti_utente), 12, 'getQueryForListByModelAndFieldAndValue ok');

$commenti_utente = Doctrine::getTable('fdComment')->getQueryForCommentsByProfileId(3)->execute();
$t->is(count($commenti_utente), 6, 'getQueryForCommentsByProfileId ok');

$commenti_utente = Doctrine::getTable('fdComment')->getQueryForCommentsByProfileIdAndModel(3, 'Message')->execute();
$t->is(count($commenti_utente), 4, 'getQueryForCommentsByProfileIdAndModel ok');

$commenti_utente = Doctrine::getTable('fdComment')->getQueryForCommentsByProfileIdAndModelAndModelFieldValue(3, 'Message', 1)->execute();
$t->is(count($commenti_utente), 2, 'getQueryForCommentsByProfileIdAndModelAndModelFieldValue ok');

$commenti_utente = Doctrine::getTable('fdComment')->getQueryForProfilesByModelAndModelFieldValue('Message', 1)->execute();
$t->is(count($commenti_utente), 3, 'getQueryForProfilesByModelAndModelFieldValue ok');

$config = sfConfig::get('sf_confing_comments_plugin_Profile', array());
$profile = Doctrine::getTable('fdComment')->getProfileForComment(1);
$t->ok($profile instanceof $config['class_name'], 'getProfileForComment ok');

$profile = Doctrine::getTable('fdComment')->getProfileForComment(123456789);
$t->ok($profile === false, 'getProfileForComment ok');
