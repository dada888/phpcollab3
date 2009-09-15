<?php

$path = sfConfig::get('app_eventslisteners_path', dirname(__FILE__).DIRECTORY_SEPARATOR.'ell.yml');
$events_to_listen_to = sfYamlConfigHandler::parseYaml($path);

foreach ($events_to_listen_to as $event => $parameters)
{
  if (isset($parameters["event_namespace"]) &&
      isset($parameters["event_name"]) &&
      isset($parameters["listener_class"]) &&
      isset($parameters["listener_method"]))
  {
    $this->dispatcher->connect($parameters["event_namespace"].'.'.$parameters["event_name"],
                               array($parameters["listener_class"], $parameters["listener_method"]));
  }
}
