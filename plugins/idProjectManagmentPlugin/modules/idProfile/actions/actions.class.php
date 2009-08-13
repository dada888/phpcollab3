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
    $this->forwardUnless($this->getUser()->hasCredential('idProfile-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($this->getUser()->isMyProfile($this->getUser()->getGuardUser()->getid()));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forward404();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404();
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProfile-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    $this->form = new idProfileForm($this->getUser()->getGuardUser());
    $this->form->setDefault('username', $this->getUser()->getGuardUser()->getUsername());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idProfile-Edit'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));

    $this->form = new idProfileForm($this->getUser()->getGuardUser());
    $this->form->setDefault('username', $this->getUser()->getGuardUser()->getUsername());
    
    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404();
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
//var_dump($request->getParameter($form->getName()));die();
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $profile = $form->save();
      
      $this->redirect('@index_profile');
    }
  }
}
