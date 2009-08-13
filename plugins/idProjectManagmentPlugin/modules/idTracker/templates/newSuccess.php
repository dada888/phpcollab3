<?php slot('title', __('Create new tracker')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_tracker_menu'); ?>
  <div class="content">
    <h2 class="title"><?php echo !$form->getObject()->isNew() ? __('Edit tracker') : __('Create new tracker'); ?></h2>
    <div class="inner">
    
    <?php include_partial('idTracker/form', array('form' => $form)) ?>

    </div>
  </div>
</div>