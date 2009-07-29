<?php slot('title', __('Manage priorities')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_priority_menu'); ?>
  <div class="content">
    <h2 class="title"><?php echo !$form->getObject()->isNew() ? __('Edit priority') : __('Create new priority'); ?></h2>
    <div class="inner">

    <?php include_partial('idPriority/form', array('form' => $form)) ?>

    </div>
  </div>
</div>