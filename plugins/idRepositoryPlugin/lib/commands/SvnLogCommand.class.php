<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * SvnLogCommand
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Class for wrapping in PHP language the options of svn log command
 * It implements the Command interface
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */

class SvnLogCommand implements Command {
	
	private $option_list;
	private $subCommandName = "log ";

  /**
   * Initializes the option list to an empty string
   */
	public function __construct() {
		$this->option_list = "";
	}

  /**
   * Returns the string representing the options list
   *
   * @return string
   */
	public function getOptionList() {
		return $this->option_list;
	}

  /**
   * Returns the svn subcommand for retriving logs
   *
   * @return <type>
   */
	public function getSubCommandName() {
		return $this->subCommandName;
	}

	/**
   * Adds to the options list the "-revision N:M" option.
   *
   * @param mixed $start
   * @param mixed $end
   */
	public function addOptionRevision($start = 'HEAD', $end = 1) {
		if(
		(is_numeric($end) && is_numeric($start) && $end > $start) ||
		(is_numeric($start) && $end == 'HEAD')
		){
			throw new Exception('Invalid option --revision arguments.');
		}
		
		$this->option_list .= "--revision ".$start.":".$end." ";
	}

  /**
   * Adds the "--quiet" option to the options list
   */
	public function addOptionQuiet() {
		$this->option_list .= "--quiet ";
	}

  /**
   * Adds the "--verbose" option to the options list
   */
	public function addOptionVerbose() {
		$this->option_list .= "--verbose ";
	}
	
	/**
	 * TODO : addOptionInformationMergeHistory
	 */

  /**
   *  Adds the "--change N" option to the options list
   *
   * @param number $numeric_argument
   */
	public function addOptionChange($numeric_argument) {
		if (is_numeric($numeric_argument)) {
			$this->option_list .= "--change ".$numeric_argument." ";
		}
		else {
			throw new Exception('Option --change need a numeric argument : '.$numeric_argument);
		}
	}

  /**
   * Adds the "--stop-on-copy" option to the options list
   */
	public function addOptionStopOnCopy() {
		$this->option_list .= "--stop-on-copy ";
	}

  /**
   * Adds the "--incremental" option to the options list
   */
	public function addOptionIncremental() {
		$this->option_list .= "--incremental ";
	}

  /**
   * Adds the "--xml" option to the options list
   */
	public function addOptionXmlOutput() {
		$this->option_list .= "--xml ";
	}

  /**
   * Adds the "--limit N" option to the options list
   *
   * @param number $numeric_argument
   */
	public function addOptionLimit($numeric_argument) {
		$this->option_list .= "--limit ".$numeric_argument." ";
	}

  /**
   * Adds the "--with-all-revprops" option to the options list
   */
	public function addOptionAllRevisionProperties() {
		$this->option_list .= "--with-all-revprops ";
	}

  
	/**
	 * TO DO : addOptionRetriveRevisionProperties with ARG
	 */
}