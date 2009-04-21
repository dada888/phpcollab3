<?php slot('title', __('Manage statuses')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_status_menu'); ?>
  <div class="content">
    <div class="inner">

    <?php include_partial('idStatus/form', array('form' => $form)) ?>

    </div>
  </div>
</div>