<?php use_helper('Dashboard') ?>

<?php slot('title', __('Dashboard')); ?>

<div class="span-23" id="content">
  <?php include_partial('idDashboard/last_events', array('recent_activities' => $recent_activities ))?>

  <div class="span-full">
    <div class="title"><span>Tickets</span></div>
    <div class="menu">
      <div class="span-3">Name</div>
      <div class="span-15">Description</div>
      <div class="span-4 right last"><span>Project</span></div>
    </div>
    
    <?php if (count($late_issues) > 0 || count($upcoming_issues) > 0): ?>
      <?php include_partial('idDashboard/issues_list', array('issues' => $late_issues))?>
      <?php include_partial('idDashboard/issues_list', array('issues' => $upcoming_issues))?>
    <?php else: ?>
    <ul class="action">
      <li class="icon-green">
        <ul>
          <li class="span-3"></li>
          <li class="span-15">No late or upcoming issues</li>
          <li class="span-4 right last"></li>
        </ul>
      </li>
    </ul>
    <?php endif; ?>
  </div>
</div>