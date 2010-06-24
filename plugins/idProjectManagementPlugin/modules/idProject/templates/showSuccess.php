<?php slot('title', $project->name) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>
  <div class="span-full dashboard">
    <h3 class="left"><?php echo __('Overview'); ?></h3>
    <?php if($sf_user->canEditProject($project->id)): ?><span class="actions"><?php echo link_to(__('Edit'), '@edit_project?id='.$project->id) ?></span><?php endif; ?>
    <hr>
    <?php echo $project->description; ?>
  </div>

  <?php if($sf_user->countMyIssuesForProject($project->id) > 0): ?>
    <div class="span-full">
      <div class="title"><span><?php echo __('My Tickets'); ?></span></div>
      <div class="menu">
        <div class="span-3">Name</div>
        <div class="span-15">Description</div>
        <div class="span-4 right last"><span>Project</span></div>
      </div>
      <?php include_partial('idDashboard/issues_list', array('issues' => $sf_user->retrieveMyIssuesForProject($project->id)))?>
    </div>
  <?php endif; ?>
</div>
