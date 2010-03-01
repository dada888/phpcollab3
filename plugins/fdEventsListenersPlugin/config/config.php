<?php

$path = sfConfig::get('app_eventslisteners_path', dirname(__FILE__).DIRECTORY_SEPARATOR.'to_listen_to.yml');
$events_to_listen_to = sfYamlConfigHandler::parseYaml($path);

foreach ($events_to_listen_to as $event => $parameters)
{
  if (isset($parameters["event_namespace"]) && isset($parameters["event_name"]))
  {
    $this->dispatcher
         ->connect($parameters["event_namespace"].'.'.$parameters["event_name"], array('EventListener', 'processEvent'));
  }
}
