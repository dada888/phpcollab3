<div id="sidebar-right" class="span-6 push-1 last">
  <?php if (isset($project_report)): ?>
    <h3>Project status</h3>
    <hr />
    <?php include_partial('idDashboard/project_report', array('project_id' => $project->id, 'project_report' => $project_report)) ?>
  <?php endif; ?>

  <?php if(count($project->users) > 0): ?>
    <h3>People Involved</h3>
    <hr />
    <div class="span-6 last">
      <?php foreach ($project->users as $member): ?>
        <div class="span-6 last dashboard-row">
          <div class="span-3"><?php echo $member->getFirstName().' '.$member->getLastName() ?></div>
          <div class="span-3 last"><strong><?php /*echo $member->getRoleByProject($project->id);*/ ?></strong></div>
        </div>
      <?php endforeach; ?>

      
      <div class="span-6 last dashboard-row">
        <div class="span-3"><a href="#">James Smith</a></div>
        <div class="span-3 last"><strong>Developer</strong></div>
      </div>
      <div class="span-6 last dashboard-row">
        <div class="span-3"><a href="#">Tim Morison</a></div>
        <div class="span-3 last"><strong>Designer</strong></div>
      </div>
    </div>
  <?php endif; ?>
</div>