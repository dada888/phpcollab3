<ul>
<li class="first active"><?php echo link_to(__('Home'), '@homepage') ?></li>
<?php if ($sf_guard_user->isAuthenticated()): ?>
  <li><?php echo link_to(__('Projects'), '@index_project') ?></li>
  <li><?php echo link_to(__('Repository'), '@show_revisions') ?></li>
  <?php if ($sf_guard_user->isAdmin()): ?>
    <li><?php echo link_to(__('Users'), '@sf_guard_user') ?></li>
    <li><?php echo link_to(__('Groups'), '@sf_guard_group') ?></li>
    <li><?php echo link_to(__('Permissions'), '@sf_guard_permission') ?></li>
    <li><?php echo link_to(__('Priorities'), '@index_priority') ?></li>
    <li><?php echo link_to(__('Statuses'), '@index_status') ?></li>
  <?php endif;?>
<?php endif;?>
</ul>