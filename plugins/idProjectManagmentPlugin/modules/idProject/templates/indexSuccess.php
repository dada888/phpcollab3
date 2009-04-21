<?php slot('title', __('Manage Projects')) ?>

<?php include_partial('filters', array('form' => $form)); ?>

<div class="block" id="block-tables">
  <?php include_partial('create_project_menu', array('action' => 'index', 'sf_user' => $sf_user)); ?>
  <div class="content">
    <div class="inner">

        <table class="table">
          <tr>
            <th class="first">Id</th>
            <th>Name</th>
            <th>Description</th>
            <th>Public</th>
            <th class="last">Actions</th>
          </tr>

          <?php if ($project_list->count() !== false && $project_list->count() == 0): ?>
            <tr class="odd"><td colspan="5"><?php echo __('No Results') ?></td></tr>
          <?php else: ?>
            <?php foreach ($project_list as $project): ?>
              <tr class="odd">
                <td><a href="<?php echo url_for('@show_project?id='.$project['id']) ?>"><?php echo $project->getid() ?></a></td>
                <td><?php echo $project->getname() ?></td>
                <td><?php echo $project->getdescription() ?></td>
                <td><?php echo $project->getis_public() ? __('Public') : __('Private'); ?></td>
                <td><?php echo link_to('Edit', '@edit_project?id='.$project['id']) ?> | <?php echo link_to('Delete', '@delete_project?id='.$project['id'], array('confirm' => 'Do you really want to delete this project?')) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>



    </div>
  </div>
</div>
