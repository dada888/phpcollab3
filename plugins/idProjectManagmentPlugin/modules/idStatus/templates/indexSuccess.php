
<?php slot('title', __('Manage statuses')) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_status_menu'); ?>
  <div class="content">
    <div class="inner">
      <h2 class="title"><?php echo __('Statuses List') ?></h2>
        <table class="table">

          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Id') ?></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Actions') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <?php if ($status_list->count() !== false && $status_list->count() == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="3"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($status_list as $status): ?>
              <tr class="odd">
                <td>&nbsp;</td>
                <td><a href="<?php echo url_for('@edit_status?id='.$status->getId()) ?>"><?php echo $status->getId() ?></a></td>
                <td><?php echo $status->getName() ?></td>
                <td><?php echo link_to('Edit', '@edit_status?id='.$status->getId()) ?> | <?php echo link_to('Delete', '@delete_status?id='.$status->getId(), array('confirm' => 'Do you really want to delete this status?')) ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>
        
    </div>
  </div>
</div>

