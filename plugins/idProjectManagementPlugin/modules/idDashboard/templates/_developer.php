<div id="sidebar-right" class="span-6 push-1 last">
  <h3>Open Projects</h3>
  <hr />

  <?php if (count($latest_projects_reports) > 0): ?>
    <?php foreach($latest_projects_reports as $project_id => $project_report):?>
      <?php include_partial('idDashboard/project_report', array('project_id' => $project_id, 'project_report' => $project_report)) ?>
    <?php endforeach;?>
  <?php endif; ?>

  <h3>Milestones</h3>
  <hr />
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $late_milestones, 'color' => 'red', 'label' => 'Late', 'days_message' => '%d days late'))?>
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $upcoming_milestones, 'color' => 'green', 'label' => 'Upcoming', 'days_message' => 'Starts in %d days'))?>
</div>