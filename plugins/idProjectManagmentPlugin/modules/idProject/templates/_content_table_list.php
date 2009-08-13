<?php foreach ($pager->getResults() as $i => $sf_guard_object): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
  <tr class="<?php echo $odd ?>">
    <td class="first">&nbsp;</td>

    <?php foreach ($fields as $ii => $field): ?>
      
      <?php if ($ii == 0): ?>
        <td><?php echo link_to($sf_guard_object[$field], 'sf_guard_'.$module_name.'_edit', $sf_guard_object) ?></td>
      <?php else: ?>
        <td><?php echo $sf_guard_object[$field] ?></td>
      <?php endif; ?>

    <?php endforeach; ?>
    <td>
      <?php include_partial('idProject/sf_guard_actions', array('sf_guard_object' => $sf_guard_object, 'module_name' => $module_name)); ?>
    </td>

  </tr>
<?php endforeach; ?>

 <tr>
  <td colspan="6">
  <?php if ($pager->haveToPaginate()): ?>
    <?php include_partial('sfGuard'.ucfirst($module_name).'/pagination', array('pager' => $pager)) ?>
  <?php endif; ?>

  <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
  <?php if ($pager->haveToPaginate()): ?>
    <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
  <?php endif; ?>
   </td>
</tr>