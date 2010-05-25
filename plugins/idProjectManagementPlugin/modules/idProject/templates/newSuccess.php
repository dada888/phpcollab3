<?php slot('title', __('Project Creation')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_project_menu', array('action' => 'new')); ?>
  <div class="content">
    <div class="inner">
      <?php include_partial('form', array('form' => $form)) ?>

    </div>
  </div>
</div>