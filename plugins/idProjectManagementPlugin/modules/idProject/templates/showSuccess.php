<?php slot('title', __('Project details')) ?>


<?php include_partial('idProject/sub_menu', array('project' => $project))?>
<div class="span-17 dashboard">
  <h3 class="left">Overview</h3>
  <hr />
  <h1><?php echo $project->name; ?></h1>
  <?php echo $project->description; ?>
  <hr />
  
  <?php include_partial('idDashboard/last_events', array('recent_activities' => $recent_activities ))?>
</div>
