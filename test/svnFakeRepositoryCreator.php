<?php
/*
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Initialize a fake svn repository and the variable needed to the other classes to communicate with it.
 *
 * @package    phpCollab3
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */
class svnFakeRepositoryCreator{
  private $pathLocalRepository;
  private $pathLocalClientRepository;
  private $limeObject;
  private $repositoryUrl;

  /**
   * Executes a shell command.
   *
   * @param string $command
   */
  private function executeShellCommand($command)
  {
    $result = exec($command." 2>&1", $output, $error);
    if($error){
      throw new Exception('[test unit] Shell Command Error : '.$output);
    }
  }

  /**
   * Clears the cache of the symfony project.
   *
   */
  private function clear()
  {
    $command = 'rm -rf '.sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'*';
    $this->executeShellCommand($command);
  }

  /**
   * Reads the fake svn repository
   *
   * @param lime_test $limeObject
   * @param string $localRepositoryServerPath
   * @param string $localRepositoryClientPath
   * @param string $newProjectName
   * @return svnFakeRepositoryCreator
   */
  public function readFakeRepository($limeObject, $localRepositoryServerPath, $localRepositoryClientPath, $newProjectName)
  {
    $this->limeObject = $limeObject;
    $this->limeObject->diag('Reading fake SVN Repository');
    $this->clear();

    $this->pathLocalRepository = $localRepositoryServerPath;
    $this->pathLocalClientRepository = $localRepositoryClientPath;
    $this->repositoryUrl = 'file:///'.$this->pathLocalRepository.'/'.$newProjectName;

    return $this;
  }

  /**
   * Creates a fake svn log file
   *
   * @param string $path
   */
  public function createLogFile($path)
  {
    $this->limeObject->diag('Creating file '.$path);
    $command = 'svn --non-interactive log --xml --verbose --limit 1 '.$this->repositoryUrl.' > '.$path;
    $this->executeShellCommand($command);
  }
}