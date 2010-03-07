<?php
/**
 * EventListener
 *
 * @author Filippo De Santis <fd@ideato.it>
 */
class EventListener
{
  static public function extracNamespace($event)
  {
    list($name) = explode('.', $event->getName());
    return $name;
  }

  static public function extracAction($event)
  {
    list($name, $action) = explode('.', $event->getName());
    return $action;
  }

  static public function extracProjectId($event)
  {
    $parameters = $event->getParameters();
    if (!isset($parameters['project_id']))
    {
      throw new Exception('Cannot log information realated to no project. '. __CLASS__.'::'.__FUNCTION__);
    }
    return $parameters['project_id'];
  }

  static public function processParameters($event)
  {
    $parameters = $event->getParameters();

    if (is_array($parameters) && isset($parameters['log_message']))
    {
      return $parameters['log_message'];
    }

    if (is_array($parameters) && isset($parameters[0]['message_structure']) && isset($parameters[1]['message_data']))
    {
      $message = '';
      foreach ($parameters[0]['message_structure'] as $key)
      {
        $message .= $parameters[1]['message_data'][$key]." ";
      }
      return trim($message);
    }

    $namespace = self::extracNamespace($event);
    $action    = self::extracAction($event);
    return $action." on ".$namespace." performed";
  }

  static protected function store($namespace, $action, $message, $project_id)
  {
    $event_log = new EventLog();
    $event_log->setNamespace($namespace);
    $event_log->setAction($action);
    $event_log->setMessage($message);
    $event_log->setCreatedAt(date('Y-m-d H:i:s'));
    $event_log->setProjectId($project_id);

    $event_log->save();
    unset($event_log);
  }

  static public function processEvent(sfEvent $event)
  {
    $namespace = self::extracNamespace($event);
    $action = self::extracAction($event);
    $project_id = self::extracProjectId($event);

    $message = self::processParameters($event);

    self::store($namespace, $action, $message, $project_id);
  }
}
?>
