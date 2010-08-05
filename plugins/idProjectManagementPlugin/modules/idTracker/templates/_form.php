<form action="<?php echo url_for('idTracker/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getid() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      <th class="last"></th>
    </tr>

    <tr class="odd">
      <td>&nbsp;</td>
      <td><?php echo $form['name']->renderLabel() ?></td>
      <td>
        <?php echo $form['name']->renderError() ?>
        <?php echo $form['name'] ?>
      </td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td colspan="2">
        <?php echo $form->renderHiddenFields() ?>
        &nbsp;<?php echo link_to(__('Back to list'), '@index_trackers') ?>
        <?php if (!$form->getObject()->isNew()): ?>
          &nbsp;<?php echo link_to(__('Delete'), '@delete_tracker?id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => __('Do you really want to delete this priority?'))) ?>
        <?php endif; ?>
        <input type="submit" value="<?php echo __('Save'); ?>" />
      </td>
    </tr>

  </table>
</form>