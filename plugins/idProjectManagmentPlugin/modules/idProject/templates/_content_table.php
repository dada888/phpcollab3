<?php $ii=0; ?>
<?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
  <?php $ii++; ?>
  <?php foreach ($fields as $name => $field): ?>

    <?php if (isset($form[$name])) : ?>
      <?php if ($form[$name]->isHidden() || (!isset($form[$name]) && $field->isReal())) continue ?>

      <?php if ($name == 'Profile'): ?>
      <tr>
        <td>&nbsp;</td>

        <td><?php echo $form['Profile']['first_name']->renderLabel() ?></td>
        <td><?php echo $form['Profile']['first_name']->renderError() ?><?php echo $form['Profile']['first_name']->render() ?></td>

        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>

        <td><?php echo $form['Profile']['last_name']->renderLabel() ?></td>
        <td><?php echo $form['Profile']['last_name']->renderError() ?><?php echo $form['Profile']['last_name']->render() ?></td>

        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>

        <td><?php echo $form['Profile']['email']->renderLabel() ?></td>
        <td><?php echo $form['Profile']['email']->renderError() ?><?php echo $form['Profile']['email']->render() ?></td>

        <td>&nbsp;</td>
      </tr>
      <?php continue; endif;?>

      <tr>
        <td>&nbsp;</td>

        <td><?php echo $form[$name]->renderLabel() ?></td>
        <td><?php echo $form[$name]->renderError('<br/>') ?><?php echo $form[$name]->render() ?></td>

        <td>&nbsp;</td>
      </tr>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endforeach; ?>