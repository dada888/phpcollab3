<?php slot('title', __('Issue details')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $issue->getProject()))?>

  <div id="issue-specifications" class="span-full">
    <div class="title">
      <span><?php echo __('Issue').' #'.$issue->getId().': '.$issue->getTitle() ?> </span>
      <span class="actions">
        <?php echo link_to(__('Edit'), '@edit_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId()) ?>
        <?php echo link_to(__('Delete'), '@delete_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId(), array('confirm' => __('Do you really want to delete this issue?'))) ?>
      </span>
    </div>

    <div class="description"><?php echo $issue->getDescription() ?></div>
    <hr/>
    <div class="clear"></div>
    <div class="span-11">
      <div class="span-6 key">Tracker:</div>
      <div class="span-5 last"><?php echo $issue->getTracker() ?></div>
      <div class="span-6 key">Status:</div>
      <div class="span-5 last"><?php echo $issue->getStatus() ?></div>
      <div class="span-6 key">Priority:</div>
      <div class="span-5 last"><?php echo $issue->getPriority() ?></div>
      <div class="span-6 key">Milestone:</div>
      <div class="span-5 last"><?php echo $issue->getMilestone() ?></div>
    </div>
    <div class="span-12 last">
      <div class="span-6 key">Starging date:</div>
      <div class="span-6 last"><?php echo $issue->getStartingDate() ?></div>
      <div class="span-6 key">Ending date:</div>
      <div class="span-6 last"><?php echo $issue->getEndingDate() ?></div>
      <div class="span-6 key">Assigned to:</div>
      <div class="span-6 last">
        <?php if (count($issue->users) > 0): ?>
          <ul>
            <?php foreach ($issue->users as $user): ?>
            <li><?php echo $user->getShortName(); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
    <div class="clear"></div>

    <?php if ($sf_user->hasFlash('error')): ?>
    <div class="error">
      <?php echo $sf_user->getFlash('error') ?>
    </div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('success')): ?>
    <div class="notice">
      <?php echo $sf_user->getFlash('success') ?>
    </div>
    <?php endif; ?>

    <div class="span-11">
      <div class="span-5 key">Estimated time:</div>
      <div class="span-6 last">
        <form action="<?php echo url_for('@set_estimated_time_issue?issue_id='.$issue->getId()); ?>" method="post" class="form">
          <div class="span-3 time"><?php echo $estimated_time_form['estimated_time'] ?></div>
          <div class="span-3 last"><input class="button" type="submit" value="<?php echo __('Set') ?>"/></div>
          <?php echo $estimated_time_form->renderHiddenFields() ?>
        </form>
      </div>
    </div>
    <div class="span-12 last">
      <div class="span-6 key">
        Log time: <?php echo $issue->getTotalLogTime(); ?><br/>
        <?php if ($sf_user->hasCredential('idLogotime-ReadReport')): ?>
          <?php echo link_to(__('My log time report'), '@log_time_report_issue_actual_user?issue_id='.$issue->getId()) ?><br />
        <?php endif; ?>
        <?php if ($sf_user->hasCredential('idLogotime-ReadReport')): ?>
          <?php echo link_to(__('All users log time report'), '@log_time_report_issue_all_users?issue_id='.$issue->getId()) ?>
        <?php endif; ?>
      </div>
      <div class="span-6 last">
        <form action="<?php echo url_for('@set_log_time_from_issue?issue_id='.$issue->getId()); ?>" method="post" class="form">
          <div class="span-3 time"><?php echo $logtime_form['log_time'] ?></div>
          <div class="span-3 last"><input type="submit" value="<?php echo __('Add') ?>" class="button" /></div>
          <?php echo $logtime_form->renderHiddenFields() ?>
        </form>
      </div>
    </div>
    <div class="clear"></div>

    <div class="span-full">
      <?php if(count($issue->issues) > 0): ?>
      <h3>Related issues</h3>
      <ul>
        <?php foreach($issue->issues as $related_isue):?>
        <li>
          <?php echo link_to('#'.$related_isue->id, '@show_issue?project_id='.$issue->project_id.'&issue_id='.$related_isue->getId())?>
          <?php echo $related_isue->getTitle() ?>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>

    </div>

    <hr/>
    <div class="span-full">
      <h3>
        Comments list
        <a id="add-comment"class="button block-green medium-round" href="#">Add</a>
      </h3>

      <form id="fd_form" action="<?php echo url_for('@fd_comment_create?model='.$commentForm->getModel()
                                                   .'&model_field='.$commentForm->getModelField()
                                                   .'&model_field_value='.$commentForm->getModelFieldValue()) ?>" method="post" >
        <div class="span-full">
          <?php echo $commentForm['title']->renderError(); ?>
          <?php echo $commentForm['title']->renderLabel(null, array('class' => 'label')); ?><br/>
          <?php echo $commentForm['title']->render(array('class' => 'text_field')); ?>
        </div>
        <div class="span-full">
          <?php echo $commentForm['body']->renderError(); ?>
          <?php echo $commentForm['body']->renderLabel(null, array('class' => 'label')); ?><br/>
          <?php echo $commentForm['body']->render(array('class' => 'text_area')); ?>
        </div>
        <?php echo $commentForm->renderHiddenFields(); ?>
        <input class="button" type="submit" value="<?php echo __('Leave a comment') ?>" />
        <div class="clear"></div>
      </form>

      <?php include_component('fd_comment', 'listByModel', array('model' => $commentForm->getModel(), 'model_field' =>$commentForm->getModelField(), 'model_field_value' =>$issue->getId())) ?>
    </div>

  </div>
</div>

<script type="text/javascript">
$('#fd_form').hide();
$(function() {
  $("#add-comment").click(function() {
    $('#fd_form').show();
    return false;
  });

});
</script>