<?php slot('title', __('Manage log time')) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_logtime_menu'); ?>
  <div class="content">
    <div class="inner">

      <table class="table">
            <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Logtime id') ?></th>
            <th><?php echo __('Date') ?></th>
            <th><?php echo __('Issue') ?></th>
            <th><?php echo __('User') ?></th>
            <th><?php echo __('Logtime') ?></th>
            <th class="last">
              <?php if($sf_user->hasCredential('idLogtime-Edit')): ?>
              <?php echo __('Actions'); ?>
            <?php endif; ?>
            </th>
          </tr>

          <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="5"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($pager->getResults() as $log_time): ?>
              <tr class="odd">
                <td>&nbsp;</td>
                <td><a href="<?php echo url_for('idLogtime/edit?id='.$log_time->getId()) ?>"><?php echo $log_time->getId() ?></a></td>
                <td><?php echo $log_time->getCreatedAt() ?></td>
                <td><?php echo link_to($log_time->getIssue(), '@show_issue?project_id='.$log_time->getIssue()->getProjectId().'&issue_id='.$log_time->getIssue()->getId()); ?></td>
                <td><?php echo $log_time->getProfile() ?></td>
                <td><?php echo $log_time->getLogTime() ?></td>
                <td>
                  <?php if($sf_user->hasCredential('idLogtime-Edit')): ?>
                    <?php echo link_to(__('Edit'), '@edit_logtime?id='.$log_time->getId()) ?> |
                    <?php echo link_to(__('Delete'), '@delete_logtime?id='.$log_time->getId(), array('confirm' => __('Do you really want to delete this tracker?'))) ?>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          <tr>
            <td></td>
            <td><?php  echo pager_navigation($pager, '@index_trackers') ?></td>
            <td></td>
          </tr>
        </table>

    </div>
  </div>
</div>


