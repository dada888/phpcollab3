<div class="span-24 last project-navigation">
  <ul>
    <li class="current"><?php echo link_to($project->name, '@show_project?id='.$project->id) ?></li>
    <li><?php echo link_to( __('Issues'), '@index_issue?project_id='.$sf_request->getParameter('id')) ?></li>
    <li><a href="<?php echo url_for('@index_milestone?project_id='.$project->id) ?>">Milestones</a></li>
    <li><a href="project-todo.html">ToDo</a></li>
    <li><?php echo link_to( __('Discussions'), '@index_messages?project_id='.$project->getid()) ?></li>
    <li><a href="project-notes.html">Notes</a></li>
    <li><a href="project-files.html">Files</a></li>
    <li><a href="project-repo.html">Repository</a></li>
    <li><?php echo link_to(__('Time report'), '@log_time_report_project_all_users?project_id='.$project->getid()); ?></li>
    <li><a href="<?php echo url_for('@project_staff_list?id='.$project->id) ?>">Staff</a></li>
    <li><?php echo link_to( __('Gantt chart'), '@show_gantt?project_id='.$sf_request->getParameter('id')) ?></li>
    <?php if ($sf_user->isAdmin()): ?>
      <li><a href="project-dashboard-admin-edit.html">Settings</a></li>
    <?php endif; ?>
  </ul>
</div>