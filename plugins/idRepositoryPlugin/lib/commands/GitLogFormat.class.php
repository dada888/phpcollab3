<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * GitLogFormat
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Class that provides a way to specify which format has to have the log report of a git-log call
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */

class GitLogFormat {

  private $options = array();
  private $separator;
  private $prefix;
  private $suffix;

  /**
   * empty
   */
  public function __construct()
  {
  }

  /**
   * Sets a separetor for the different data that we want to restrive with the git-log command
   *
   * @param string $separator
   * @return GitLogFormat
   */
  public function setSeparator($separator)
  {
    $this->separator = $separator;
    return $this;
  }

  /**
   * Sets a prefix that will separate the different log entries.
   * This prefix will tell us where a new log entry starts.
   *
   * @param string $prefix
   * @return GitLogFormat
   */
  public function setPrefix($prefix)
  {
    $this->prefix = $prefix;
    return $this;
  }

  /**
   * Returns the prefix if it is set, otherwise returns null
   *
   * @return string or null
   */
  public function getPrefix()
  {
    return $this->prefix;
  }

  /**
   * Sets a suffix that will separate the data of the log entry from the modified file list
   *
   * @param string $suffix
   * @return GitLogFormat
   */
  public function setSuffix($suffix)
  {
    $this->suffix = $suffix;
    return $this;
  }

  /**
   * Returns the suffix if it is set, otherwise null.
   *
   * @return string or null
   */
  public function getSuffix()
  {
    return $this->suffix;
  }

  /**
   * Returns the separator if it is set, otherwise null
   *
   * @return string or null
   */
  public function getSeparator()
  {
    return $this->separator;
  }

  /**
   * Returns the array rappresenting the set options.
   *
   * @return array
   */
  public function getAddedOptionsAsArray()
  {
    return $this->options;
  }

  /**
   * Returns the option list as a string.
   * the returned string will contain the set options separated by the set separator.
   *
   * @return <type>
   */
  public function getOptionsList()
  {
    $format = "";
    foreach ($this->options as $option)
    {
      $format .= $option.$this->separator;
    }
    return $format;
  }

  /**
   * returns the complete string for '--pretty=format:' option fo git-log command
   *
   * @return string
   */
  public function getLogFormat()
  {
    return "\"".$this->prefix.$this->getOptionsList().$this->suffix."\"";
  }

  /**
   * Adds '%H'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderCommitHash()
  {
    $this->options[] = "%H";
    return $this;
  }

  /**
   * Adds '%h'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderAbbreviatedCommitHash()
  {
    $this->options[] = "%h";
    return $this;
  }

  /**
   * Adds '%T'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderTreeHash()
  {
    $this->options[] = "%T";
    return $this;
  }

  /**
   * Adds '%t'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderAbbreviatedTreeHash()
  {
    $this->options[] = "%t";
    return $this;
  }

  /**
   * Adds '%P'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderParentHash()
  {
    $this->options[] = "%P";
    return $this;
  }

  /**
   * Adds '%p'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderAbbreviatedParentHash()
  {
    $this->options[] = "%p";
    return $this;
  }

  /**
   * Adds '%an'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderAuthorName()
  {
    $this->options[] = "%an";
    return $this;
  }

  /**
   * Adds '%ae'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderAuthorEmail()
  {
    $this->options[] = "%ae";
    return $this;
  }

  /**
   * Adds '%at'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderAuthorDateUnixTimestamp()
  {
    $this->options[] = "%at";
    return $this;
  }

  /**
   * Adds '%cn'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderCommitterName()
  {
    $this->options[] = "%cn";
    return $this;
  }

  /**
   * Adds '%ce'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderCommitterEmail()
  {
    $this->options[] = "%ce";
    return $this;
  }

  /**
   * Adds '%ct'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderCommitterDateUnixTimestamp()
  {
    $this->options[] = "%ct";
    return $this;
  }

  /**
   * Adds '%e'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderEncoding()
  {
    $this->options[] = "%e";
    return $this;
  }

  /**
   * Adds '%s'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderSubject()
  {
    $this->options[] = "%s";
    return $this;
  }

  /**
   * Adds '%b'
   *
   * @return GitLogFormat
   */
  public function addPlaceholderBody()
  {
    $this->options[] = "%b";
    return $this;
  }
}