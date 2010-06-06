<?php
/*
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Initialize a fake git repository and the variable needed to the other classes to communicate with it.
 *
 * @package    phpCollab3
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */
class gitFakeRepositoryCreator{

  private $pathLocalRepository;

  /**
   * Executes a shell command.
   *
   * @param string $command
   */
  private function executeShellCommand($command)
  {
    $result = exec($command." 2>&1", $output, $error);
    if($error){
      echo $command."\n";
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
   * Create a fake git log file
   *
   * @param string $localRepositoryPath
   * @param string $filePath
   * @param string $prefix
   * @param string $suffix
   */
  public function createGitLogFile($localRepositoryPath, $filePath, $prefix, $suffix)
  {
    $command = "cd ".$localRepositoryPath.";";
    $command .= 'git log --pretty=format:"'.$prefix.'%h|%an|%ct|%s|%b|'.$suffix.'" --name-status';
    $command .= ' > '.$filePath;

    $this->executeShellCommand($command);
  }

  /**
   * Reads the fake git repository
   *
   * @param string $path
   * @return gitFakeRepositoryCreator
   */
  public function readFakeRepository($path)
  {
    $this->pathLocalRepository = $path;
    $this->clear();
    return $this;
  }

}
