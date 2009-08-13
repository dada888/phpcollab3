<form action="<?php echo url_for(($form->getObject()->isNew() ? '@create_issue' : '@update_issue').($form->getObject()->isNew() ? '?project_id='.$project_id : '?project_id='.$project_id.'&issue_id='.$form->getObject()->getid())) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="form">

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

      <tr class="even">
        <td>&nbsp;</td>
        <td><?php echo $form['title']->renderLabel() ?></td>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="odd">
        <td>&nbsp;</td>
        <td><?php echo $form['description']->renderLabel() ?></td>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="even">
        <td>&nbsp;</td>
        <td><?php echo $form['tracker_id']->renderLabel() ?></td>
        <td>
          <?php echo $form['tracker_id']->renderError() ?>
          <?php echo $form['tracker_id'] ?>
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
      <tr class="odd">
        <td>&nbsp;</td>
        <td><?php echo $form['milestone_id']->renderLabel('Milestone') ?></td>
        <td>
          <?php echo $form['milestone_id']->renderError() ?>
          <?php echo $form['milestone_id'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="even">
        <td>&nbsp;</td>
        <td><?php echo $form['related_issue_list']->renderLabel('Related issues') ?></td>
        <td>
          <?php echo $form['related_issue_list']->renderError() ?>
          <?php echo $form['related_issue_list'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="odd">
        <td>&nbsp;</td>
        <td><?php echo $form['estimated_time']->renderLabel('Estimated time') ?></td>
        <td>
          <?php echo $form['estimated_time']->renderError() ?>
          <?php echo $form['estimated_time'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('@index_issue?project_id='.$project_id) ?>"><?php echo __('Cancel'); ?></a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to(__('Delete'), '@delete_issue?project_id='.$project_id.'&issue_id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => __('Do you really want to delete this issue?'))) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('Save') ?>" />
        </td>
      </tr>
  </table>
</form>