<?php slot('title', __('Projects')) ?>

<div class="span-23" id="content">
  <div class="span-full">
    <div class="title">
      <span>Projects</span>
      <?php if ($sf_user->isAdmin()): ?>
        <a class="button block-green medium-round" href="<?php echo url_for('@new_project') ?>">Add</a>
      <?php endif; ?>
    </div>
    <div id="project" class="span-full">
    <?php foreach($project_list as $key => $project): ?>
      <?php $class_line = ($key%2 == 0) ? 'odd' : 'even'; ?>
      <?php include_partial('idProject/project_overview', array('project' => $project, 'class_line' => $class_line)) ?>
    <?php endforeach; ?>
    </div>
  </div>
</div>