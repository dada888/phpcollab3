<?php use_helper('Dashboard') ?>

<div class="span-8 prepend-1 last" id="sidebar">
  <div class="title"><span>Projects</span></div>
  <?php include_partial('idDashboard/project_report', array('project_id' => $project->id, 'project_report' => $project_report)) ?>
  
  <div class="title"><span>Milestones</span></div>
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $project->Milestones, 'color' => '', 'label' => '', 'days_message' => '%d days'))?>
</div>
