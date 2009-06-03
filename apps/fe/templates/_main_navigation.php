<ul>
<li class="first active"><?php echo link_to(__('Home'), '@homepage') ?></li>
<?php if ($sf_guard_user->isAuthenticated()): ?>
  <li><?php echo link_to(__('Repository'), '@show_revisions') ?></li>
  
  <li><?php echo link_to(__($sf_guard_user->isAdmin() ? 'All Projects' : 'My Projects'), '@index_project') ?></li>


  <?php if ($sf_guard_user->isAdmin()): ?>
    <?php include_partial('global/admin_navigation') ?>
  <?php endif;?>


<?php endif;?>
</ul>