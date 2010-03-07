<?php
/**
 * Description of LogGenerator
 *
 * @author filippo
 */
class LogMessageGenerator
{
  public static $log_class = 'EventLog';

  public static function getLinkForObject($object)
  {
//TO DO: can we get the right "url" from routing? (=> without using sfContext)
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Tag'));
    $object_class = strtolower(get_class($object));

    switch ($object_class)
    {
      case 'project':
        return link_to($object->name, '@show_project?id='.$object->id);
        break;
      case 'milestone':
        return link_to($object->title, '@show_milestone?project_id='.$object->project_id.'&milestone_id='.$object->id);
        break;
      case 'issue':
        return link_to('#'.$object->id.' '.$object->title, '@show_issue?project_id='.$object->project_id.'&issue_id='.$object->id);
        break;
      case 'logtime':
        return "time (".$object->log_time." hours) for ".link_to('#'.$object->issue->id.' '.$object->issue->title, '@show_issue?project_id='.$object->issue->project_id.'&issue_id='.$object->issue->id);
        break;
      case 'message':
        return link_to($object->title, '@show_message?project_id='.$object->project_id.'&message_id='.$object->id);
        break;
      default:
        $default = (string)$object;
        return (empty($default)) ? get_class($object) : $default;
    }
  }

  public static function generate($user, $action, $object)
  {
    $suffix = 'd';
    $user_ref = is_null($user) ? 'user_name#"Mr. CLI"' : 'user_name#"'.$user->getProfile()->getShortName().'" ';
    $link_to_object = self::getLinkForObject($object);
    
    if ($action == "add")
    {
      $suffix = 'ed';
    }

    return $user_ref.ucfirst($action).$suffix.' '. ucfirst(get_class($object)) .' '.$link_to_object;
  }

  public static function storeFromDoctrineEvent($message, $action, Doctrine_Event $event)
  {
    $event_log = new self::$log_class;
    $event_log->setNamespace(strtolower(get_class($event->getInvoker())));
    $event_log->setAction($action);
    $event_log->setMessage($message);
    $event_log->setCreatedAt(date('Y-m-d H:i:s'));
    $project_id = ($event->getInvoker() instanceof Project) ? $event->getInvoker()->id : $event->getInvoker()->project_id;
    $event_log->setProjectId($project_id);

    $event_log->save();
    unset($event_log);
  }

  public static function generateMessageAndStoreFromDoctrineEvent($user, $action, Doctrine_Event $event)
  {
    $message = self::generate($user, $action, $event->getInvoker());
    self::storeFromDoctrineEvent($message, $action, $event);
  }
}
?>
