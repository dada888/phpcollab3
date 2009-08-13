<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * GitRepository
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * GitRepository class represent the main interface to the git repository.
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */

class GitRepository {
  private $localRepository;
  private $gitLogFileHandler;

  /**
   * Exceutes a command with the "exec" php function.
   * It throws an exception if the command execution generets errors
   *
   * @param string $command
   * @return string
   */
  private function executeShellCommand($command)
  {
    $result = exec($command." 2>&1", $output, $error);
    if($error){

      if (file_exists($this->gitLogFileHandler->getFilePath()))
      {
        $error .= " [".file_get_contents($this->gitLogFileHandler->getFilePath())."]";
      }

      throw new Exception('Shell Command Error when executing '.$command.' [error :'.$error.'][output : '.print_r($output).']');
    }
    return $output;
  }

  /**
   * Adds the needed options to the GitLogCommand object to retrive the right information.
   * Calls the executeShellCommand to execute the built command.
   *
   * @param GitLogCommand $gitLogCommandObject
   */
  private function createLogFile(GitLogCommand $gitLogCommandObject)
  {
    $gitLogFormat = new GitLogFormat();
    $gitLogFormat->setSeparator($this->gitLogFileHandler->getSeparator())
    ->setPrefix($this->gitLogFileHandler->getPrefix())
    ->setSuffix($this->gitLogFileHandler->getSuffix())
    ->addPlaceholderAbbreviatedCommitHash()
    ->addPlaceholderAuthorName()
    ->addPlaceholderCommitterDateUnixTimestamp()
    ->addPlaceholderSubject()
    ->addPlaceholderBody();
    $gitLogCommandObject->addOptionPrettyFormat($gitLogFormat);
    $gitLogCommandObject->addOptionNameStatus();

    $shellCommand = "cd ".$this->localRepository."; ".$gitLogCommandObject->getCommandToString()." > ".$this->gitLogFileHandler->getFilePath();
    
    $this->executeShellCommand($shellCommand);

    $this->gitLogFileHandler->setUsedOptionsList($gitLogFormat->getOptionsList());
  }

  /**
   * Builds up the command to create the git diff file.
   * Calls executeShellCommand on it.
   *
   * @param <type> $gitDiffCommand
   */
  private function createDiffFile(GitDiffCommand $gitDiffCommand)
  {
    $shellCommand = "cd ".$this->localRepository."; ".$gitDiffCommand->getCommandToString()." > ".$this->gitLogFileHandler->getFilePath();
    $this->executeShellCommand($shellCommand);
  }

  /**
   * Checks if the local git repository exists. if it does initializeits path and the GitLogFileHandler object
   *
   * @param string $local_repository_path
   * @param GitLogFileHandler $gitLogFileHandler
   */
  public function __construct($local_repository_path, GitLogFileHandler $gitLogFileHandler)
  {
    
    if (!$local_repository_path)
    {
      throw new Exception('GitRepository Error: local repository folder and local log file path cannot be null.');
    }
    $this->localRepository = $local_repository_path;
    $this->gitLogFileHandler = $gitLogFileHandler;
  }


  /**
   * Adds the limit option to the GitLogCommand object and returns an array of logData objects.
   *
   * @param GitLogCommand $gitLogCommandObject
   * @param int $limit
   * @return array
   */
  public function getLogLatestRevisions(GitLogCommand $gitLogCommandObject, $limit = 10)
  {
    $gitLogCommandObject->addOptionLimit($limit);
    $this->createLogFile($gitLogCommandObject);
    return $this->gitLogFileHandler->getLog();
  }

  /**
   * Returns an array of logData objects representing all the revision of a repository
   *
   * @param GitLogCommand $gitLogCommandObject
   * @return array
   */
  public function getAllLogRevisions(GitLogCommand $gitLogCommandObject)
  {
    $this->createLogFile($gitLogCommandObject);
    return $this->gitLogFileHandler->getLog();
  }

  /**
   * Returns an array of logData representing the revision where a given path is modified
   *
   * @param string $path
   * @param GitLogCommand $gitLogCommandObject
   * @return array
   */
  public function getAllRevisionForPath($path, GitLogCommand $gitLogCommandObject)
  {
    $gitLogCommandObject->addPath($path);
    $this->createLogFile($gitLogCommandObject);
    return $this->gitLogFileHandler->getLog();
  }

  /**
   * Returns the matrix representing the differences between two revisions of he same file.
   *
   * @param mixed $first_revision
   * @param mixed $last_revision
   * @param DiffParser $diffParser
   * @param GitDiffCommand $gitDiffCommand
   * @return DiffParser
   */
  public function getDiffMatrixFromRevision($first_revision, $last_revision, DiffParser $diffParser, GitDiffCommand $gitDiffCommand)
  {
    $gitDiffCommand->addRevisions($first_revision, $last_revision);
    $this->createDiffFile($gitDiffCommand);
    $diffParser->parse(file($this->gitLogFileHandler->getFilePath()));
    return $diffParser;
  }
  
  /**
   * Return local file repository
   *
   * @return string
   */
  public function getUrl()
  {
    return '';
    //return $this->localRepository;
  }
}

?>
