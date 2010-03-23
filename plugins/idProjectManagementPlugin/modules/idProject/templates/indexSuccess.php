<?php slot('title', __('Projects')) ?>

<div class="span-17 dashboard">
  <h3>Project Status</h3>
  <hr />
  <?php foreach($project_list as $project): ?>
    <?php include_partial('idProject/project_overview', array('project' => $project))?>
  <?php endforeach; ?>
</div>

