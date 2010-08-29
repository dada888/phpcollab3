<?php slot('title', __('Edit your profile')) ?>
<div class="block" id="block-forms">
  <div class="content">
    <div class="inner"><h2><?php echo __('Edit your profile') ?></h2>

      <?php include_partial('form', array('form' => $form)) ?>

      <?php //echo $form ?>

    </div>
  </div>
</div>