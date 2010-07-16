<?php

class ProjectFormOnlyMembers extends idProjectForm
{
  public function configure()
  {
    parent::configure();
    $this->useFields(array('users_list', 'id'));
  }
}
