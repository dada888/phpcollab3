<form action="<?php echo url_for('idIssue/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?issue_id='.$form->getObject()->getid() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="form">

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
        <td><?php echo $form['title']->renderLabel() ?></td>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="even">
        <td>&nbsp;</td>
        <td><?php echo $form['description']->renderLabel() ?></td>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="odd">
        <td>&nbsp;</td>
        <td><?php echo $form['status_id']->renderLabel('Status') ?></td>
        <td>
          <?php echo $form['status_id']->renderError() ?>
          <?php echo $form['status_id'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="even">
        <td>&nbsp;</td>
        <td><?php echo $form['priority_id']->renderLabel('Priority') ?></td>
        <td>
          <?php echo $form['priority_id']->renderError() ?>
          <?php echo $form['priority_id'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="odd">
        <td>&nbsp;</td>
        <td><?php echo $form['starting_date']->renderLabel() ?></td>
        <td>
          <?php echo $form['starting_date']->renderError() ?>
          <?php echo $form['starting_date'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="even">
        <td>&nbsp;</td>
        <td><?php echo $form['ending_date']->renderLabel() ?></td>
        <td>
          <?php echo $form['ending_date']->renderError() ?>
          <?php echo $form['ending_date'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="odd">
        <td>&nbsp;</td>
        <td><?php echo $form['users_list']->renderLabel('Assign to') ?></td>
        <td>
          <?php echo $form['users_list']->renderError() ?>
          <?php echo $form['users_list'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('@index_issue?id='.$project_id) ?>">Cancel</a> 
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', '@delete_issue?id='.$project_id.'&issue_id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => 'Do you really want to delete this issue?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
  </table>
</form>