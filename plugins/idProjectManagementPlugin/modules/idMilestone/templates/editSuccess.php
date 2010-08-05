<?php slot('title', __('Manage milestone')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>

  <div class="span-full">
    <div class="title">
      <span><?php echo __($form->getObject()->isNew() ? 'New milestone' : 'Edit milestone'); ?></span>
    </div>
    <form id="new" action="<?php echo url_for(($form->getObject()->isNew() ? '@create_milestone' : '@update_milestone').(!$form->getObject()->isNew() ? '?milestone_id='.$form->getObject()->getid().'&project_id='.$project->getId() : '?project_id='.$project->getId())) ?>" method="post" >

    <?php if ($form->hasGlobalErrors()): ?>
      <div class="error">
        <?php echo $form->renderGlobalErrors() ?>
      </div>
    <?php endif; ?>

      <div class="span-22 last">
        <?php echo $form['title']->renderError() ?>
        <?php echo $form['title']->renderLabel() ?><br/>
        <?php echo $form['title'] ?>
      </div>
      <div class="span-22 last">
        <?php echo $form['description']->renderError() ?>
        <?php echo $form['description']->renderLabel() ?><br/>
        <?php echo $form['description'] ?>
      </div>
      <div class="clear"></div>

      <div class="span-21 last menu prepend-1">Time</div>
      <div class="span-7 date">
        <?php echo $form['starting_date']->renderError() ?>
        <?php echo $form['starting_date']->renderLabel() ?><br/>
        <?php echo $form['starting_date'] ?>
      </div>
      <div class="span-8 date">
        <?php echo $form['ending_date']->renderError() ?>
        <?php echo $form['ending_date']->renderLabel() ?><br/>
        <?php echo $form['ending_date'] ?>
      </div>
      <div class="span-7 last">
        <?php echo $form['estimated_time']->renderError() ?>
        <?php echo $form['estimated_time']->renderLabel() ?><br/>
        <?php echo $form['estimated_time'] ?>
      </div>
      <div class="clear"></div>

      <div class="span-3">
        <input class="button block-green medium-round" type="submit" value="<?php echo __('Save') ?>" />
      </div>
      <div class="span-16">&nbsp;
        <?php echo $form->renderHiddenFields() ?>
        <?php if (!$form->getObject()->isNew()): ?>
          <?php echo link_to(__('Delete'), 'idMilestone/delete?id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => __('Do you really want to delete this milestone?'))) ?>
        <?php endif; ?>
      </div>
      <div class="span-3 last">
        <a href="<?php echo url_for('@show_project?id='.$project->getId()) ?>" class="button block-red medium-round"><?php echo __('Back to list'); ?></a>
      </div>
      <div class="clear"></div>
    </form>
  </div>
</div>
