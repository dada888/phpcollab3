<div class="actions-bar">
  <div class="actions">
    <?php echo (!$form->isNew()) ? link_to(__('Delete'), '@sf_guard_'.$module_name.'_delete?id='.$form->getObject()->getId(), array('confirm' => __('Do you really want to delete this '.$module_name.'?'))).' | ' : '' ;?>
    <?php echo link_to(__('Cancel'), 'sf_guard_'.$module_name); ?> |
    <?php echo input_tag('Submit', ($form->isNew()) ? __('Save') : __('Save modification'), array('class' => 'button', 'type' => 'submit'))?>
  </div>
  <div class="clear"></div>
</div>