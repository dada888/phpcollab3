<form action="<?php echo url_for('idProject/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getid() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="form">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <?php if ($form->hasGlobalErrors()): ?>
    <div class="group">
      <div class="fieldWithErrors">
        <span class="error"><?php echo $form->renderGlobalErrors() ?></span>
      </div>
    </div>
  <?php endif; ?>
      <div class="group">
        <?php if ($form['name']->hasError()):?>
          <div class="fieldWithErrors">
            <span class="error"><?php echo $form['name']->renderError() ?></span>
          </div>
        <?php endif; ?>
        <?php echo $form['name']->renderLabel(__('Name'), null, array('class'=>'label')) ?><br/>
        <?php echo $form['name'] ?>
      </div>
      <div class="group">
        <?php if ($form['description']->hasError()):?>
          <div class="fieldWithErrors">
            <span class="error"><?php echo $form['description']->renderError() ?></span>
          </div>
        <?php endif; ?>
        <?php echo $form['description']->renderLabel(__('Description'), null, array('class'=>'label')) ?><br/>
        <?php echo $form['description'] ?>
      </div>
      <div class="group">
        <?php if ($form['is_public']->hasError()):?>
          <div class="fieldWithErrors">
            <span class="error"><?php echo $form['is_public']->renderError() ?></span>
          </div>
        <?php endif; ?>
        <?php echo $form['is_public']->renderLabel(__('Public'), null, array('class'=>'label')) ?>
        <?php echo $form['is_public'] ?>
      </div>
      <div class="group">
        <?php if ($form['created_at']->hasError()):?>
          <div class="fieldWithErrors">
            <span class="error"><?php echo $form['created_at']->renderError() ?></span>
          </div>
        <?php endif; ?>
        <?php echo $form['created_at']->renderLabel() ?>
        <?php echo $form['created_at'] ?>
      </div>
      <div class="group">
        <?php if ($form['end_date']->hasError()):?>
          <div class="fieldWithErrors">
            <span class="error"><?php echo $form['end_date']->renderError() ?></span>
          </div>
        <?php endif; ?>
        <?php echo $form['end_date']->renderLabel() ?>
        <?php echo $form['end_date'] ?>
      </div>

      <div class="group">
        <?php if ($form['users_list']->hasError()):?>
          <div class="fieldWithErrors">
            <span class="error"><?php echo $form['users_list']->renderError() ?></span>
          </div>
        <?php endif; ?>
        <?php echo $form['users_list']->renderLabel(__('Project users'), null, array('class'=>'label')) ?>
        <?php echo $form['users_list'] ?>
      </div>

      <div class="group">
        <?php if ($form['trackers_list']->hasError()):?>
          <div class="fieldWithErrors">
            <span class="error"><?php echo $form['trackers_list']->renderError() ?></span>
          </div>
        <?php endif; ?>
        <?php echo $form['trackers_list']->renderLabel(__('Project trackers'), null, array('class'=>'label')) ?>
        <?php echo $form['trackers_list'] ?>
      </div>

      <div class="group navform">
        <?php echo $form->renderHiddenFields() ?>
        
        <?php echo link_to(__('Go back to the projects list') ,'@index_project') ?> <input type="submit" value="<?php echo $form->getObject()->isNew() ? __('Create a new project') : __('Update the project') ?>" />
      </div>
</form>