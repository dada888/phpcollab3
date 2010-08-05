<form action="<?php echo url_for('idStatus/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getid() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <?php if ($form->hasGlobalErrors()): ?>
    <div class="group">
      <div class="fieldWithErrors">
        <span class="error"><?php echo $form->renderGlobalErrors() ?></span>
      </div>
    </div>
  <?php endif; ?>

  <table class="table">

    <tr>
      <th class="first"></th>
      <th><?php echo __('Fields') ?></th>
      <th><?php echo __('Values') ?></th>
      <th><?php echo __('Status type') ?></th>
      <th class="last"></th>
    </tr>

    <tr class="odd">
      <td>&nbsp;</td>
      <td><?php echo $form['name']->renderLabel() ?></td>
      <td>
        <?php echo $form['name']->renderError() ?>
        <?php echo $form['name'] ?>
      </td>
      <td>
        <?php echo $form['status_type']->renderError() ?>
        <?php echo $form['status_type'] ?>
      </td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td colspan="2">
        <?php echo $form->renderHiddenFields() ?>
        &nbsp;<?php echo link_to(__('Back to list'), '@index_status') ?>
        <?php if (!$form->getObject()->isNew()): ?>
          &nbsp;<?php echo link_to(__('Delete'), '@delete_status?id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => __('Do you really want to delete this status?'))) ?>
        <?php endif; ?>
        <input type="submit" value="<?php echo __('Save'); ?>" />
      </td>
    </tr>

  </table>
</form>
