<?php slot('title', __('Edit Logtime')) ?>

<div id="content" class="span-23">
  <?php if(isset($project)): ?>
    <?php include_partial('idProject/sub_menu', array('project' => $project))?>
  <?php endif; ?>
  <div class="span-full">
    <div class="title">
      <span>Edit logtime</span>
    </div>

    <div id="log-time-form">
      <?php include_partial('idLogtime/form', array('form' => $form, 'referer' => $referer)) ?>
    </div>
  </div>
</div>
