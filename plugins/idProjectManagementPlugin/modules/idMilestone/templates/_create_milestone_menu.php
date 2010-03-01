<div class="secondary-navigation">
  <ul>
    <li class="first active"><?php echo link_to( __('Create a new milestone'), '@new_milestone?project_id='.$project->getId()) ?></li>
    <li><?php echo link_to( __('View all project milestones'), '@index_milestone?project_id='.$project->getId()) ?></li>
    <li><?php echo link_to( __('Go back to the project dashboard'), '@show_project?id='.$project->getId()) ?></li>
  </ul>
  <div class="clear"></div>
</div>
