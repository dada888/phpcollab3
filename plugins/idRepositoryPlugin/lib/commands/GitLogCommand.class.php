<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * GitLogCommand
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Class for wrap in PHP language the options of git-log command
 * It implements the Command interface
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class GitLogCommand implements Command{

  private $option_list;
	private $subCommandName = "git log ";
  private $path = "";

  /**
   * Sets the private variable option_list to an empty string
   */
  public function __construct()
  {
		$this->option_list = "";
	}

  /**
   * @see inbterfaces/CommandObject.interface.php
   *
   */
	public function getOptionList()
  {
		return $this->option_list;
	}

  /**
   * @see inbterfaces/CommandObject.interface.php
   *
   */
	public function getSubCommandName()
  {
		return $this->subCommandName;
	}

  /**
   * Adds '--name-only' at the and of option_list
   * 
   */
  public function addOptionNameOnly()
  {
    $this->option_list .= "--name-only ";
  }

  /**
   * Adds '--name-status ' at the and of option_list
   *
   */
  public function addOptionNameStatus()
  {
    $this->option_list .= "--name-status ";
  }

  /**
   * Adds '-n <limit> ' at the and of option_list
   *
   * @param mixed $limit can be an integer or a string that is accepted from a git log command after '-n'
   */
  public function addOptionLimit($limit)
  {
    $this->option_list .= "-n ".$limit." ";
  }

  /**
   * Adds '--max-count=<number> ' at the and of option_list
   *
   * @param int $number
   */
  public function addOptionMaxCounter($number)
  {
    $this->option_list .= "--max-count=".$number." ";
  }

  /**
   * Adds '--skip=<number> ' at the and of option_list
   *
   * @param int $number
   */
  public function addOptionSkip($number)
  {
    $this->option_list .= "--skip=".$number." ";
  }

  /**
   * Adds '--since=<date> ' at the and of option_list
   *
   * @param string $date
   */
  public function addOptionSince($date)
  {
    $this->option_list .= "--since=".$date." ";
  }

  /**
   * Adds '--until=<date> ' at the and of option_list
   *
   * @param string $date
   */
  public function addOptionUntil($date)
  {
    $this->option_list .= "--until=".$date." ";
  }

  /**
   * Adds '--author=<regexp> ' at the and of option_list
   *
   * @param string $regexp
   */
  public function addOptionAuthor($regexp)
  {
    $this->option_list .= "--author=".$regexp." ";
  }

  /**
   * Adds '--committer=<regexp> ' at the and of option_list
   *
   * @param string $regexp
   */
  public function addOptionCommitter($regexp)
  {
    $this->option_list .= "--committer=".$regexp." ";
  }

   /**
   * Adds '--grep=<regexp> ' at the and of option_list
   *
   * @param string $regexp
   */
  public function addOptionGrep($regexp)
  {
    $this->option_list .= "--grep=".$regexp." ";
  }

  /**
   * Adds '--all-match ' at the and of option_list
   */
  public function addOptionAllMatch()
  {
    $this->option_list .= "--all-match ";
  }

  /**
   * Adds '--fixed-strings ' at the and of option_list
   */
  public function addOptionFixedStrings()
  {
    $this->option_list .= "--fixed-strings ";
  }

  /**
   * Adds '--all ' at the and of option_list
   */
  public function addOptionAll()
  {
    $this->option_list .= "--all ";
  }

  /**
   * Adds '--branches ' at the and of option_list
   */
  public function addOptionBranches()
  {
    $this->option_list .= "--branches ";
  }

  /**
   * Adds '--remotes ' at the and of option_list
   */
  public function addOptionRemotes()
  {
    $this->option_list .= "--remotes ";
  }

  /**
   * Adds the option '--pretty=farmat:<format_expression> ' at he end of option_list.
   * <format_expression> is set using an instance of GitLogFormat class.
   *
   * @param GitLogFormat $gitLogFormat
   */
  public function addOptionPrettyFormat(GitLogFormat $gitLogFormat)
  {
    $this->option_list .= "--pretty=format:".$gitLogFormat->getLogFormat()." ";
  }

  /**
   * Creates the log command options list unifying the log subcommand string and the option_list string.
   *
   * @return string
   */
  public function getCommandToString()
  {
    return $this->subCommandName.$this->option_list.$this->path;
  }

  /**
   * Adds the input parameter 'path' at the end of the option list.
   * The path parameter will be at the and of the option list even if you add placeholders after it
   *
   * @param string $path
   */
  public function addPath($path)
  {
    $this->path = "$path ";
  }
}