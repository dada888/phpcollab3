<table class="table">
  <tr>
    <th class="first"><?php echo __('Id') ?></th>
    <th><?php echo __('Title') ?></th>
    <th><?php echo __('Status') ?></th>
    <th><?php echo __('Priority') ?></th>
    <th><?php echo __('Milestone') ?></th>
    <th><?php echo __('Assigned to') ?></th>
    <th><?php echo __('Description') ?></th>
    <th><?php echo __('Starting date') ?></th>
    <th><?php echo __('Ending date') ?></th>
    <th class="last"><?php echo __('Actions') ?></th>
  </tr>
  
  <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
    <tr class="odd">
      <td class="first">&nbsp;</td>
      <td colspan="6"><?php echo __('No Results') ?></td>
      <td class="last">&nbsp;</td>
    </tr>
  <?php else: ?>
    <?php foreach ($pager->getResults() as $issue): ?>
      <tr class="odd">
        <td><?php echo link_to('#'.$issue->getId(), '@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId()) ?></td>
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
        <td><?php echo format_date($issue->getStartingDate()) ?></td>
        <td><?php echo format_date($issue->getEndingDate()) ?></td>
        <td><?php echo link_to(__('Edit'), '@edit_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId()) ?> | <?php echo link_to(__('Delete'), '@delete_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId(), array('confirm' => __('Do you really want to delete this issue?'))) ?></td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>

  <tr>
    <td></td>
    <td colspan="5"><?php  echo pager_navigation($pager, $url) ?></td>
    <td></td>
  </tr>
</table>