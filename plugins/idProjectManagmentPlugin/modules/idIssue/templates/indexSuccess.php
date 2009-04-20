<?php slot('title', __('Manage project issues')) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_issue_menu', array('project_id'=>$sf_request->getParameter('id'))); ?>
  <div class="content">
    <div class="inner">

        <table class="table">
          <tr>
            <th class="first">Id</th>
            <th><?php echo __('Title') ?></th>
            <th><?php echo __('Status') ?></th>
            <th><?php echo __('Priority') ?></th>
            <th><?php echo __('Description') ?></th>
            <th><?php echo __('Starting date') ?></th>
            <th><?php echo __('Ending date') ?></th>
            <th class="last"><?php echo __('Actions') ?></th>
          </tr>

          <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="5"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($pager->getResults() as $issue): ?>
              <tr class="odd">
                <td><a href="<?php echo url_for('@show_issue?id='.$issue->project_id.'&issue_id='.$issue->getId()) ?>"><?php echo $issue->getId() ?></a></td>
                <td><?php echo $issue->getTitle() ?></td>
                <td><?php echo $issue->getStatus() ?></td>
                <td><?php echo $issue->getPriority() ?></td>
                <td><?php echo $issue->getDescription() ?></td>
                <td><?php echo $issue->getStartingDate() ?></td>
                <td><?php echo $issue->getEndingDate() ?></td>
                <td><?php echo link_to('Edit', '@edit_issue?id='.$issue->project_id.'&issue_id='.$issue->getId()) ?> | <?php echo link_to('Delete', '@delete_issue?id='.$issue->getProject()->getId().'&issue_id='.$issue->getId(), array('confirm' => 'Do you really want to delete this issue?')) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>

          <tr>
            <td></td>
            <td colspan="5"><?php  echo pager_navigation($pager, '@index_issue?id='.$sf_request->getParameter('id')) ?></td>
            <td></td>
          </tr>
        </table>



    </div>
  </div>
</div>

