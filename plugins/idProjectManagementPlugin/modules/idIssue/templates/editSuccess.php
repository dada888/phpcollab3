<?php slot('title', __('Manage issues')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>

  <div class="span-full">
    <div class="title">
      <span><?php echo __($form->getObject()->isNew() ? 'New issue' : 'Edit issue'); ?></span>
    </div>
    <form id="new" action="<?php echo url_for(($form->getObject()->isNew() ? '@create_issue' : '@update_issue').($form->getObject()->isNew() ? '?project_id='.$project->id : '?project_id='.$project->id.'&issue_id='.$form->getObject()->getid())) ?>" method="post" >
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

      <div class="span-21 last menu prepend-1">Specifications</div>
      <div class="span-5">
        <?php echo $form['milestone_id']->renderError() ?>
        <?php echo $form['milestone_id']->renderLabel() ?><br/>
        <?php echo $form['milestone_id'] ?>
      </div>
      <div class="span-6">
        <?php echo $form['tracker_id']->renderError() ?>
        <?php echo $form['tracker_id']->renderLabel() ?><br/>
        <?php echo $form['tracker_id'] ?>
      </div>
      <div class="span-6">
        <?php echo $form['status_id']->renderError() ?>
        <?php echo $form['status_id']->renderLabel() ?><br/>
        <?php echo $form['status_id'] ?>
      </div>
      <div class="span-5 last">
        <?php echo $form['priority_id']->renderError() ?>
        <?php echo $form['priority_id']->renderLabel() ?><br/>
        <?php echo $form['priority_id'] ?>
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

      <div class="span-21 last menu prepend-1">Relations</div>
      <div class="span-11 multiple-selection">
        <?php echo $form['issues_list']->renderError() ?>
        <?php echo $form['issues_list']->renderLabel() ?><br/>
        <?php echo $form['issues_list'] ?>
      </div>
      <div class="span-11 multiple-selection last">
        <?php echo $form['users_list']->renderError() ?>
        <?php echo $form['users_list']->renderLabel() ?><br/>
        <?php echo $form['users_list'] ?>
      </div>
      <div class="clear"></div>

      <div class="span-3">
        <input class="button block-green medium-round" type="submit" value="<?php echo __('Save') ?>" />
      </div>
      <div class="span-16">&nbsp;
        <?php if (!$form->getObject()->isNew()): ?>
          <?php echo link_to(__('Delete'), '@delete_issue?project_id='.$project->id.'&issue_id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => __('Do you really want to delete this issue?'))) ?>
        <?php endif; ?>
        <?php echo $form->renderHiddenFields() ?>
      </div>
      <div class="span-3 last">
        <a href="<?php echo url_for('@index_issue?project_id='.$project->id) ?>" class="button block-red medium-round"><?php echo __('Back to list'); ?></a>
      </div>
      <div class="clear"></div>
    </form>
  </div>
</div>

