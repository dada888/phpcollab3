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
    <?php if ($sf_user->isAdmin()): ?>
    <li class="span-7">
      <?php echo $form['profile_id']->renderLabel(__('User')) ?>
      <?php echo $form['profile_id']->renderError() ?>
      <?php echo $form['profile_id'] ?>
    </li>
    <?php endif; ?>
    <li class="span-7">
      <?php echo $form['log_time']->renderLabel(__('Log time')) ?>
      <?php echo $form['log_time']->renderError() ?>
      <?php echo $form['log_time'] ?>
    </li>
  </ul>
  <div class="clear"></div>
  <div class="confirm-box">
    <div class="span-7 prepend-1">
      <input type="submit" value="Save" class="button block-green medium-round"/>
    </div>
    <div class="span-8">&nbsp;
      <?php echo $form->renderHiddenFields() ?>
    </div>
    <div class="span-6 right last append-1">
      <?php echo link_to('Back to list', (isset($referer) && !empty($referer)) ? $referer : '@index_logtime', array('class' => 'button block-red medium-round')); ?>
    </div>
    <div class="clear"></div>
  </div>
</form>