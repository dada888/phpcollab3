<div class="block" id="block-filters">
  <div class="content">
    <h2 class="title"><?php echo __(ucfirst($module_name).' filters') ?></h2>
    <div class="inner">

      <?php if ($form->hasGlobalErrors()): ?>
        <div class="flash">
          <div class="message error">
            <p><?php echo $form->renderGlobalErrors() ?></p>
          </div>
        </div>
      <?php endif; ?>

      <form action="<?php echo url_for('sf_guard_'.$module_name.'_collection', array('action' => 'filter')) ?>" method="post">
        <table class="table">
          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Filter by:') ?></th>

            <?php foreach ($fields as $field): ?>
              <th><?php echo __(ucfirst(str_replace('_',' ',$field))) ?></th>
            <?php endforeach;?>

            <th class="last">&nbsp;</th>
          </tr>


          <tr class="odd">
            <td>&nbsp;</td>
            <td>&nbsp;</td>

            <?php foreach ($fields as $field): ?>
              <td><?php echo $form[$field]->renderError('<br/>') ?><?php echo $form[$field] ?></td>
            <?php endforeach;?>

            <td>&nbsp;</td>
          </tr>



        </table>
        <div class="actions-bar">
          <div class="actions">
            <?php echo $form->renderHiddenFields() ?>
            <?php echo link_to(__('Reset', array(), 'sf_admin'), 'sf_guard_'.$module_name.'_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?>
            <input type="submit" value="<?php echo __('Filter', array(), 'sf_admin') ?>"  class="button" />
          </div>
          <div class="clear"></div>
        </div>
      </form>
    </div>
  </div>
</div>