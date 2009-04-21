<?php slot('title', __('Project Details')) ?>


<div class="block" id="block-tables">
  <?php include_partial('create_project_menu', array('action' => 'show')); ?>

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
            <th class="last"><?php echo __('Actions') ?></th>
          </tr>
          <tr class="odd">
            <td><?php echo $project->getid() ?></a></td>
            <td><?php echo $project->getname() ?></td>
            <td><?php echo $project->getdescription() ?></td>
            <td><?php echo $project->getis_public() ? __('Public') : __('Private'); ?></td>
            <td><?php echo $project->getcreated_at() ?></td>
            <td><?php echo $project->getupdated_at() ?></td>
            <td><?php echo link_to('Edit', '@edit_project?id='.$project['id']) ?> | <?php echo link_to('Delete', '@delete_project?id='.$project['id'], array('confirm' => 'Do you really want to delete this project?')) ?></td>
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
            <th><?php echo __('First Name') ?></th>
            <th><?php echo __('Last Name') ?></th>
            <th><?php echo __('Email') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <?php if (count($users) !== false && count($users) == 0): ?>
            <tr class="odd">
              <td>&nbsp;</th>
              <td colspan="4"><?php echo __('No users') ?></td>
              <td>&nbsp;</th>
            </tr>
          <?php else: ?>
            <?php foreach ($users as $user): ?>
              <tr class="odd">
                <td><a href="<?php echo url_for('@sf_guard_user_edit?id='.$user->getId()) ?>"><?php echo $user->getid() ?></a></td>
                <td><?php echo $user->getUsername() ?></td>
                <td><?php echo $user->Profile->getFirstName() ?></td>
                <td><?php echo $user->Profile->getLastName() ?></td>
                <td><?php echo $user->Profile->getEmail() ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>
    </div>
  </div>
</div>