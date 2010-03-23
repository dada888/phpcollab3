<?php use_helper('Dashboard') ?>

<?php slot('title', __('Dashboard')); ?>

<div class="span-17 dashboard">
  <h3>Project Status</h3>
  <hr />
  <?php foreach($sf_user->getMyProjects() as $project): ?>
    <?php include_partial('idProject/project_overview', array('project' => $project))?>
  <?php endforeach; ?>

  <?php include_partial('idDashboard/last_events', array('recent_activities' => $recent_activities ))?>
</div>
