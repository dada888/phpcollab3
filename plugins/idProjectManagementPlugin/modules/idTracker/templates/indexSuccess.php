<?php slot('title', __('Manage trackers')) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_tracker_menu'); ?>
  <div class="content">
    <div class="inner">

      <table class="table">
          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Name'); ?></th>
            <th class="last">
            <?php echo __('Actions'); ?>
            </th>
          </tr>

          <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
            <tr class="odd"><td colspan="5"><?php echo __('No Results') ?></td></tr>
          <?php else: ?>
            <?php foreach ($pager->getResults() as $tracker): ?>
              <tr class="odd">
                <td>&nbsp;</td>
                <td><?php echo $tracker->getName() ?></td>
                <td>
                <?php echo link_to(__('Edit'), '@edit_tracker?id='.$tracker->getId()) ?> |
                <?php echo link_to(__('Delete'), '@delete_tracker?id='.$tracker->getId(), array('confirm' => __('Do you really want to delete this tracker?'))) ?>
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