<?php slot('title', __('Manage trackers')) ?>

<div class="span-23" id="content">
  <?php include_partial('idProject/sub_menu_settings')?>
  <div class="title">
    <span><?php echo __('Trackers'); ?></span>
    <a id="add-log-time"class="button block-green medium-round" href="<?php echo url_for('@new_tracker') ?>">Add</a>
  </div>
  
  <table class="table">
    <tr class="menu">
        <th class="first">&nbsp;</th>
        <th><?php echo __('Name'); ?></th>
        <th class="last">
        <?php echo __('Actions'); ?>
        </th>
      </tr>

      <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
        <tr><td colspan="5"><?php echo __('No Results') ?></td></tr>
      <?php else: ?>
        <?php foreach ($pager->getResults() as $key => $tracker): ?>
          <?php $row_class = ($key%2 == 0) ? 'odd' : 'even';?>
          <tr class="<?php echo $row_class; ?>">
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