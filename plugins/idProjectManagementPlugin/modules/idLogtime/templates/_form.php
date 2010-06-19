<form class="new-log-time" action="<?php echo url_for('idLogtime/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  <?php if ($form->hasGlobalErrors()): ?>
  <div class="error clear"><?php echo $form->renderGlobalErrors() ?></div>
  <?php endif; ?>

  <ul class="span-full add-time">
    <li class="span-7 prepend-1">
      <?php echo $form['issue_id']->renderLabel(__('Issue')) ?>
      <?php echo $form['issue_id']->renderError() ?>
      <?php echo $form['issue_id'] ?>
    </li>
    <li class="span-7">
      <?php echo $form['profile_id']->renderLabel(__('User')) ?>
      <?php echo $form['profile_id']->renderError() ?>
      <?php echo $form['profile_id'] ?>
    </li>
    <li class="span-7">
      <?php echo $form['log_time']->renderLabel(__('Log time')) ?>
      <?php echo $form['log_time']->renderError() ?>
      <?php echo $form['log_time'] ?>
    </li>
  </ul>
  <div class="clear"></div>
  <div class="span-7 prepend-1 confirm-box">
    <?php if (!$form->getObject()->isNew()): ?>
      &nbsp;<?php echo link_to('Delete', 'idLogtime/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
    <?php endif; ?>
    <?php echo link_to('Cancel', '@index_logtime'); ?>
    <input type="submit" value="Save" />
  </div>
  <?php echo $form->renderHiddenFields() ?>
</form>