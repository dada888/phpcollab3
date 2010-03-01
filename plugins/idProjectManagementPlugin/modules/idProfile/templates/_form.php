<form action="<?php echo url_for('@update_profile') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="form">

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
        <td><?php echo $form['password']->renderLabel() ?></td>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="odd">
        <td>&nbsp;</td>
        <td><?php echo $form['password_again']->renderLabel() ?></td>
        <td>
          <?php echo $form['password_again']->renderError() ?>
          <?php echo $form['password_again'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="even">
        <td>&nbsp;</td>
        <td><?php echo $form['Profile']['first_name']->renderLabel() ?></td>
        <td>
          <?php echo $form['Profile']['first_name']->renderError() ?>
          <?php echo $form['Profile']['first_name'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="odd">
        <td>&nbsp;</td>
        <td><?php echo $form['Profile']['last_name']->renderLabel() ?></td>
        <td>
          <?php echo $form['Profile']['last_name']->renderError() ?>
          <?php echo $form['Profile']['last_name'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="even">
        <td>&nbsp;</td>
        <td><?php echo $form['Profile']['email']->renderLabel() ?></td>
        <td>
          <?php echo $form['Profile']['email']->renderError() ?>
          <?php echo $form['Profile']['email'] ?>
        </td>
        <td>&nbsp;</td>
      </tr>
      
      <tr class="odd">
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('@index_profile') ?>"><?php echo __('Cancel'); ?></a>
          <input type="submit" value="<?php echo __('Save') ?>" class="button" />
        </td>
      </tr>
  </table>
</form>