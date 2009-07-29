<?php $ii=0; ?>
<?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
  <?php $ii++; ?>
  <?php foreach ($fields as $name => $field): ?>

    <?php if (isset($form[$name])) : ?>
      <?php if ($form[$name]->isHidden() || (!isset($form[$name]) && $field->isReal())) continue ?>

      <tr class="<?php echo fmod($ii, 2) ? 'even' : 'odd' ?>">
        <td>&nbsp;</td>

        <td><?php echo $form[$name]->renderLabel() ?></td>
        <td><?php echo $form[$name]->renderError('<br/>') ?><?php echo $form[$name]->render() ?></td>

        <td>&nbsp;</td>
      </tr>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endforeach; ?>