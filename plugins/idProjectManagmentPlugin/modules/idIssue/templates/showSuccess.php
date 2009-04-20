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
            <th><?php echo __('Description') ?></th>
            <th><?php echo __('Starting date') ?></th>
            <th><?php echo __('Ending date') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <tr>
            <td class="first">&nbsp;</th>
              <td>#<?php echo $issue->getId() ?></td>
              <td><?php echo $issue->getTitle() ?></td>
              <td><?php echo $issue->getStatus() ?></td>
              <td><?php echo $issue->getPriority() ?></td>
              <td><?php echo $issue->getDescription() ?></td>
              <td><?php echo $issue->getStartingDate() ?></td>
              <td><?php echo $issue->getEndingDate() ?></td>
            <td class="last">&nbsp;</td>
          </tr>

        </table>

    </div>
  </div>
</div>

<div class="block" id="issue-actions">

  <div class="content">
    <div class="inner">
      
        <table class="table">

          <tr>
            <th class="first">&nbsp;</th>
            <th colspan="2"><?php echo __('Actions') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <tr>
            <td class="first">&nbsp;</th>
            <td><?php echo link_to(__('Update issue'), '@edit_issue?id='.$issue->project_id.'&issue_id='.$issue->getId()) ?></td>
            <td><?php echo link_to(__('Delete issue'), '@delete_issue?id='.$issue->project_id.'&issue_id='.$issue->getId(), array('confirm' => 'Do you really want to delete this issue?')) ?></td>
            <td class="last">&nbsp;</td>
          </tr>

        </table>

    </div>
  </div>
</div>