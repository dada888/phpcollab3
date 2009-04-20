<ul>
  <?php echo '<li>'.link_to(__('Edit'), '@sf_guard_'.$module_name.'_edit?id='.$sf_guard_object->getId()).'</li>' ?>
  <?php echo '<li>'.link_to(__('Delete'), '@sf_guard_'.$module_name.'_delete?id='.$sf_guard_object->getId(), array('confirm' => 'Do you really want to delete this '.$module_name.'?')).'</li>' ?>
</ul>
