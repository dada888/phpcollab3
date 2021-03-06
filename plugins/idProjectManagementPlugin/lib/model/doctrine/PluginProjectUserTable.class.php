<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginProjectUserTable.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */


/**
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */
class PluginProjectUserTable extends Doctrine_Table
{
  public function getRoleByUserIdAndProjectId($user_id, $project_id)
  {
    $result = $this->createQuery()
                    ->where('project_id = '. $project_id)
                    ->addWhere('user_id = '. $user_id)
                    ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

    if (is_array($result))
    {
      return $result['role'];
    }
  }

}