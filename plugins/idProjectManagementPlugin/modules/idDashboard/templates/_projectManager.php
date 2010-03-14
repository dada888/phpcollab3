<?php use_helper('Dashboard') ?>
<div id="sidebar-right" class="span-6 push-1 last">
  <h3>Milestones</h3>
  <hr />
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $late_milestones, 'color' => 'red', 'label' => 'Late', 'days_message' => '%d days late'))?>
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $upcoming_milestones, 'color' => 'green', 'label' => 'Upcoming', 'days_message' => 'Starts in %d days'))?>
</div>