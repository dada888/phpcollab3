<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AddProjectsTrackers extends Doctrine_Migration
{
	public function up()
	{
		$this->createTable('projects_trackers', 
      array('id' => array('type' => 'integer', 'length' => 20, 'autoincrement' => true, 'primary' => true),
            'project_id' => array('type' => 'integer', 'length' => 2147483647),
            'tracker_id' => array('type' => 'integer', 'length' => 2147483647)),
      array('indexes' => array(), 'primary' => array(0 => 'id')));
	}

	public function down()
	{
		$this->dropTable('projects_trackers');
	}
}