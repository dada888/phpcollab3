<form action="<?php echo url_for('idPriority/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getid() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
        &nbsp;<a href="<?php echo url_for('@index_priority') ?>">Cancel</a>
        <?php if (!$form->getObject()->isNew()): ?>
          &nbsp;<?php echo link_to('Delete', '@delete_priority?id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => 'Do you really want to delete this priority?')) ?>
        <?php endif; ?>
        <input type="submit" value="Save" />
      </td>
    </tr>

  </table>
</form>
