<div class="secondary-navigation">
  <ul>
    <?php if($sf_user->isAdmin()): ?>
      <li class="first active"><?php echo link_to( __('Create new project'), '@new_project') ?></li>
      <?php if($action == 'show'): ?>
        <li><?php echo link_to( __('Add user(s)'), '@edit_project?id='.$sf_request->getParameter('id')) ?></li>
      <?php endif; ?>
    <?php else: ?>
      <li class="first active"><?php echo link_to( __('My projects'), '@index_project') ?></li>
    <?php endif; ?>

    <?php if ($sf_request->hasParameter('id')): ?>

      <?php if (!is_null($project) && $project->hasRoadmap()):?>
        <li><?php echo link_to('Roadmap', '@roadmap_project?id='.$sf_request->getParameter('id')); ?></li>
      <?php endif;?>

      <li><?php echo link_to(__('Create milestone'), '@new_milestone?project_id='.$sf_request->getParameter('id')) ?></li>
      <li><?php echo link_to(__('Create issue'), '@new_issue?project_id='.$sf_request->getParameter('id')) ?></li>
      <li><?php echo link_to( __('View all issues'), '@index_issue?project_id='.$sf_request->getParameter('id')) ?></li>
      <li><?php echo link_to( __('View all milestones'), '@index_milestone?project_id='.$sf_request->getParameter('id')) ?></li>
      <li><?php echo link_to( __('Messages'), '@index_messages?project_id='.$sf_request->getParameter('id')) ?></li>
    <?php endif; ?>
  </ul>
  <div class="clear"></div>
</div>
