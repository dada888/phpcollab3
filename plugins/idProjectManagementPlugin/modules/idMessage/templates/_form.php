<form action="<?php echo url_for('idMessage/'.($form->getObject()->isNew() ? 'create' : 'update')
                                 .'?project_id='.$sf_request->getParameter('project_id')
                                 .(!$form->getObject()->isNew() ? '&message_id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
  <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="group">
      <div class="message">
        <span class="notice"><?php echo $sf_user->getFlash('notice') ?></span>
      </div>
    </div>
  <?php endif; ?>

  <table  class="table" >
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th class="first">&nbsp;</th>
        <th><?php echo __('Title') ?> <?php echo __('Body') ?></th>
        <th class="last">&nbsp;</th>
      </tr>
      <tr>
        <td></td>
        <td>
          <?php echo $form['title']->renderLabel(__('Title')) ?><br />
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <?php echo $form['body']->renderLabel(__('Body')) ?><br />
          <?php echo $form['body']->renderError() ?>
          <?php echo $form['body'] ?>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="3">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('@index_messages?project_id='.$sf_request->getParameter('project_id')) ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', '@delete_message?message_id='.$form->getObject()->getId().'&project_id='.$sf_request->getParameter('project_id'), array('method' => 'delete', 'confirm' => 'Do you really want to delete this message?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
        <td></td>
      </tr>
  </table>
</form>
