<?php

/**
 * idMessage actions.
 *
 * @package    PHPCollab3
 * @subpackage idMessage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class idMessageActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMessage-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->forward404Unless($this->project = Doctrine::getTable('Project')->find(array($request->getParameter('project_id'))));

    $this->pager = new sfDoctrinePager('Message',10);
    $this->pager->setQuery(Doctrine::getTable('Message')->getQueryForProjectMessages($request->getParameter('project_id')));
    $this->pager->setMaxPerPage(sfConfig::get('mod_maxperpage_logtime', 10));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

/*
    $this->message_list = Doctrine::getTable('Message')
      ->createQuery('a')
      ->execute();*/
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMessage-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($this->message = Doctrine::getTable('Message')->find(array($request->getParameter('message_id'))));
    $this->forward404Unless($this->message->project_id == $request->getParameter('project_id'));

    $this->commentForm = new fdCommentForm($this->message, 'id', $request->getParameter('message_id'));
    $this->commentForm->setDefault('profile_id', $this->getUser()->getGuardUser()->getProfile()->getId());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMessage-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->form = new MessageForm();

    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMessage-Create'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new MessageForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMessage-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($message = Doctrine::getTable('Message')->find(array($request->getParameter('message_id'))), sprintf('Object message does not exist (%s).', array($request->getParameter('message_id'))));
    $this->forward404Unless($message->project_id == $request->getParameter('project_id'));
    $this->form = new MessageForm($message);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMessage-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($message = Doctrine::getTable('Message')->find(array($request->getParameter('message_id'))), sprintf('Object message does not exist (%s).', array($request->getParameter('message_id'))));
    $this->forward404Unless($message->project_id == $request->getParameter('project_id'));

    $this->form = new MessageForm($message);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idMessage-Delete'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $request->checkCSRFProtection();

    $this->forward404Unless($message = Doctrine::getTable('Message')->find(array($request->getParameter('message_id'))), sprintf('Object message does not exist (%s).', array($request->getParameter('message_id'))));
    $this->forward404Unless($message->project_id == $request->getParameter('project_id'));
    $message->delete();

    $this->dispatcher->notify(new sfEvent($this, 'message.delete',
                                                    array('user_id'=> $this->getUser()->getGuardUser()->getId(),
                                                          'message_id' => $message->id
                                                         )));

    $this->redirect('@index_messages?project_id='.$request->getParameter('project_id'));
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $is_new = $form->getObject()->isNew();
      $message = $form->save();
      $operation = 'update';

      if ($is_new)
      {
        $message->setProfileId($this->getUser()->getGuardUser()->getProfile()->getId());
        $message->setProjectId($request->getParameter('project_id'));
        $message->setCreatedAt(date('Y-m-d', time()));
        $message->save();
        $operation = 'creation';
      }

      $this->dispatcher->notify(new sfEvent($this, 'issue.'.$operation.'_success',
                                                    array('user_id'=> $this->getUser()->getGuardUser()->getId(),
                                                          'message_id' => $message->getId(),
                                                          'form_parameters' => $request->getParameter($form->getName())
                                                         )));

      $this->getUser()->setFlash('notice', 'Object '.$operation.' success');
      $this->redirect('@edit_message?project_id='.$request->getParameter('project_id').'&message_id='.$message->getId());
    }
  }
}
