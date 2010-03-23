<?php use_helper('Dashboard') ?>

<?php slot('title', __('Dashboard')); ?>

<div class="span-17 dashboard">
  <h3>Tickets</h3>
  <hr />

  <?php $late_issues_count = count($late_issues);?>
  <?php if ($late_issues_count > 0): ?>
    <div class="span-17 last">
      <div class="milestone-red padding-3"> <span class="list-title-right append-2">Due</span> <strong>Late</strong> </div>
    </div>
    <div class="span-17 milestone-thin-red last">
      <?php foreach ($late_issues as $key => $issue): ?>
        <?php include_partial('idDashboard/issue', array('issue' => $issue, 'is_last' => (bool)($late_issues_count == $key+1))) ?>
      <?php endforeach;?>
    </div>
  <?php endif;?>

  <?php $upcoming_issues_count = count($upcoming_issues);?>
  <?php if ($upcoming_issues_count > 0): ?>
    <div class="span-17 last">
    <div class="milestone-green padding-3"> <span class="list-title-right append-2">Due</span> <strong> Upcoming/Today</strong> </div>
  </div>
  <div class="span-17 milestone-thin-green last">
      <?php foreach ($upcoming_issues as $key => $issue): ?>
        <?php include_partial('idDashboard/issue', array('issue' => $issue, 'is_last' => (bool)($upcoming_issues_count == $key+1))) ?>
      <?php endforeach;?>
    </div>
  <?php endif;?>

  <?php include_partial('idDashboard/last_events', array('recent_activities' => $recent_activities ))?>
</div>
