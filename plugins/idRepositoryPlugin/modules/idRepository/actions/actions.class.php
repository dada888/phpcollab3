<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idRepositoryActions
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin Modules
 */

/**
 * Repository actions
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin Modules
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */

class idRepositoryActions extends sfActions {

  /**
   * Retrives the repository type and the repository object.
   */
  public function preExecute()
  {
    $this->type = $this->getRequest()->getPostParameter('rep', sfConfig::get('app_repository_type'));

    $repository_factory = RepositoryFactory::init();
    $this->repository = $repository_factory->build($this->type, sfConfig::get('app_repository_'.$this->type));

    $log_command_factory = LogCommandFactory::init();
    $this->log_command = $log_command_factory->build($this->type);
  }
  
 /**
  * Executes show action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idRepository-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->data = $this->repository->getLogLatestRevisions($this->log_command);
    $this->slotType = 'show_repository';
    $this->repositoryURL = $this->repository->getURL();
  }

  /**
  * Executes showall action
  *
  * @param sfRequest $request A request object
  */
  public function executeShowall(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idRepository-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->data = $this->repository->getAllLogRevisions($this->log_command);
    $this->slotType = 'show_repository_all';
    $this->repositoryURL = $this->repository->getURL();
    $this->setTemplate('show');

  }

  /**
  * Executes showdetails action
  *
  * @param sfRequest $request A request object
  */
  public function executeShowdetails(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idRepository-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->data = $this->repository->getLogLatestRevisions($this->log_command, 25);
    $this->logentry = $this->data[$request->getParameter('revisionid')];
    $this->active = $request->getParameter('action');
  }

  /**
   * Show diff between the same file in different revisions
   *
   * @param sfWebRequest $request
   */
  public function executeShowdifflist(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idRepository-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    $this->getUser()->setAttribute('path', $request->getParameter('path'));

    $this->path = $request->getParameter('path');
    $this->data = $this->repository->getAllRevisionForPath($this->repository->getUrl().urldecode($request->getParameter('path')), $this->log_command);

    $choices = array();
    foreach ($this->data as $logentry)
    {
      $choices[] = "".$logentry->getLogRevisionNumber()."";
    }
    $this->form = new ShowDiffListForm($choices, array('path' => $request->getParameter('path')));
    $this->active = $request->getParameter('action');
  }

  public function executeShowdiff(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idRepository-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    $this->path = $this->getUser()->getAttribute('path');
    
    $this->data = $this->repository->getAllRevisionForPath($this->repository->getUrl().urldecode($this->getUser()->getAttribute('path')), $this->log_command );
    $this->active = $request->getParameter('action');

    $choices = array();
    foreach ($this->data as $logentry)
    {
      $choices[] = "".$logentry->getLogRevisionNumber()."";
    }
    $this->form = new ShowDiffListForm($choices, array('path' => $request->getParameter('path')));
    
    $diff_command_factory = DiffCommandFactory::init();
    $diff_command = $diff_command_factory->build($this->type);

    $this->form->bind(array('revision_left' => $request->getParameter('revision_left'), 'revision_right' => $request->getParameter('revision_right')));

    if ($this->form->isValid()) {
      $parser = $this->repository->getDiffMatrixFromRevision($request->getParameter('revision_right'),
                                                            $request->getParameter('revision_left'),
                                                            new DiffParser(),
                                                            $diff_command
                                                           );
      $this->blocks_left = $parser->getLeftBlocks();
      $this->blocks_right = $parser->getRightBlocks();
      $this->revision_first_id = $request->getParameter('revision_right');
      $this->revision_second_id = $request->getParameter('revision_left');
      $this->setTemplate('showdiff');
    }
    else
    {
      $this->form_invalid = true;
      $this->setTemplate('showdifflist');
    }
    
  }
}
