<?php slot('title', __('Manage statuses')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_status_menu'); ?>
  <div class="content">
    <h2 class="title"><?php echo !$form->getObject()->isNew() ? __('Edit status') : __('Create new status'); ?></h2>
    <div class="inner">

    <?php include_partial('idStatus/form', array('form' => $form)) ?>

    </div>
  </div>
</div>