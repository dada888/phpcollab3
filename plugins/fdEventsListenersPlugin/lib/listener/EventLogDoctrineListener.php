<?php
/**
 * Description of EventLogDoctrineListener
 *
 * @author filippo
 */
class EventLogDoctrineListener extends Doctrine_Record_Listener
{

  protected function canLogEvent()
  {
    try
    {
      $user = sfContext::getInstance()->getUser();
    }
    catch(Exception $e)
    {
      return false;
    }
    
    return true;
  }

  protected function getUser()
  {
    $user = null;
    try
    {
      $user = sfContext::getInstance()->getUser();
    }
    catch(Exception $e)
    {
    }

    return $user;
  }

  public function postDelete(Doctrine_Event $event)
  {
    if ($this->canLogEvent())
    {
      LogMessageGenerator::generateMessageAndStoreFromDoctrineEvent($this->getUser(), 'delete', $event);
    }
  }

  public function postUpdate(Doctrine_Event $event)
  {
    if ($this->canLogEvent())
    {
      LogMessageGenerator::generateMessageAndStoreFromDoctrineEvent($this->getUser(), 'update', $event);
    }
  }

  public function postInsert(Doctrine_Event $event)
  {
    if ($this->canLogEvent())
    {
      LogMessageGenerator::generateMessageAndStoreFromDoctrineEvent($this->getUser(), 'create', $event);
    }
  }
}
?>
