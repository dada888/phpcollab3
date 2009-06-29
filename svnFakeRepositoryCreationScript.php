<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * svnFakeRepositoryCreator
 *
 * @package    phpCollab3
 */

/**
 * Create an example svn repository to show on the demo the frepository functionalities
 *
 * @package    phpCollab3
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */

class fakeRepositoryCreator
{
  private $pathLocalRepository;
  private $pathLocalClientRepository;
  private $pathLocalGitRepository;
  private $repositoryUrl;

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
    $command = 'rm -rf cache/*';
    $command .= 'rm -rf test/fixtures/git;';
    $command .= 'rm -rf test/fixtures/svn;';
    $command .= 'rm -rf test/fixtures/svn_client;';
    $this->executeShellCommand($command);

  }

  public function  __construct() {
    $this->clear();
  }

  /**
   * Inizialize the variable for reading the fake svn repository
   *
   * @return repositoryTestFunctional
   */
  public function createSvnFakeRepository()
  {
    $this->pathLocalRepository = dirname(__FILE__)."/test/fixtures/svn";
    $this->pathLocalClientRepository = dirname(__FILE__)."/cache/svn_client";
    $projectName = "newProject";
    $this->repositoryUrl = 'file:///'.$this->pathLocalRepository.'/'.$projectName;

    $this->generateSvnRepositoryIfNotPresent();

    return $this;
  }

  /**
   * Inizialize the variable for reading the fake git repository
   *
   * @return repositoryTestFunctional
   */
  public function createGitFakeRepository()
  {
    $this->pathLocalGitRepository = dirname(__FILE__).'/test/fixtures/git';
    
    if (file_exists($this->pathLocalGitRepository))
    {
      return;
    }

    if (!mkdir($this->pathLocalGitRepository))
    {
      throw new Exception('Cannot create folder '.$this->pathLocalGitRepository.'');
    }

    $command = 'cd '.$this->pathLocalGitRepository.'; git-init';
    $this->executeShellCommand($command);

    $this->populateGitRepository();

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


  private function populateGitRepository()
  {
    $command = 'cd '.$this->pathLocalGitRepository.'; ';
    for($ii = 0; $ii < 10; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'git add file'.$ii.'; ';
      $command .= 'git commit -m \'touched file'.$ii.'\'; ';
    }

    $actual = 5;
    for($ii = 10; $ii < 20; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'ls > file'.$actual.'; ';
      $command .= 'git add file'.$actual.'; ';
      $command .= 'git commit -m \'modified ('.$ii.') file'.$actual.'\'; ';
    }

    for($ii = 20; $ii < 30; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'git add file'.$ii.'; ';
      $command .= 'git commit -m \'touched file'.$ii.'\'; ';
    }

    $actual = 25;
    for($ii = 30; $ii < 45; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'ls > file'.$actual.'; ';
      $command .= 'git add file'.$actual.'; ';
      $command .= 'git commit -m \'modified ('.$ii.') file'.$actual.'\'; ';
    }

    $actual = 25;
    for($ii = 130; $ii < 145; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'ls > file'.$actual.'; ';
      $command .= 'git add file'.$actual.'; ';
      $command .= 'git commit -m \'modified ('.$ii.') file'.$actual.'\'; ';
    }

    $this->executeShellCommand($command);
  }


  private function populateSvnRepository()
  {
    $command = 'cd '.$this->pathLocalClientRepository.'; ';
    for($ii = 0; $ii < 10; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'svn add file'.$ii.'; ';
      $command .= 'svn ci -m \'touched file'.$ii.'\'; ';
    }

    $actual = 5;
    for($ii = 10; $ii < 20; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'ls > file'.$actual.'; ';
      $command .= 'svn ci -m \'modified ('.$actual.') file'.$ii.'\'; ';
    }

    for($ii = 20; $ii < 30; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'svn add file'.$ii.'; ';
      $command .= 'svn ci -m \'touched file'.$ii.'\'; ';
    }

    $actual = 20;
    for($ii = 30; $ii < 35; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'ls > file'.$actual.'; ';
      $command .= 'svn ci -m \'modified ('.$actual.') file'.$ii.'\'; ';
    }

    $actual = 20;
    for($ii = 130; $ii < 135; $ii++)
    {
      $command .= 'touch file'.$ii.'; ';
      $command .= 'ls > file'.$actual.'; ';
      $command .= 'svn ci -m \'modified ('.$actual.') file'.$ii.'\'; ';
    }

    $this->executeShellCommand($command);

  }

  private function generateSvnRepositoryIfNotPresent()
  {
    if (file_exists($this->pathLocalRepository))
    {
      return;
    }

    if (!mkdir($this->pathLocalRepository))
    {
      throw new Exception('Cannot create folder '.$this->pathLocalRepository.'');
    }

    $command = 'svnadmin create --fs-type fsfs '.$this->pathLocalRepository;
    $this->executeShellCommand($command);

    $command = 'svn mkdir '.$this->repositoryUrl.' -m \'project creation\'';
    $this->executeShellCommand($command);

    $command = 'rm -rf '.$this->pathLocalClientRepository.';';
    $this->executeShellCommand($command);

    if (!mkdir($this->pathLocalClientRepository))
    {
      throw new Exception('Cannot create folder '.$this->pathLocalClientRepository.'');
    }

    $command = 'cd '.$this->pathLocalClientRepository.'; ';
    $command .= 'svn co '.$this->repositoryUrl.' .';
    $this->executeShellCommand($command);

    $this->populateSvnRepository();

  }
}

$creator = new fakeRepositoryCreator();
$creator->createSvnFakeRepository();
$creator->createGitFakeRepository();