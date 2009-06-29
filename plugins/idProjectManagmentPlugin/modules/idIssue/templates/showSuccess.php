<?php use_helper('Javascript') ?>
<?php slot('title', __('Issue details')) ?>

<div class="block" id="issue-table">

  <?php include_partial('create_issue_menu', array('project_id' => $issue->project_id)); ?>

  <div class="content">
    <h2 class="title"><?php echo __('Issue').' #'.$issue->getId() ?></h2>
    <div class="inner">

        <table class="table">

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
            <th><?php echo __('Actions') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <tr>
            <td class="first">&nbsp;</th>
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
              <td><?php echo link_to(__('Edit'), '@edit_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId()) ?> | <?php echo link_to(__('Delete'), '@delete_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId(), array('confirm' => __('Do you really want to delete this issue?'))) ?></td>
              <td class="last">&nbsp;</td>
          </tr>

        </table>
    </div>
  </div>
</div>

<div class="block" id="comment-form">
  <?php include_partial('idComment/comment_form', array('comment_form' => $comment_form, 'issue' => $issue)) ?>
</div>

<div class="block" id="related-issue">
  <div class="content">
    <h2 class="title"><?php echo __('Related issues') ?></h2>
    <div class="inner">

    <?php include_partial('idIssue/issues_list', array('pager' => $pager, 'url' => '@show_issue?project_id='.$sf_request->getParameter('project_id').'&issue_id='.$issue->getId())) ?>

    </div>
  </div>
</div>