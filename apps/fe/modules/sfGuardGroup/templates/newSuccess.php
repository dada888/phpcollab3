
<?php slot('title', __('Create a new Group')) ?>

<div class="block" id="block-tables">

  <?php include_partial('idProject/sf_guard_create_menu', array('module_name' => 'group')); ?>

  <div class="content">
    <h2 class="title"><?php echo __('New group creation') ?></h2>
    <div class="inner">
      <?php echo form_tag_for($form, '@sf_guard_group', array('class' =>'form')) ?>

        <?php include_partial('idProject/sf_guard_form_header', array('form' => $form, 'module_name' => 'group')); ?>

        <table class="table">

         <?php include_partial('idProject/content_table', array('configuration' => $configuration, 'form' => $form)); ?>

        </table>

        <?php include_partial('idProject/sf_guard_form_footer', array('form' => $form, 'module_name' => 'group')); ?>

      </form>
    </div>
  </div>
</div>