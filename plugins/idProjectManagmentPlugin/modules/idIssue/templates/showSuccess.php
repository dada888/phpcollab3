<?php slot('title', __('Issue details')) ?>

<div class="block" id="issue-table">

  <?php include_partial('create_issue_menu', array('project_id' => $issue->project_id)); ?>

  <div class="content">
    <h2 class="title"><?php echo __('Issue').' #'.$issue->getId() ?></h2>
    <div class="inner">

        <table class="table" id="issue-table">

          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Id') ?></th>
            <th><?php echo __('Title') ?></th>
            <th><?php echo __('Status') ?></th>
            <th><?php echo __('Priority') ?></th>
            <th><?php echo __('Milestone') ?></th>
            <th><?php echo __('Assigned to') ?></th>
            <th><?php echo __('Description') ?></th>
            <th><?php echo __('Starting date') ?></th>
            <th><?php echo __('Ending date') ?></th>
            <th><?php echo __('Estimated time') ?></th>
            <th><?php echo __('Tracker') ?></th>
            <th><?php echo __('Actions') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <tr>
            <td class="first">&nbsp;</td>
              <td>#<?php echo $issue->getId() ?></td>
              <td><?php echo $issue->getTitle() ?></td>
              <td><?php echo $issue->getStatus() ?></td>
              <td><?php echo $issue->getPriority() ?></td>
              <td><?php echo !is_null($issue->milestone_id) ? $issue->getMilestone() : '' ?></td>
              <td>
              <?php if (count($issue->users) > 0): ?>
                <ul>
                  <?php foreach ($issue->users as $user): ?>
                  <li><?php echo $user; ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              </td>
              <td><?php echo $issue->getDescription() ?></td>
              <td><?php echo $issue->getStartingDate() ?></td>
              <td><?php echo $issue->getEndingDate() ?></td>
              <td><?php echo $issue->getEstimatedTime() ?></td>
              <td><?php echo $issue->getTracker() ?></td>
              <td><?php echo link_to(__('Edit'), '@edit_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId()) ?> | <?php echo link_to(__('Delete'), '@delete_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId(), array('confirm' => __('Do you really want to delete this issue?'))) ?></td>
              <td class="last">&nbsp;</td>
          </tr>

          <tr>
            <td colspan="14">
              <?php if ($sf_user->hasFlash('error')): ?>
                <div class="flash">
                  <div class="message error">
                    <p><?php echo $sf_user->getFlash('error') ?></p>
                  </div>
                </div>
              <?php endif; ?>
              <?php if ($sf_user->hasFlash('success')): ?>
                <div class="flash">
                  <div class="message notice">
                    <p><?php echo $sf_user->getFlash('success') ?></p>
                  </div>
                </div>
              <?php endif; ?>
            </td>
          </tr>

          <tr>
            <td></td>
            <td colspan="4">
              <?php echo $estimated_time_form['estimated_time']->renderLabel('Estimated time (hours)') ?>
              <form action="<?php echo url_for('@set_estimated_time_issue?issue_id='.$issue->getId()); ?>" method="post" class="form">
                <?php echo $estimated_time_form['estimated_time'] ?>
                <?php echo $estimated_time_form->renderHiddenFields() ?>
                <input type="submit" value="<?php echo __('Set') ?>" class="button" />
              </form>
            </td>
            <td colspan="4">
              <strong><?php echo __('Report for this issue: ') ?></strong><br />
              <?php if ($sf_user->hasCredential('idLogotime-ReadReport')): ?>
                  <?php echo link_to(__('My log time report'), '@log_time_report_issue_actual_user?issue_id='.$issue->getId()) ?><br />
              <?php endif; ?>
              <?php if ($sf_user->hasCredential('idLogotime-ReadReport')): ?>
                  <?php echo link_to(__('All users log time report'), '@log_time_report_issue_all_users?issue_id='.$issue->getId()) ?>
              <?php endif; ?>
            </td>
            <td colspan="4">
              <?php echo $logtime_form['log_time']->renderLabel('Log time (hours)') ?>
              <form action="<?php echo url_for('@set_log_time_from_issue?issue_id='.$issue->getId()); ?>" method="post" class="form">
                <?php echo $logtime_form['log_time'] ?>
                <?php echo $logtime_form->renderHiddenFields() ?>
                <input type="submit" value="<?php echo __('Add') ?>" class="button" />
              </form>
            </td>
            <td></td>
          </tr>

        </table>

      <?php include_partial('fd_comment/comment_form', array('commentForm' => $commentForm)); ?>
      <?php include_component('fd_comment', 'listByModel', array('model' => $commentForm->getModel(), 'model_field' =>$commentForm->getModelField(), 'model_field_value' =>$issue->getId())) ?>

    </div>
  </div>
</div>

<div class="block" id="comment-form">
  <?php /*include_partial('idComment/comment_form', array('comment_form' => $comment_form, 'issue' => $issue))*/ ?>
</div>

<div class="block" id="related-issue">
  <div class="content">
    <h2 class="title"><?php echo __('Related issues') ?></h2>
    <div class="inner">

    <?php include_partial('idIssue/issues_list', array('pager' => $pager, 'url' => '@show_issue?project_id='.$sf_request->getParameter('project_id').'&issue_id='.$issue->getId())) ?>

    </div>
  </div>
</div>