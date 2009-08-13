
<?php foreach ($fields as $field): ?>

  <?php slot('sf_admin.current_header') ?>
  <th>
    <?php 
      $dot_field_name = strstr($field, '.');
      $n = 1;
      $field_name = str_replace('.', '', $dot_field_name, $n);
    ?>
    <?php if ($field == $sort[0]): ?>
      <?php echo link_to(__(ucfirst(str_replace('_',' ',$field_name)), array(), 'messages'), 'sfGuard'.ucfirst($module_name).'/index?sort='.$field.'&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
      <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
    <?php else: ?>
      <?php echo link_to(__(ucfirst(str_replace('_',' ',$field_name)), array(), 'messages'), 'sfGuard'.ucfirst($module_name).'/index?sort='.$field.'&sort_type=asc') ?>
    <?php endif; ?>
  </th>
  <?php end_slot(); ?>
  <?php include_slot('sf_admin.current_header') ?>
  
<?php endforeach; ?>