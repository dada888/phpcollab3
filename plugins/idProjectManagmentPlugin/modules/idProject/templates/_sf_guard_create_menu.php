<div class="secondary-navigation">
  <ul>
    <li class="first active"><?php echo link_to( __('Create new '.$module_name), '@sf_guard_'.$module_name.'_new') ?></li>
    <li><?php echo link_to( __(ucfirst($module_name).'s list'), 'sf_guard_'.$module_name) ?></li>
  </ul>
  <div class="clear"></div>
</div>