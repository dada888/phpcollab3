<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idProjectManagementPlugin/lib/decorator/LogDecorator.php');


$t = new lime_test(25, new lime_output_color());

class EventLogMock
{
  public $message;
  public $action = 'action';
  public $namespace = 'namespace';

  public function __construct()
  {
    $this->message = 'my message to <a href="/example.com/1">johnny</a> user_ref#13 project_ref#14';
  }
}

$decorator = new LogDecorator(new EventLogMock());

$data = $decorator->extractDataFromMessage('message user_name#"Jhonny cannuccia" project_name#"Johnny project" project_id#1');
$t->is($data['message'],'message', 'correct message extraction');
$t->is($data['user_name'],'Jhonny cannuccia', 'correct data extraction');
$t->is($data['project_name'],'Johnny project', 'correct data extraction');
$t->is($data['project_id'],'1', 'correct data extraction');

$data = $decorator->extractDataFromMessage('user_name#"Amministro A." Created milestone first iteration');
$t->is($data['message'],'Created milestone first iteration', 'correct data extraction');
$t->is($data['user_name'],'Amministro A.', 'correct data extraction');

$data = $decorator->extractDataFromMessage('message user_ref#"nome cognome"');
$t->is($data['message'],'message', 'correct message extraction');
$t->is($data['user_ref'],'nome cognome', 'correct data extraction');

$data = $decorator->extractDataFromMessage('message bla#blu');
$t->is($data['message'],'message', 'correct message extraction');
$t->is($data['bla'],'blu', 'correct data extraction');

$data = $decorator->extractDataFromMessage('message bla#12');
$t->is($data['message'],'message', 'correct message extraction');
$t->is($data['bla'],'12', 'correct data extraction');

$data = $decorator->extractDataFromMessage('message 1234#ble');
$t->is($data['message'],'message', 'correct message extraction');
$t->is($data['1234'],'ble', 'correct data extraction');

$data = $decorator->extractDataFromMessage('message ble$23');
$t->is($data['message'],'message ble$23', 'correct message extraction');
$t->is(count($data),1, 'correct data extraction');

$data = $decorator->extractDataFromMessage('message <a href="/ulr/url.php">link</a>');
$t->is($data['message'],'message <a href="/ulr/url.php">link</a>', 'correct message extraction');
$t->is(count($data),1, 'correct data extraction');

$data = $decorator->extractDataFromMessage('1234#ble#wqd#dswq#dwq#');
$t->is($data['message'],'1234#ble#wqd#dswq#dwq#', 'correct message extraction');
$t->is(count($data),1, 'correct data extraction');

$t->is($decorator->namespace, 'namespace', 'decorator retrieves right namespace');
$t->is($decorator->action, 'action', 'decorator retrieves right action');
$t->is($decorator->message, 'my message to <a href="/example.com/1">johnny</a>', 'decorator strip special string from message');
$t->is($decorator->user_ref, '13', 'decorator strip special string from message');
$t->is($decorator->project_ref, '14', 'decorator strip special string from message');

unset($event_log);
unset($decorator);