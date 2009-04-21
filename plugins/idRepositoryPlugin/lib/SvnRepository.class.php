<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * SvnRepository
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Repository Factory
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */

class SvnRepository {
  
	private $proxy;
	private $svn_xml_reader;

  /**
   * Exceutes a command with the "exec" php function.
   * It throws an exception if the command execution generets errors
   *
   * @param string $command
   */
	private function executeShellCommand()
  {
    $result = exec($this->proxy->getCommand()." 2>&1", $output, $error);
    if($error){
      throw new Exception('Error SVN Repository : '.print_r($output));
		}
	}

  /**
   * Returns an array of logData representing the revision where a path is modified
   *
   * @param SvnLogCommand $gitLogCommandObject
   * @return array
   */
  private function getLogAllRevisionForPath(SvnLogCommand $svnLogCommand)
  {
    $svnLogCommand->addOptionXmlOutput();

    $this->proxy->setSubCommand($svnLogCommand);
    $this->proxy->setOutputToFile($this->svn_xml_reader->getFilePath());

    $this->executeShellCommand();

    return $this->svn_xml_reader->readLog($this->proxy->getFilePath());
  }

  /**
   * Add options for retriving the right log data from the repository.
   * It returns ana array of logData object.
   *
   * @param SvnLogCommand $svnLogCommand
   * @return array
   */
  private function getLog(SvnLogCommand $svnLogCommand)
  {
  	$this->proxy->addOptionNonInteractive();

  	$svnLogCommand->addOptionVerbose();
  	$svnLogCommand->addOptionXmlOutput();

  	$this->proxy->setSubCommand($svnLogCommand);
  	$this->proxy->setOutputToFile($this->svn_xml_reader->getFilePath());

    $this->executeShellCommand();

  	return $this->svn_xml_reader->readLog($this->proxy->getFilePath());
  }

  /**
   * Builds up the command to create the svn diff file.
   * Calls executeShellCommand on it.
   *
   * @param <type> $gitDiffCommand
   */
  private function createDiffFile(SvnDiffCommand $svnDiffCommand)
  {
    $this->proxy->setSubCommand($svnDiffCommand);
  	$this->proxy->setOutputToFile($this->svn_xml_reader->getFilePath());

    $this->executeShellCommand();
  }

  /**
   * Initialize the svn procy object, the svn xml reader object, the user and the password of the repository.
   *
   * @param SvnProxy $proxy
   * @param SvnXmlReader $reader
   * @param string $usr
   * @param string $pwd
   */
  public function __construct(SvnProxy $proxy, SvnXmlReader $reader,  $usr = false, $pwd = false)
  {
		
		$this->svn_xml_reader = $reader;
		$this->proxy = $proxy;
  	
		if ($usr) {
  		$this->proxy->addOptionUsername($usr);
  	}
  	
  	if ($pwd) {
  		$this->proxy->addOptionPassword($pwd);
  	}
  }

  /**
   *  Adds the limit option to the SvnLogCommand object and returns an array of logData objects.
   *
   * @param SvnLogCommand $svnLogCommand
   * @param int $limit
   * @return array
   */
  public function getLogLatestRevisions(SvnLogCommand $svnLogCommand, $limit = 10)
  {
  	$svnLogCommand->addOptionLimit($limit);
  	return $this->getLog($svnLogCommand);
  }

  /**
   * Returns an array of logData objects representing all the revision of a repository
   *
   * @param SvnLogCommand $svnLogCommandObject
   * @return array
   */
  public function getAllLogRevisions(SvnLogCommand $svnLogCommand)
  {
  	$svnLogCommand->addOptionRevision();
  	return $this->getLog($svnLogCommand);
  }

  /**
   * Returns an array of logData representing the revision where a given path is modified
   *
   * @param string $path
   * @param SvnLogCommand $svnLogCommandObject
   * @return array
   */
  public function getAllRevisionForPath($path, SvnLogCommand $svnLogCommand)
  {
    $this->proxy->setUrl($path);
    return $this->getLogAllRevisionForPath($svnLogCommand);
  }

  /**
   * Returns the matrix representing the differences between two revisions of he same file.
   *
   * @param mixed $first_revision
   * @param mixed $last_revision
   * @param DiffParser $diffParser
   * @param SvnDiffCommand $svnDiffCommand
   * @return DiffParser
   */
  public function getDiffMatrixFromRevision($first_revision, $last_revision, DiffParser $diffParser, SvnDiffCommand $svnDiffCommand)
  {
    $svnDiffCommand->setOptionRevision($first_revision, $last_revision);
    $this->createDiffFile($svnDiffCommand);
    $diffParser->parse(file($this->proxy->getFilePath()));
    return $diffParser;
  }

  /**
   * Return repository url
   *
   * @return string
   */
  public function getUrl()
  {
    return $this->proxy->getUrl();
  }

}
