<?php slot('title', __('Manage Projects')) ?>

<?php include_partial('filters', array('form' => $form)); ?>

<div class="block" id="block-tables">
  <?php include_partial('create_project_menu', array('action' => 'index', 'sf_user' => $sf_user)); ?>
  <div class="content">
    <h2 class="title"><?php echo __('Projects list') ?></h2>
    <div class="inner">

        <table class="table">
          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Name'); ?></th>
            <th><?php echo __('Description'); ?></th>
            <th><?php echo __('Public/Private'); ?></th>
            <th class="last">
            <?php if($sf_user->isAdmin()): ?>
              <?php echo __('Actions'); ?>
            <?php endif; ?>
            </th>
          </tr>

          <?php if ($project_list->count() !== false && $project_list->count() == 0): ?>
            <tr class="odd"><td colspan="5"><?php echo __('No Results') ?></td></tr>
          <?php else: ?>
            <?php foreach ($project_list as $project): ?>
              <tr class="odd">
                <td>&nbsp;</td>
                <td><a href="<?php echo url_for('@show_project?id='.$project['id']) ?>"><?php echo $project->getName(); ?></a></td>
                <td><?php echo $project->getdescription() ?></td>
                <td><?php echo $project->getis_public() ? __('Public') : __('Private'); ?></td>

                <td>
                <?php if($sf_user->isAdmin()): ?>
                  <?php echo link_to(__('Edit'), '@edit_project?id='.$project['id']) ?> | <?php echo link_to(__('Delete'), '@delete_project?id='.$project['id'], array('confirm' => __('Do you really want to delete this project?'))) ?>
                <?php endif; ?>
                </td>
                
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>
    </div>
  </div>
</div>
