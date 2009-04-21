<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * repositoryAdapter
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Interface for repository
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */
interface repositoryAdapter{
  public function getLogLatestRevisions(Command $command, $limit = 10);
  public function getAllLogRevisions(Command $command);
}

?>
