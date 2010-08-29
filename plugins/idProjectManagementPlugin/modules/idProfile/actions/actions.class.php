<?php

/**
 * idProfile actions.
 *
 * @package    PHPCollab3
 * @subpackage idProfile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class idProfileActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward404Unless($this->getUser()->isMyProfile($this->getUser()->getGuardUser()->getId()));
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->form = new collabUserForm($this->getUser()->getGuardUser());
    $this->form->setDefault('username', $this->getUser()->getGuardUser()->getUsername());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));

    $this->form = new collabUserForm($this->getUser()->getGuardUser());
    $this->form->setDefault('username', $this->getUser()->getGuardUser()->getUsername());
    
    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $form->save();
      $this->redirect('@index_profile');
    }
  }
}
