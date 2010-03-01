<?php slot('title', __('Manage log time')) ?>

<div class="block" id="block-tables">
  <div class="secondary-navigation">
    <ul>
      <li class="first active"><?php echo link_to( __('Go back to project'), '@show_project?id='.$sf_request->getParameter('project_id')) ?></li>
    </ul>
    <div class="clear"></div>
  </div>
  <div class="content">
    <div class="inner">

      <table class="table">
            <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('User') ?></th>
            <th><?php echo __('Date') ?></th>
            <th><?php echo __('Logtime') ?></th>
            <th><?php echo __('Issue') ?></th>
            <th class="last">&nbsp;</th>
            </th>
          </tr>
          <?php if (count($logtime_report) !== false && count($logtime_report) == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="3"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($logtime_report as $key => $log_time): $row = ($key%2 == 0) ? 'odd' : 'even'; ?>
              <tr class="<?php echo $row ?>">
                <td>&nbsp;</td>
                <td><?php echo $log_time->getProfile() ?></td>
                <td><?php echo $log_time->getCreatedAt() ?></td>
                <td><?php echo $log_time->getLogTime().__(' hours') ?></td>
                <td><?php echo $log_time->getIssue()->getTitle() ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>

    </div>
  </div>
</div>