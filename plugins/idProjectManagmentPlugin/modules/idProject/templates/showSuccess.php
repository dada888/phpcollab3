<?php slot('title', __('Project details')) ?>


<div class="block" id="block-tables">
  <?php include_partial('create_project_menu', array('action' => 'show', 'project' => $project)); ?>

  <div class="content">
    <h2 class="title"><?php echo __('Project details') ?></h2>
    <div class="inner">
        <table class="table">
          <tr>
            <th class="first"><?php echo __('Id') ?></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Description') ?></th>
            <th><?php echo __('Public/Private') ?></th>
            <th><?php echo __('Created at') ?></th>
            <th><?php echo __('Updated at') ?></th>
            <th class="last">
            <?php if ($sf_user->isAdmin()): ?>
              <?php echo __('Actions') ?>
            <?php endif; ?>
            </th>
          </tr>
          <tr class="odd">
            <td><?php echo $project->getid() ?></a></td>
            <td><?php echo $project->getname() ?></td>
            <td><?php echo $project->getdescription() ?></td>
            <td><?php echo $project->getis_public() ? __('Public') : __('Private'); ?></td>
            <td><?php echo $project->getcreated_at() ?></td>
            <td><?php echo $project->getupdated_at() ?></td>
            <td>
            <?php if ($sf_user->isAdmin()): ?>
              <?php echo link_to(__('Edit'), '@edit_project?id='.$project['id']).' | '.link_to(__('Delete'), '@delete_project?id='.$project['id'], array('confirm' => __('Do you really want to delete this project?'))) ?>
            <?php endif; ?>
            </td>
          </tr>
        </table>
    </div>
  </div>
</div>

<div class="block" id="users-table">
  <div class="content">
    <h2 class="title"><?php echo __('Users of this project') ?></h2>
    <div class="inner">
        <table class="table">
          <tr>
            <th class="first"><?php echo __('Id') ?></th>
            <th><?php echo __('Username') ?></th>
            <th><?php echo __('First name') ?></th>
            <th><?php echo __('Last name') ?></th>
            <th><?php echo __('Email') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <?php if (count($project->users) !== false && count($project->users) == 0): ?>
            <tr class="odd">
              <td>&nbsp;</th>
              <td colspan="4"><?php echo __('No users') ?></td>
              <td>&nbsp;</th>
            </tr>
          <?php else: ?>
            <?php foreach ($project->users as $user): ?>
              <tr class="odd">
                <td><a href="<?php echo url_for('@sf_guard_user_show?id='.$user->getId()) ?>"><?php echo $user->getid() ?></a></td>
                <td><?php echo $user->getUser()->username ?></td>
                <td><?php echo $user->getFirstName() ?></td>
                <td><?php echo $user->getLastName() ?></td>
                <td><?php echo $user->getEmail() ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>
    </div>
  </div>
</div>

<div class="block" id="milestone-table">
  <div class="content">
    <h2 class="title"><?php echo __('Milestones') ?></h2>
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

          <?php if (count($milestones) !== false && count($milestones) == 0): ?>
            <tr class="odd">
              <td>&nbsp;</th>
              <td colspan="4"><?php echo __('No milestone') ?></td>
              <td>&nbsp;</th>
            </tr>
          <?php else: ?>
            <?php foreach ($milestones as $milestone): ?>
              <tr class="odd">
                <td>&nbsp;</td>
                <td><?php echo link_to($milestone->getTitle(), '@show_milestone?project_id='.$project->getId().'&milestone_id='.$milestone->getId()) ?></td>
                <td><?php echo $milestone->getDescription() ?></td>
                <td><?php echo $milestone->getStartingDate() ?></td>
                <td><?php echo $milestone->getEndingDate() ?></td>
                <td><?php echo link_to(__('Edit'), '@edit_milestone?project_id='.$project->getId().'&milestone_id='.$milestone->getId()) ?> | <?php echo link_to(__('Delete'), '@delete_milestone?project_id='.$project->getId().'&milestone_id='.$milestone->getId(), array('confirm' => __('Do you really want to delete this milestone?'))) ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>
    </div>
  </div>
</div>