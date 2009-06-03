<?php slot('title', __('Manage milestones')) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_milestone_menu', array('project' => $project)); ?>
  <div class="content">
    <div class="inner">
      <h2 class="title"><?php echo __('Milestones list') ?></h2>
        <table class="table">

          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Title') ?></th>
            <th><?php echo __('Description') ?></th>
            <th><?php echo __('Starting date') ?></th>
            <th><?php echo __('Ending date') ?></th>
            <th><?php echo __('Actions') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <?php if ($milestone_list->count() !== false && $milestone_list->count() == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="3"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($milestone_list as $milestone): ?>
              <tr class="odd">
                <td>&nbsp;</td>
                <td><?php echo $milestone->gettitle() ?></td>
                <td><?php echo $milestone->getdescription() ?></td>
                <td><?php echo $milestone->getstarting_date() ?></td>
                <td><?php echo $milestone->getending_date() ?></td>
                <td><?php echo link_to(__('Edit'), '@edit_milestone?project_id='.$project->getId().'&milestone_id='.$milestone->getId()) ?> | <?php echo link_to(__('Delete'), '@delete_milestone?project_id='.$project->getId().'&milestone_id='.$milestone->getId(), array('confirm' => __('Do you really want to delete this milestone?'))) ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>



    </div>
  </div>
</div>