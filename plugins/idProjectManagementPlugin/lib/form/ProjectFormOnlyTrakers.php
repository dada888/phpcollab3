<?php

class ProjectFormOnlyTrackers extends idProjectForm
{
  public function configure()
  {
    parent::configure();
    $this->useFields(array('trackers_list', 'id'));
  }
}
