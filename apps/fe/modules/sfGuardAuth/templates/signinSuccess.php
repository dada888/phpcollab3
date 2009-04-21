
<div id="box">
  <div class="block" id="block-login">
    <h2><?php echo __('Signin') ?></h2>
    <div class="content login">

    <?php if ($form->hasGlobalErrors()): ?>
      <div class="flash">
        <div class="message error">
          <p><?php echo $form->getGlobalErrors() ?></p>
        </div>
      </div>
    <?php endif;?>

      <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="form login">

        <div class="group">
          <?php if ($form['username']->hasError()): ?>
            <div class="flash">
              <div class="message error">
                <p><?php echo $form['username']->getError() ?></p>
              </div>
            </div>
          <?php endif;?>
          <div class="left">
            <label class="label right"><?php echo __('Username') ?></label>
          </div>
          <div class="right">
            <?php echo $form['username']->render(array('class' => 'text_field')) ?>
          </div>
          <div class="clear"></div>
        </div>

        <div class="group">
          <?php if ($form['password']->hasError()): ?>
            <div class="flash">
              <div class="message error">
                <p><?php echo $form['password']->getError() ?></p>
              </div>
            </div>
          <?php endif;?>
          <div class="left">
            <label class="label right"><?php echo __('Password') ?></label>
          </div>
          <div class="right">
            <?php echo $form['password']->render(array('class' => 'text_field')) ?>
          </div>
          <div class="clear"></div>
        </div>

        <div class="group">
          <?php if ($form['remember']->hasError()): ?>
            <div class="flash">
              <div class="message error">
                <p><?php echo $form['remember']->getError() ?></p>
              </div>
            </div>
          <?php endif;?>
          <div class="left">
            <label class="label right"><?php echo __('Remember Me') ?></label>
          </div>
          <div class="right">
            <?php echo $form['remember']->render(array('class' => 'checkbox')) ?>
          </div>
          <div class="clear"></div>
        </div>

        <div class="group navform">
          <div class="left">
            <a href="<?php echo url_for('@sf_guard_password') ?>"><?php echo __('Forgot your password?') ?></a>
          </div>
          <div class="right">
            <input type="submit" class="button" value="<?php echo __('Login') ?>" />
          </div>
          <div class="clear"></div>
        </div>

      </form>
    </div>
  </div>
</div>