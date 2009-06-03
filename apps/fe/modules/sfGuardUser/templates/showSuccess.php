<?php slot('title', __('User\'s Details')) ?>


<div class="block" id="user-table">
  <div class="content">
    <h2 class="title"><?php echo $user ?></h2>
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

          <tr class="odd">
            <td><?php echo $sf_user->isAdmin() ? link_to($user->getid(),'@sf_guard_user_edit?id='.$user->getId()) : $user->getid(); ?></td>
            <td><?php echo $user->getUsername() ?></td>
            <td><?php echo $user->Profile->getFirstName() ?></td>
            <td><?php echo $user->Profile->getLastName() ?></td>
            <td><?php echo $user->Profile->getEmail() ?></td>
            <td>&nbsp;</td>
          </tr>
        </table>
    </div>
  </div>
</div>