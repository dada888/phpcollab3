<?php slot('title', __('Manage log time')) ?>

<div class="block" id="block-tables">
  <div class="secondary-navigation">
    <ul>
      <li class="first active"><?php echo link_to( __('Go back to issue'), '@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id) ?></li>
    </ul>
    <div class="clear"></div>
  </div>
  <div class="content">
    <div class="inner">

      <table class="table">
            <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Date') ?></th>
            <th><?php echo __('Logtime') ?></th>
            <th class="last">&nbsp;</th>
            </th>
          </tr>
          <?php $total_logtime = 0; ?>
          <?php if (count($logtime_report) !== false && count($logtime_report) == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="2"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($logtime_report as $key => $log_time): $row = ($key%2 == 0) ? 'odd' : 'even'; ?>
            <?php $total_logtime += $log_time->getLogTime(); ?>
              <tr class="<?php echo $row ?>">
                <td>&nbsp;</td>
                <td><?php echo $log_time->getCreatedAt() ?></td>
                <td><?php echo $log_time->getLogTime().__(' hours'); ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          <tr class="odd">
            <td></td>
            <td colspan="2" id="total_log_time"><?php echo __('Total log time: ').$total_logtime.__(' hours') ?></td>
            <td></td>
          </tr>
        </table>

    </div>
  </div>
</div>