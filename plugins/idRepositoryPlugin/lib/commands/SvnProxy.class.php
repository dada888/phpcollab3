<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * SvnProxy
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Class for managing the svn main options list, sub command and sub command options list
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */

class SvnProxy {

  private $command;
  private $output_file;
  private $url;
  private $subcommand;
  private $subcommand_optionlist;
  private $main_optionlist = "";

  /**
   * Initializes the command name to svn and the url of the repository
   *
   * @param string $r_url
   */
  public function __construct($r_url) {
    $this->command = "svn ";
    $this->url = $r_url;
  }

  /**
   * Sets the sub command name and the option list from the sub command object passed as input
   *
   * @param Command $object
   */
  public function setSubCommand(Command $object) {
    $this->subcommand = $object->getSubCommandName();
    $this->subcommand_optionlist = $object->getOptionList();
  }

  /**
   * Adds the "--username NAME" option to the main options list
   *
   * @param string $username
   */
  public function addOptionUsername($username) {
    $this->main_optionlist .= "--username ".$username." ";
  }

  /**
   * Adds the "--password PSW" option to the main options list
   *
   * @param string $password
   */
  public function addOptionPassword($password) {
    $this->main_optionlist .= "--password ".$password." ";
  }

  /**
   * Adds the "--no-auth-cache" option to the main options list
   */
  public function addOptionNoAuthCache() {
    $this->main_optionlist .= "--no-auth-cache ";
  }

  /**
   * Adds the "--non-interactive" option to the main options list
   */
  public function addOptionNonInteractive() {
    $this->main_optionlist .= "--non-interactive ";
  }

  /**
   * Adds the "--config-dir directory_path" option to the main options list
   *
   * @param string $directory_path
   */
  public function addOptionConfigDir($directory_path) {
    if(is_string($directory_path)){
      $this->main_optionlist .= "--config-dir ".$directory_path." ";
    }
    else {
      throw new Exception('Global option --config-dir need a string as argument : '.$directory_path);
    }
  }

  /**
   * Sets the file path where to chache the resoult from the svn command
   *
   * @param string $file_path
   */
  public function setOutputToFile($file_path) {
    $this->output_file = $file_path;
  }

  /**
   * Sets the reference url
   *
   * @param string $url
   */
  public function setUrl($url)
  {
    $this->url = $url;
  }

  /**
   * Builds the svn command as a string and returns it
   *
   * @return string
   */
  public function getCommand() {
    return $this->command.$this->main_optionlist.$this->subcommand.$this->subcommand_optionlist.$this->url.(isset($this->output_file) ? ' > '.$this->output_file.' ' : '');
  }

  /**
   * Returns the file path where the results of the command has been written
   *
   * @return string
   */
  public function getFilePath() {
    return $this->output_file;
  }

  /**
   * Returns the reference url used
   *
   * @return string
   */
  public function getUrl()
  {
    return $this->url;
  }
}