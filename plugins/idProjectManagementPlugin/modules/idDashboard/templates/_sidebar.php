<?php use_helper('Dashboard') ?>

<div class="span-8 prepend-1 last" id="sidebar">
  <?php if (count($latest_projects_reports) > 0): ?>
  <div class="title"><span>Projects</span></div>
    <?php foreach($latest_projects_reports as $project_id => $project_report):?>
      <?php include_partial('idDashboard/project_report', array('project_id' => $project_id, 'project_report' => $project_report)) ?>
    <?php endforeach;?>
  <?php endif; ?>
  <?php echo link_to(__('See all'), '@index_project') ?>

  <div class="title"><span>Milestones</span></div>
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $late_milestones, 'color' => 'red', 'label' => 'Late', 'days_message' => '%d days'))?>
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $upcoming_milestones, 'color' => 'green', 'label' => 'Upcoming', 'days_message' => '%d days'))?>
  
</div>