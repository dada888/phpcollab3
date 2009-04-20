<?php slot('title', __('Manage priorities')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_priority_menu'); ?>
  <div class="content">
    <div class="inner">

    <?php include_partial('idPriority/form', array('form' => $form)) ?>

    </div>
  </div>
</div>