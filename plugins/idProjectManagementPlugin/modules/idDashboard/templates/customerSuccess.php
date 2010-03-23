<?php use_helper('Dashboard') ?>

<?php slot('title', __('Dashboard')); ?>

<div class="span-17 dashboard">
  <?php include_partial('idDashboard/last_events', array('recent_activities' => $recent_activities ))?>
</div>
