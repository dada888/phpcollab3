<?php

class collabActions extends sfActions
{
  protected function sendEmail($object, $body, $action)
  {
    $to = array();
    foreach($object->getRelatedUsers() as $user)
    {
      $to[] = $user->email_address;
    }

    if (empty($to))
    {
      return;
    }
    
    $from = sfConfig::get('app_mail_from');
    $mail =  $this->getMailer()->compose($from,
                                         $to,
                                         get_class($object).' '.$object->title.' '.$action,
                                         $body);
    $mail->setContentType('text/html');
    $this->getMailer()->send($mail);
  }
}
