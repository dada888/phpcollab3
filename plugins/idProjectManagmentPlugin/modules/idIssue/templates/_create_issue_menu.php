<div class="secondary-navigation">
  <ul>
    <li class="first active"><?php echo link_to( __('Create new issue'), '@new_issue?project_id='.$project_id) ?></li>
    <li><?php echo link_to( __('Issues list'), '@index_issue?project_id='.$project_id) ?></li>
    <li><?php echo link_to( __('Go back to the project dashboard'), '@show_project?id='.$project_id) ?></li>
  </ul>
  <div class="clear"></div>
</div>
