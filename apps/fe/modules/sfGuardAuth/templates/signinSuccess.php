<?php slot('title') ?><?php echo __('Signin') ?><?php end_slot() ?>
<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="notice">
    <?php echo $sf_user->getFlash('notice'); ?>
  </div>
<?php endif; ?>
<form id="form-login" action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="form login">
  <?php echo $form ?>
  <input type="submit" class="button" value="<?php echo __('Login') ?>" />
</form>
<br class="clear"/>
<a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
