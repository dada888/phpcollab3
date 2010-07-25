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
  public function  preExecute()
  {
    $this->forward404Unless($this->project = Doctrine::getTable('Project')->findOneBy('id', $this->getRequest()->getParameter('project_id')));
  }

  public function executeIndex(sfWebRequest $request)
  {
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
    $this->forward404Unless($this->message = Doctrine::getTable('Message')->find(array($request->getParameter('message_id'))));
    $this->forward404Unless($this->message->project_id == $request->getParameter('project_id'));

    $this->commentForm = new fdCommentForm($this->message, 'id', $request->getParameter('message_id'));
    $this->commentForm->setDefault('profile_id', $this->getUser()->getGuardUser()->getProfile()->getId());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new MessageForm();
    
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new MessageForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($message = Doctrine::getTable('Message')->find(array($request->getParameter('message_id'))), sprintf('Object message does not exist (%s).', array($request->getParameter('message_id'))));
    $this->forward404Unless($message->project_id == $request->getParameter('project_id'));
    $this->form = new MessageForm($message);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($message = Doctrine::getTable('Message')->find(array($request->getParameter('message_id'))), sprintf('Object message does not exist (%s).', array($request->getParameter('message_id'))));
    $this->forward404Unless($message->project_id == $request->getParameter('project_id'));

    $this->form = new MessageForm($message);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($message = Doctrine::getTable('Message')->find(array($request->getParameter('message_id'))), sprintf('Object message does not exist (%s).', array($request->getParameter('message_id'))));
    $this->forward404Unless($message->project_id == $request->getParameter('project_id'));
    $message->delete();

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
        $operation = 'create';
      }

      $this->getUser()->setFlash('notice', 'Object '.$operation.'d successfully');
      $this->redirect('@edit_message?project_id='.$request->getParameter('project_id').'&message_id='.$message->getId());
    }
  }
}
