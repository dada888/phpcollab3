<?php use_helper('Dashboard') ?>

<?php slot('title', __('Dashboard')); ?>

<div class="span-23" id="content">

  <?php include_partial('idDashboard/last_events', array('recent_activities' => $recent_activities ))?>


<?php if (isset($late_issues) || isset($upcoming_issues)): ?>
  <div class="span-full">
    <div class="title"><span>Tickets</span></div>
    <div class="menu">
      <div class="span-3">Name</div>
      <div class="span-15">Description</div>
      <div class="span-4 right last"><span>Project</span></div>
    </div>
    <ul class="action">
  <?php if (count($late_issues) > 0 || count($upcoming_issues) > 0): ?>
    <?php if (count($late_issues) > 0): ?>
      <?php foreach ($late_issues as $key => $issue): ?>
        <li class="icon-red">
        <ul>
          <li class="span-3"><?php echo link_to($issue->title, '@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id); ?></li>
          <li class="span-15"><?php echo $issue->description; ?></li>
          <li class="span-4 right last">
            <div><?php echo link_project($issue->getProject()->getName(), $issue->getProject()->getId(), 'project-name'); ?></div>
          </li>
        </ul>
      </li>
      <?php endforeach;?>
    <?php endif;?>

    <?php if (count($upcoming_issues) > 0): ?>
      <?php foreach ($upcoming_issues as $key => $issue): ?>
        <li class="icon-green">
        <ul>
          <li class="span-3"><?php echo link_to($issue->title, '@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id); ?></li>
          <li class="span-15"><?php echo $issue->description; ?></li>
          <li class="span-4 right last">
            <div><?php echo link_project($issue->getProject()->getName(), $issue->getProject()->getId(), 'project-name'); ?></div>
          </li>
        </ul>
      </li>
      <?php endforeach;?>
    <?php endif;?>
    
  <?php else: ?>
      <li class="icon-green">
        <ul>
          <li class="span-3"></li>
          <li class="span-15">No late or upcoming issues</li>
          <li class="span-4 right last"></li>
        </ul>
      </li>
  <?php endif; ?>
    </ul>
  </div>
<?php endif; ?>
</div>