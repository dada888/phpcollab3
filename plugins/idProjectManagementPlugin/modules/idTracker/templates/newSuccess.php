<?php slot('title', __('Create new tracker')) ?>

<div class="span-23" id="content">
  <?php include_partial('idProject/sub_menu_settings')?>
  <div class="title">
    <span><?php echo __('Edit tracker'); ?></span>
  </div>

  <div class="span-full">
    <form action="<?php echo url_for('idTracker/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getid() : '')) ?>" method="post">
      <?php if ($form->hasGlobalErrors()): ?>
        <div class="error"><?php echo $form->renderGlobalErrors() ?></div>
      <?php endif; ?>
      <div class="span-10 last">
        <?php echo $form['name']->renderLabel() ?>
        <?php echo $form['name']->renderError() ?>
        <?php echo $form['name'] ?>
      </div>
      <div class="clear"></div>
      <div class="span-3">
        <input type="submit" value="<?php echo __('Save'); ?>" class="button block-green medium-round" />
        <?php echo $form->renderHiddenFields() ?>
      </div>
      <div class="span-3">
        <?php echo link_to(__('Back to list'), '@index_trackers', array('class' => 'button block-yellow medium-round')) ?>
      </div>
      <div class="span-4 last">&nbsp;
        <?php if (!$form->getObject()->isNew()): ?>
          <?php echo link_to(__('Delete'), '@delete_tracker?id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => __('Do you really want to delete this tracker?'), 'class' => 'button block-red medium-round')) ?>
        <?php endif; ?>
      </div>
      <div class="clear"></div>
    </form>
  </div>

</div>