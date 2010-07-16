<?php

class ProjectFormOnlyTitleAndDescription extends idProjectForm
{
  public function configure()
  {
    parent::configure();
    $this->useFields(array('name', 'description', 'id'));
  }
}
