<?php

include(dirname(__FILE__).'/../../../../test/bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

//1) Generazione evento
//2) Catch dell'evento da parte dell'EventListener
//3) Salvataggio dell'evento sul database

class stub {}

$t = new lime_test(9, new lime_output_color());

$event = new sfEvent(new stub, 'stub_namespace.creation', array());

$namespace = EventListener::extracNamespace($event);
$t->is('stub_namespace', $namespace, '::extracNamespace() extract the right value');

$action = EventListener::extracAction($event);
$t->is('creation', $action, '::extracNamespace() extract the right value');

$event = new sfEvent(new stub, 'stub_namespace.creation', array());
$message = EventListener::processParameters($event);
$t->is('creation on stub_namespace performed', $message, '::processParameters() generates the right message');

$event = new sfEvent(new stub, 'stub_namespace.creation', array('log_message' => '<a href="http://example.com/user/1">Johnny</a> created issue <a href="http://example.com/issue/1">#1</a> and I\'m logging this action'));
$message = EventListener::processParameters($event);
$t->is('<a href="http://example.com/user/1">Johnny</a> created issue <a href="http://example.com/issue/1">#1</a> and I\'m logging this action', $message, '::processParameters() generates the right message');

$parameters_structure = array('message_structure' => array('subject', 'action', 'object'));
$parameters = array('message_data' => array('subject' => 'I', 'action' => 'am', 'object' => 'a log message'));
$event = new sfEvent(new stub, 'stub_namespace.creation', array($parameters_structure, $parameters));
$message = EventListener::processParameters($event);
$t->is('I am a log message', $message, '::processParameters() generates the right message');

EventListener::processEvent($event);
$event_db = Doctrine::getTable('EventLog')->findOneBy('namespace', 'stub_namespace');
$t->is('I am a log message', $event_db->message, '::processEvent() store message into db');
$t->is('stub_namespace', $event_db->namespace, '::processEvent() store namespace into db');
$t->is('creation', $event_db->action, '::processEvent() store action into db');
$t->like($event_db->created_at, '/'.date('Y-m-d H:i').'/', '::processEvent() store creation date into db');
