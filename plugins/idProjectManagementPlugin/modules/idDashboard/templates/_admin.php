<?php use_helper('Dashboard') ?>

<div id="sidebar-right" class="span-6 push-1 last">
  <h3>Open Projects</h3>
  <hr />
  <?php if (count($latest_projects_reports) > 0): ?>
    <?php foreach($latest_projects_reports as $project_id => $project_report):?>
      <?php include_partial('idDashboard/project_report', array('project_id' => $project_id, 'project_report' => $project_report)) ?>
    <?php endforeach;?>
  <?php endif; ?>
  <?php echo link_to(__('See all'), '@index_project') ?>
</div>