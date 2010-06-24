<?php use_helper('Dashboard') ?>
<?php $report = $project->getReport(); ?>

<div class="span-full <?php echo $class_line; ?>">
    <h3><?php echo link_to($project->name, '@show_project?id='.$project->id); ?>
      <!--span> for <a href="#">Adam Company</a></span-->
    </h3>
  <div class="span-one-quarter">Status:<br>
    <h3><?php echo $report['completion_percentage']; ?>%<span>Completed</span></h3>
  </div>
  <div class="span-one-quarter">Assigned to me
    <h3>
      <a href="<?php echo url_for('@index_issue?project_id='.$project->id) ?>"><?php echo $sf_user->retrieveNumberOfMyOpenIssueByProject($project->id); ?><span>Open</span></a>
      <a href="<?php echo url_for('@index_issue?project_id='.$project->id) ?>"><?php echo $sf_user->retrieveMyClosedIssueByProject($project->id); ?><span>Closed</span></a>
    </h3>
  </div>
  <div class="span-one-quarter">Total
    <h3>
      <a href="<?php echo url_for('@index_issue?project_id='.$project->id) ?>"><?php echo $report['remaining_issues'] ?><span>Open</span></a>
      <a href="<?php echo url_for('@index_issue?project_id='.$project->id) ?>"><?php echo $report['closed_issues'] ?><span>Closed</span></a>
    </h3>
  </div>
  <div class="span-one-quarter">
    <div class="square-<?php echo get_css_class_based_on_project_on_time($report['on_time']) ?>">On Time</div>
    <!--div class="square-<?php echo get_css_class_based_on_project_on_budget($project->isOnBudget()) ?>">On Budget</div-->
  </div>
  <!--div class="right"><a class="button block-gray medium-round" href="#">Create a Task</a></div-->
</div>
