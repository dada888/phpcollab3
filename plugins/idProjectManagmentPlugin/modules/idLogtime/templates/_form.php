<form action="<?php echo url_for('idLogtime/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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

  <table  class="table" >
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th class="first">&nbsp;</th>
        <th><?php echo __('Issue') ?></th>
        <th><?php echo __('User') ?></th>
        <th><?php echo __('Logtime') ?></th>
        <th class="last">&nbsp;</th>
      </tr>
      <tr>
        <td></td>
        <td>
          <?php echo $form['issue_id']->renderLabel(__('Issue')) ?></th>
          <?php echo $form['issue_id']->renderError() ?>
          <?php echo $form['issue_id'] ?>
        </td>
        <td>
          <?php echo $form['profile_id']->renderLabel(__('User')) ?>
          <?php echo $form['profile_id']->renderError() ?>
          <?php echo $form['profile_id'] ?>
        </td>
        <td>
          <?php echo $form['log_time']->renderLabel(__('Log time')) ?>
          <?php echo $form['log_time']->renderError() ?>
          <?php echo $form['log_time'] ?>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="3">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('idLogtime/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'idLogtime/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
        <td></td>
      </tr>
  </table>
</form>
