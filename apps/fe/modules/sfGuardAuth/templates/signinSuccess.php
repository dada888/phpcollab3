<?php slot('title') ?><?php echo __('Signin') ?><?php end_slot() ?>

<form id="form-login" action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="form login">
  <?php echo $form ?>
  <input type="submit" class="button" value="<?php echo __('Login') ?>" />
</form>