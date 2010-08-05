<?php slot('title', __('Edit project')) ?>

<div class="span-23" id="content">
  <div class="span-full">
    <div class="title">
      <span>Edit project</span>
    </div>

    <form id="new" action="<?php echo url_for('idProject/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getid() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="form">
      <?php if ($form->hasGlobalErrors()): ?>
        <div class="error">
          <?php echo $form->renderGlobalErrors() ?>
        </div>
      <?php endif; ?>

      <div class="span-22 last">
        <?php echo $form['name']->renderError() ?>
        <?php echo $form['name']->renderLabel() ?><br/>
        <?php echo $form['name'] ?>
      </div>
      <div class="span-22 last">
        <?php echo $form['description']->renderError() ?>
        <?php echo $form['description']->renderLabel() ?><br/>
        <?php echo $form['description'] ?>
      </div>
      <div class="clear"></div>

      <div class="span-21 last menu prepend-1">Specifications</div>
      <div class="span-11 date">
        <?php echo $form['starting_date']->renderError() ?>
        <?php echo $form['starting_date']->renderLabel() ?><br/>
        <?php echo $form['starting_date'] ?>
      </div>
      <div class="span-11 last date">
        <?php echo $form['end_date']->renderError() ?>
        <?php echo $form['end_date']->renderLabel() ?><br/>
        <?php echo $form['end_date'] ?>
      </div>
      <div class="clear"></div>
      <div class="span-11">
        <?php echo $form['trackers_list']->renderError() ?>
        <?php echo $form['trackers_list']->renderLabel() ?><br/>
        <?php echo $form['trackers_list'] ?>
      </div>
      <div class="span-11 last">
        <?php echo $form['budget']->renderError() ?>
        <?php echo $form['budget']->renderLabel() ?><br/>
        <?php echo $form['budget'] ?>
      </div>
      <div class="clear"></div>

      <div class="span-21 last menu prepend-1">Users</div>
      <div class="span-22 last">
        <?php echo $form['users_list']->renderError() ?>
        <?php echo $form['users_list']->renderLabel() ?><br/>
        <?php echo $form['users_list'] ?>
      </div>
      <div class="clear"></div>

      <div class="span-3">
        <input class="button block-green medium-round" type="submit" value="<?php echo $form->getObject()->isNew() ? __('Create a new project') : __('Update the project') ?>" />
      </div>
      <div class="span-16">&nbsp;
        <?php if (!$form->getObject()->isNew()): ?>
          <?php echo link_to(__('Delete'), '@delete_project?id='.$project->id, array('method' => 'delete', 'confirm' => __('Do you really want to delete this project?'))) ?>
        <?php endif; ?>
        <?php echo $form->renderHiddenFields() ?>
      </div>
      <div class="span-3 last">
        <a href="<?php echo url_for('@index_project') ?>" class="button block-red medium-round"><?php echo __('Back to list'); ?></a>
      </div>
      <div class="clear"></div>
    </form>
  </div>
</div>