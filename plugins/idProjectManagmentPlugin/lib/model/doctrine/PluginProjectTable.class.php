<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginProjectTable.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */


/**
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    phpCollab3
 * @author Filippo (p16) De Santis <fd@ideato.it>
 * @subpackage idProjectManagmentPlugin Model
 */
class PluginProjectTable extends Doctrine_Table
{
  /**
   * Retrive a project and all the related milestones and issues given a project id
   *
   * @param int $id
   * @return Project
   */
  public function getProjectRelatedMilestonesAndIssues($id)
  {
    $q = Doctrine_Query::create()
      ->from('Project p')
      ->leftJoin('p.Milestones m')
      ->leftJoin('m.Issues i')
      ->leftJoin('i.priority pr')
      ->leftJoin('i.status s')
      ->where('p.id = ?', $id);

    return $q->fetchOne();
  }

  /**
   * Retrive a project and all its related milestones and users
   *
   * @param int $id
   * @return Project
   */
  public function getProjectMilestonesAndUsers($id)
  {
    $q = Doctrine_Query::create()
      ->from('Project p')
      ->leftJoin('p.Milestones m')
      ->leftJoin('p.users pr')
      ->leftJoin('pr.User u')
      ->where('p.id = ?', $id);

    return $q->fetchOne();
  }
}