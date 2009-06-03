<div class="block" id="block-filters">
  <div class="content">
    <h2 class="title"><?php echo __('Project filters') ?></h2>
    <div class="inner">
    
      <form action="<?php echo url_for('@index_project') ?>" method="get" class="form">
        <table class="table">
          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Filter by') ?>:</th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Public/Private') ?></th>
            <th><?php echo __('Created after : mm/dd/year') ?></th>
            <th class="last">&nbsp;</th>
          </tr>
          <tr class="odd">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $form['name']->renderError('<br/>') ?><?php echo $form['name'] ?></td>
            <td><?php echo $form['is_public']->renderError('<br/>') ?><?php echo $form['is_public'] ?></td>
            <td><?php echo $form['created_at']->renderError('<br/>') ?><?php echo $form['created_at'] ?></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <div class="actions-bar">
          <div class="actions">
            <?php echo link_to(__('Reset'), '@index_project') ?> or <input type="submit" class="button" value="<?php echo __('Filter') ?>" />
          </div>
          <div class="clear"></div>
        </div>
      </form>
    </div>
  </div>
</div>