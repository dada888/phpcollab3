<?php slot('title', __('Manage priorities')) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_priority_menu'); ?>
  <div class="content">
    <div class="inner">
      <h2 class="title"><?php echo __('Priorities List') ?></h2>
        <table class="table">

          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Id') ?></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Actions') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <?php if ($priority_list->count() !== false && $priority_list->count() == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="3"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($priority_list as $priority): ?>
              <tr class="odd">
                <td>&nbsp;</td>
                <td><a href="<?php echo url_for('@edit_priority?id='.$priority->getId()) ?>"><?php echo $priority->getId() ?></a></td>
                <td><?php echo $priority->getName() ?></td>
                <td><?php echo link_to('Edit', '@edit_priority?id='.$priority->getId()) ?> | <?php echo link_to('Delete', '@delete_priority?id='.$priority->getId(), array('confirm' => 'Do you really want to delete this priority?')) ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>



    </div>
  </div>
</div>

