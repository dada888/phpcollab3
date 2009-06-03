<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * repositoryTestFunctional
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Extends the functionality of the sfTestFunctional class to add methods for reading fake repoository and returns their data (paths, name, etc.)
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */

class repositoryTestFunctional extends sfTestFunctional
{
  static $repository_created = false;
  
  private $pathLocalRepository;
  private $pathLocalClientRepository;
  private $pathLocalGitRepository;
  private $setRepository = array('svn' => false, 'git' => false);

  /**
   * Execute a command from shell
   *
   * @param string $command 
   */
  private function executeShellCommand($command)
  {
    $result = exec($command." 2>&1", $output, $error);
    if($error){
      throw new Exception('[test functional] Shell Command Error : '.$output);
    }
  }

  /**
   * Clear the chache of the symfony project
   */
  private function clear()
  {
    $command = 'rm -rf '.sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'*';
    $this->executeShellCommand($command);
  }

  /**
   * Inizialize the variable for reading the fake svn repository
   *
   * @return repositoryTestFunctional
   */
  public function readSvnFakeRepository()
  {
    $this->setRepository = array('svn' => true, 'git' => false);
    $this->info('Reading fake SVN Repository');
    $this->clear();
    
    $this->pathLocalRepository = sfConfig::get('sf_test_dir')."/fixtures/svn";
    $this->pathLocalClientRepository = sfConfig::get('sf_cache_dir')."/svn_client";
    $projectName = "newProject";

    return $this;
  }

  /**
   * Inizialize the variable for reading the fake git repository
   *
   * @return repositoryTestFunctional
   */
  public function readGitFakeRepository()
  {
    $this->pathLocalGitRepository = sfConfig::get('sf_test_dir').'/fixtures/git';
    $this->setRepository = array('svn' => false, 'git' => true);
    $this->info('Reading fake Git Repository in '.$this->pathLocalGitRepository);
    $this->clear();

    return $this;
  }

  /**
   * Creates a log file where are stored the log from the fake git repository
   *
   * @param string $localRepositoryPath
   * @param string $filePath
   * @param string $prefix
   * @param string $suffix
   */
  public function createGitLogFile($localRepositoryPath, $filePath, $prefix, $suffix)
  {
    $command = "cd ".$localRepositoryPath.";";
    $command .= 'git log --pretty=format:"'.$prefix.':%h|%an|%ct|%s|%b|'.$suffix.'" --name-status';
    $command .= ' > '.$filePath;

    $this->executeShellCommand($command);
  }
}