<?php

class idEstimatedTimeForm extends idIssueForm
{
  public function configure()
  {
    parent::configure();
    
    unset($this['status_id'],
          $this['priority_id'],
          $this['starting_date'],
          $this['ending_date'],
          $this['users_list'],
          $this['milestone_id'],
          $this['related_issue_list'],
          $this['title'],
          $this['description']
         );

  }
}