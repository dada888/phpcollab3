<form action="<?php echo url_for(($form->getObject()->isNew() ? '@create_milestone' : '@update_milestone').(!$form->getObject()->isNew() ? '?milestone_id='.$form->getObject()->getid().'&project_id='.$project->getId() : '?project_id='.$project->getId())) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      <tr>
        <th class="first">&nbsp;</th>
        <th><?php echo __('Title') ?></th>
        <th><?php echo __('Description') ?></th>
        <th><?php echo __('Starting date') ?></th>
        <th><?php echo __('Ending date') ?></th>
        <th><?php echo __('Estimated time') ?></th>
        <th class="last">&nbsp;</th>
      </tr>
    </tr>

    <tr class="odd">
      <td>&nbsp;</td>
      <td><?php echo $form['title']->renderError('</br>') ?><?php echo $form['title'] ?></td>
      <td><?php echo $form['description']->renderError('</br>') ?><?php echo $form['description'] ?></td>
      <td><?php echo $form['starting_date']->renderError('</br>') ?><?php echo $form['starting_date'] ?></td>
      <td><?php echo $form['ending_date']->renderError('</br>') ?><?php echo $form['ending_date'] ?></td>
      <td><?php echo $form['estimated_time']->renderError('</br>') ?><?php echo $form['estimated_time'] ?></td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td colspan="2">
        <?php echo $form->renderHiddenFields() ?>
        &nbsp;<a href="<?php echo url_for('@show_project?id='.$project->getId()) ?>"><?php echo __('Cancel') ?></a>
        <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to(__('Delete'), 'idMilestone/delete?id='.$form->getObject()->getid(), array('method' => 'delete', 'confirm' => __('Do you really want to delete this milestone?'))) ?>
          <?php endif; ?>
        <input type="submit" value="<?php echo __('Save') ?>" />
      </td>
    </tr>

  </table>
</form>