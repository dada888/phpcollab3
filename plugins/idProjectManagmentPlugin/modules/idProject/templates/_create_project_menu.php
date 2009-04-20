<div class="secondary-navigation">
  <ul>
    <?php if($sf_user->isAdmin()): ?>
      <li class="first active"><?php echo link_to( __('Create new project'), '@new_project') ?></li>
      <?php if($action == 'show'): ?>
        <li><?php echo link_to( __('Add user(s)'), '@edit_project?id='.$sf_request->getParameter('id')) ?></li>
      <?php endif; ?>
      <li><?php echo link_to( __('Projects list'), '@index_project') ?></li>
    <?php else: ?>
      <li class="first active"><?php echo link_to( __('Your projects list'), '@index_project') ?></li>
    <?php endif; ?>

    <?php if ($sf_request->hasParameter('id')): ?>
      <li><?php echo link_to( __('Issues'), '@index_issue?id='.$sf_request->getParameter('id')) ?></li>
    <?php endif; ?>
  </ul>
  <div class="clear"></div>
</div>
