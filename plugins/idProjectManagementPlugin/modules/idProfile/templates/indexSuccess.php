<?php slot('title', __('Edit your profile')) ?>


<div class="block" id="user-table">
  <div class="content">
    <h2 class="title"><?php echo $sf_user ?></h2>
    <div class="inner">
        <table class="table">
          <tr>
            <th class="first"><?php echo __('Username') ?></th>
            <th><?php echo __('First Name') ?></th>
            <th><?php echo __('Last Name') ?></th>
            <th><?php echo __('Email') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <tr class="odd">
            <td><?php echo link_to($sf_user->getGuardUser()->getUsername(), '@edit_profile'); ?></td>
            <td><?php echo $sf_user->getGuardUser()->getFirstName() ?></td>
            <td><?php echo $sf_user->getGuardUser()->getLastName() ?></td>
            <td><?php echo $sf_user->getGuardUser()->getEmailAddress() ?></td>
            <td>&nbsp;</td>
          </tr>
        </table>
    </div>
  </div>
</div>