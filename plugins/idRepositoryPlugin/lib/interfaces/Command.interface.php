<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Command
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Interface for command objects (log, diff, etc.)
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */
interface Command {

public function getOptionList();
	
	public function getSubCommandName();

}

