<?php slot('title', __('Manage milestones')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_milestone_menu', array('project' => $project)); ?>
  <div class="content">
    <div class="inner">

    <?php include_partial('form', array('form' => $form, 'project' => $project)) ?>

    </div>
  </div>
</div>