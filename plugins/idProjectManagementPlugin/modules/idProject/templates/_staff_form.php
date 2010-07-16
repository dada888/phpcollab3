<form action="<?php echo (isset($url)) ? url_for($url) : url_for('@update_project_staff_list?id='.$form->getObject()->getId()); ?>" method="post" >
  <?php echo $form ?>
  <div class="confirm-box">
    <input id="update-staff" type="submit" value="Save" class="button block-green medium-round"/>
  </div>
</form>