<?php

/**
 * fd_comment actions.
 *
 * @package    PHPCollab3
 * @subpackage fd_comment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class fd_commentActions extends sfActions
{
  public function preExecute()
  {
    $this->redirect_to = $this->getUser()->getReferer($this->getRequest()->getReferer());
  }

  /*public function executeAjaxCommentList(sfWebRequest $request)
  {
    $this->forward404Unless($request->getParameter('model'));
    $this->forward404Unless($request->getParameter('model_field'));
    $this->forward404Unless($request->getParameter('model_field_value'));
    
    $config = sfConfig::get('sf_confing_comments_plugin_Profile', array());
    $user_enabled = $config['enabled'];

    $pager = new sfDoctrinePager('fdComment', sfConfig::get('sf_confing_comments_plugin_pager_max_per_page', 10));
    $pager->setQuery(Doctrine::getTable('fdComment')->getQueryForListByModelAndFieldAndValue($request->getParameter('model'),
                                                                                             $request->getParameter('model_field'),
                                                                                             $request->getParameter('model_field_value')));

    $pager->setPage($this->getRequestParameter('page',1));
    $pager->init();

    $url_parameter = '?model='.$request->getParameter('model').
                           '&model_field='.$request->getParameter('model_field').
                           '&model_field_value='.$request->getParameter('model_field_value');

    return $this->renderPartial('fd_comment/comments_list', array('pager' => $pager,
                                                                    'user_enabled' => $user_enabled,
                                                                    'url_parameter' => $url_parameter));
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward404();
    $this->fd_comment_list = Doctrine::getTable('fdComment')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forward404Unless($request->getParameter('model'));
    $this->forward404Unless($request->getParameter('model_field'));
    $this->forward404Unless($request->getParameter('model_field_value'));

    $object_model_class = $request->getParameter('model');

    $this->form = new fdCommentForm(new $object_model_class, $request->getParameter('model_field'), $request->getParameter('model_field_value'));
    $this->form->setDefault('user_id', $this->getUser()->getGuardUser()->getId());
    
    if ($request->isXmlHttpRequest())
    {
      return $this->renderPartial('comment_form', array('commentForm' => $this->form));
    }
  }*/

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->forward404Unless($request->getParameter('model'));
    $this->forward404Unless($request->getParameter('model_field'));
    $this->forward404Unless($request->getParameter('model_field_value'));

    $object_model_class = $request->getParameter('model');

    $this->form = new fdCommentForm(new $object_model_class, $request->getParameter('model_field'), $request->getParameter('model_field_value'));

    if ($request->isXmlHttpRequest())
    {
      return $this->processAjaxForm($request, $this->form);
    }

    $this->processForm($request, $this->form);
  }

  /*public function executeEdit(sfWebRequest $request)
  {
    $this->forward404();
    $this->forward404Unless($request->isMethod('post'));
    $this->forward404Unless($fd_comment = Doctrine::getTable('fdComment')->find(array($request->getParameter('id'))), sprintf('Object fd_comment does not exist (%s).', array($request->getParameter('id'))));

    $this->form = new fdCommentForm(new $fd_comment->model, $fd_comment->model_field, $fd_comment->model_field_value, $fd_comment);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404();
    $this->forward404Unless($request->isMethod('post'));
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($fd_comment = Doctrine::getTable('fdComment')->find(array($request->getParameter('id'))), sprintf('Object fd_comment does not exist (%s).', array($request->getParameter('id'))));

    $this->form = new fdCommentForm(new $fd_comment->model, $fd_comment->model_field, $fd_comment->model_field_value, $fd_comment);

    if ($request->isXmlHttpRequest())
    {
      return $this->processAjaxForm($request, $this->form);
    }

    $this->processForm($request, $this->form);
  }*/

  /*public function executeDelete(sfWebRequest $request)
  {
    $this->forward404();
    $request->checkCSRFProtection();

    $this->forward404Unless($fd_comment = Doctrine::getTable('fdComment')->find(array($request->getParameter('id'))), sprintf('Object fd_comment does not exist (%s).', array($request->getParameter('id'))));
    $fd_comment->delete();

    $this->redirect($this->redirect_to);
  }*/

  protected function getErrors($form)
  {
    $message = 'Errors: ';
    $message .= ($form['title']->hasError()) ? $form['title']->renderError().'. ' : '';
    $message .= ($form['body']->hasError()) ? $form['body']->renderError().'. ' : '';
    $message .= $form->hasGlobalErrors() ? $form->renderGlobalErrors().'. ' : '';

    return $message;
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $fd_comment = $form->save();
      
      $this->redirect($this->redirect_to);
    }

    $this->getUser()->setFlash('error', $this->getErrors($form));
    $this->redirect($this->redirect_to);
  }
/*
  protected function processAjaxForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $fd_comment = $form->save();

      $this->getUser()->setFlash('notice', 'Comment created succesfully.');
      $object_model_class = $request->getParameter('model');
      $new_form = new fdCommentForm(new $object_model_class, $request->getParameter('model_field'), $request->getParameter('model_field_value'));
      return $this->renderPartial('comment_form', array('commentForm' => $new_form));
    }

    return $this->renderPartial('comment_form', array('commentForm' => $form));
  }*/
}
