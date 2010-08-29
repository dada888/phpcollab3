<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$t = new lime_test(7, new lime_output_color());


$commenti_utente = Doctrine::getTable('fdComment')->getQueryForListByModelAndFieldAndValue('Message', 'id', '1')->execute();
$t->is(count($commenti_utente), 12, 'getQueryForListByModelAndFieldAndValue ok');

$commenti_utente = Doctrine::getTable('fdComment')->getQueryForCommentsByUserId(3)->execute();
$t->is(count($commenti_utente), 6, 'getQueryForCommentsByUserId ok');

$commenti_utente = Doctrine::getTable('fdComment')->getQueryForCommentsByUserIdAndModel(3, 'Message')->execute();
$t->is(count($commenti_utente), 4, 'getQueryForCommentsByUserIdAndModel ok');

$commenti_utente = Doctrine::getTable('fdComment')->getQueryForCommentsByUserIdAndModelAndModelFieldValue(3, 'Message', 1)->execute();
$t->is(count($commenti_utente), 2, 'getQueryForCommentsByUserIdAndModelAndModelFieldValue ok');

$commenti_utente = Doctrine::getTable('fdComment')->getQueryForUsersByModelAndModelFieldValue('Message', 1)->execute();
$t->is(count($commenti_utente), 3, 'getQueryForUsersByModelAndModelFieldValue ok');

$config = sfConfig::get('sf_confing_comments_plugin_Profile', array());
$user = Doctrine::getTable('fdComment')->getUserForComment(1);
$t->ok($user instanceof $config['class_name'], 'getUserForComment ok');

$user = Doctrine::getTable('fdComment')->getUserForComment(123456789);
$t->ok($user === false, 'getUserForComment ok');
