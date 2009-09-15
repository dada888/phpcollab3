<?php slot('title', __('Edit Message')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_message_menu'); ?>
  <div class="content">
    <h2 class="title"><?php echo !$form->getObject()->isNew() ? __('Edit message') : __('Create new message'); ?></h2>
    <div class="inner">

      <?php include_partial('form', array('form' => $form)) ?>

    </div>
  </div>
</div>

