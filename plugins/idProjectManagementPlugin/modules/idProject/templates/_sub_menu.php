<div class="span-full last project-navigation">
  <ul>
    <li><span><?php echo link_to($project->name, '@show_project?id='.$project->id); ?></span></li>
    <li><?php echo link_to( __('Issues'), '@index_issue?project_id='.$project->id) ?></li>
    <li><?php echo link_to(__('Milestones'), '@index_milestone?project_id='.$project->id) ?></li>
    <li><?php echo link_to( __('Discussions'), '@index_messages?project_id='.$project->id) ?></li>
    <li><?php echo link_to(__('Time report'), '@log_time_report_project_all_users?project_id='.$project->id); ?></li>
    <li><?php echo link_to(__('Staff'), '@project_staff_list?id='.$project->id) ?></li>
    <li><a href="#">Settings</a></li>
  </ul>
</div>
