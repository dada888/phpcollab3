
<?php slot('title', __('Edit a permission')) ?>


<div class="block" id="block-tables">

  <?php include_partial('idProject/sf_guard_create_menu', array('module_name' => 'permission')); ?>

  <div class="content">
    <h2 class="title"><?php echo __('Edit permission') ?></h2>
    <div class="inner">
      <?php echo form_tag_for($form, '@sf_guard_permission', array('class' =>'form')) ?>
      
        <?php include_partial('idProject/sf_guard_form_header', array('form' => $form, 'module_name' => 'permission')); ?>

        <table class="table">

         <?php include_partial('idProject/content_table', array('configuration' => $configuration, 'form' => $form)); ?>

        </table>

        <?php include_partial('idProject/sf_guard_form_footer', array('form' => $form, 'module_name' => 'permission')); ?>

      </form>
    </div>
  </div>
</div>

