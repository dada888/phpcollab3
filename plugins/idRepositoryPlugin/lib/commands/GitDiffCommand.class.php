<?php
/*
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * GitDiffCommand
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Class for wrap in PHP language the options of git-diff command
 * It implements the Command interface
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class GitDiffCommand implements Command{

  private $option_list;
	private $subCommandName = "git diff ";
  private $path = "";

  /**
   * Construct sets the private variable option_list to an empty string
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

  public function addRevisions($first_revision_id, $second_revision_id)
  {
    $this->option_list .= $first_revision_id." ".$second_revision_id." ";
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
   * Add the input parameter 'path' at the end of the option list.
   * The path parameter will be at the and of the option list even if you add placeholders after it
   *
   * @param string $path
   */
  public function addPath($path)
  {
    $this->path = "$path ";
  }
}