<?php slot('title', __('Manage time')) ?>

<div id="content" class="span-23">
  <div class="span-full">
    <div class="title">
      <span>Time</span>
      <a id="add" class="button block-green medium-round" href="<?php echo url_for('@new_logtime') ?>">Add</a>
    </div>
    <div id="add-fom">
      <?php include_partial('idLogtime/form', array('form' => $form)) ?>
    </div>
  </div>
</div>