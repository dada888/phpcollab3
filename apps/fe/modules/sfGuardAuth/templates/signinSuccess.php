<?php slot('title') ?><?php echo __('Signin') ?><?php end_slot() ?>

<?php if ($form->hasGlobalErrors()): ?>
  <div class="flash">
    <div class="message error">
      <?php echo $form->renderGlobalErrors() ?>
    </div>
  </div>
<?php endif;?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="form login">
  <?php echo $form ?>
  <input type="submit" class="button" value="<?php echo __('Login') ?>" />
</form>