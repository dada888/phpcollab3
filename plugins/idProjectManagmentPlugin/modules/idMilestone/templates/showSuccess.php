<?php slot('title', __('Milstone Details')) ?>


<div class="block" id="milestone-table">
  <?php include_partial('create_milestone_menu', array('project' => $project)); ?>
  <div class="content">
    <h2 class="title"><?php echo __('Milestone').' "'.$milestone->getTitle().'"' ?></h2>
    <div class="inner">
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


          <tr class="odd">
            <td>&nbsp;</td>
            <td><?php echo $milestone->getTitle() ?></td>
            <td><?php echo $milestone->getDescription() ?></td>
            <td><?php echo $milestone->getStartingDate() ?></td>
            <td><?php echo $milestone->getEndingDate() ?></td>
            <td><?php echo link_to(__('Edit'), '@edit_milestone?project_id='.$project->getId().'&milestone_id='.$milestone->getId()) ?> | <?php echo link_to(__('Delete'), '@delete_milestone?project_id='.$project->getId().'&milestone_id='.$milestone->getId(), array('confirm' => __('Do you really want to delete this milestone?'))) ?></td>
            <td>&nbsp;</td>
          </tr>

        </table>
    </div>
  </div>
</div>


<div class="block" id="milestone-issues-table">
  <div class="content">
    <div class="inner">

      <?php include_partial('idIssue/issues_list', array('pager' => $pager, 'url' => '@show_milestone?project_id='.$sf_request->getParameter('project_id').'&milestone_id='.$sf_request->getParameter('milestone_id'))) ?>

    </div>
  </div>
</div>