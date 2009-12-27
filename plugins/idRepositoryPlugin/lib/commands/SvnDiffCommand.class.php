<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * SvnDiffCommand
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Class for wrapping in PHP language the options of svn diff command
 * It implements the Command interface
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */

class SvnDiffCommand implements Command {

  private $optionList;
  private $subCommandName = "diff ";

  /**
   * Inizialize the option list as an empty string
   *
   */
  public function __construct()
  {
    $this->optionList = "";
  }

  /**
   * Wraps the "-r" option of svn diff command.
   * Takes two parameter as input and they are the first and last revision by default.
   *
   * @param mixed $first_revision identifier of a revision
   * @param mixed $second_revision ideantifier of a revision
   */
  public function setOptionRevision($first_revision = 1, $second_revision = 'HEAD')
  {
    $this->optionList .= '-r '.$first_revision.':'.$second_revision.' ';
  }

  /**
   * Returns the option list string
   *
   * @return string
   */
  public function getOptionList() {
		return $this->optionList;
	}

  /**
   * Returns the string representing the svn sub-command for diff
   *
   * @return string
   */
	public function getSubCommandName() {
		return $this->subCommandName;
	}

}
?>
