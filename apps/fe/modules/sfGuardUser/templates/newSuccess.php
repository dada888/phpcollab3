<?php slot('title', __('Edit user')) ?>

<div class="span-23" id="content">
  <?php include_partial('idProject/sub_menu_settings')?>

  <div class="span-full">
    <div class="title"><?php echo __('New user') ?></div>
    <?php echo form_tag_for($form, '@sf_guard_user', array('class' =>'form')) ?>
      <?php if ($sf_user->hasFlash('notice')): ?>
        <div class="notice">
          <?php echo __($sf_user->getFlash('notice')) ?></p>
        </div>
      <?php endif; ?>
      <?php if ($sf_user->hasFlash('error')): ?>
        <div class="message error">
          <?php echo __($sf_user->getFlash('error')) ?>
        </div>
      <?php endif; ?>
      <?php if ($form->hasGlobalErrors()): ?>
        <div class="message error">
          <?php echo $form->renderGlobalErrors() ?>
        </div>
      <?php endif; ?>

      <div class="span-10">
        <?php echo $form['first_name']->renderLabel() ?>
        <?php echo $form['first_name']->renderError() ?>
        <?php echo $form['first_name']->render() ?>
      </div>
      <div class="span-3">
        &nbsp;
      </div>
      <div class="span-10 last">
        <?php echo $form['password']->renderLabel() ?>
        <?php echo $form['password']->renderError() ?>
        <br/><?php echo $form['password']->render() ?>
      </div>
      <div class="clear"></div>
      <div class="span-10">
        <?php echo $form['last_name']->renderLabel() ?>
        <?php echo $form['last_name']->renderError() ?>
        <?php echo $form['last_name']->render() ?>
      </div>
      <div class="span-3">
        &nbsp;
      </div>
      <div class="span-10 last">
        <?php echo $form['password_again']->renderLabel() ?>
        <?php echo $form['password_again']->renderError() ?>
        <br/><?php echo $form['password_again']->render() ?>
      </div>
      <div class="clear"></div>
      <div class="span-10">
        <?php echo $form['username']->renderLabel() ?>
        <?php echo $form['username']->renderError() ?>
        <?php echo $form['username']->render() ?>
      </div>
      <div class="span-3">
        &nbsp;
      </div>
      <div class="span-10 last">
        <?php echo $form['email_address']->renderLabel() ?>
        <?php echo $form['email_address']->renderError() ?>
        <?php echo $form['email_address']->render() ?>
      </div>
      <div class="clear"></div>
      <div class="span-10">
        <?php echo $form['is_active']->render() ?>
        <?php echo $form['is_active']->renderLabel() ?>
        <?php echo $form['is_active']->renderError() ?>
      </div>
      <div class="span-3">
        &nbsp;
      </div>
      <div class="span-10">
        &nbsp;
      </div>
      <div class="clear"></div>
      <div class="span-10">
        <?php echo $form['is_super_admin']->render() ?>
        <?php echo $form['is_super_admin']->renderLabel() ?>
        <?php echo $form['is_super_admin']->renderError() ?>
      </div>
      <div class="span-3">
        &nbsp;
      </div>
      <div class="span-10">
        &nbsp;
      </div>
      <div class="clear"></div>
      <div class="span-7">
        <input type="submit" class="button" value="Save"/>
        <?php echo link_to(__('Cancel'), 'sf_guard_user'); ?>
      </div>
      <?php echo $form->renderHiddenFields() ?>
    </form>
  </div>
</div>