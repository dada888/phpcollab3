<?php echo $form->renderHiddenFields() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="flash">
    <div class="message notice">
      <p><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></p>
    </div>
  </div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <div class="flash">
    <div class="message error">
      <p><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></p>
      <p><?php echo $form->renderGlobalErrors() ?></p>
    </div>
  </div>
<?php endif; ?>