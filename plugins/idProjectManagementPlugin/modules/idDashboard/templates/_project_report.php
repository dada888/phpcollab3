<?php use_helper('Dashboard') ?>
<h3><?php echo link_project($project_report['project_name'], $project_id); ?></h3>
<div class="span-full box">
  <div class="span-full">
    <div class="span-1 percent"><?php echo $project_report['completion_percentage']; ?>%</div>
    <div class="span-5 last progress">
      <div class="progress-<?php echo get_css_class_based_on_project_on_time($project_report['on_time']);?>" style="width: <?php echo $project_report['completion_percentage']; ?>%;"></div>
      <div class="progress-grey" style="width: <?php echo $project_report['assigned_percentage']; ?>%;"></div>
    </div>
  </div>
  <div class="padding">
    <ul>
      <li class="span-half"><?php echo link_to($project_report['remaining_issues'], '@index_issue?project_id='.$project_id); ?> <small>Tickets Remain</small></li>
      <li class="span-half"><?php echo link_to($project_report['closed_issues'], '@index_issue?project_id='.$project_id); ?> <small>Tickets Closed</small></li>
      <li class="span-half"><?php echo link_to($project_report['messages'], '@index_messages?project_id='.$project_id); ?> <small>Discussions</small></li>
      <?php if (isset($project_report['commits'])): ?>
        <li class="span-half"><a href="#">999</a> <small>Commits</small></li>
      <?php endif; ?>
    </ul>
  </div>
  <?php if (isset($project_report['chart'])): ?>
  <div class="repository">
    <ul class="timeline">
      <?php $max_logged_time = calculate_max_logged_time($project_report['chart']);?>
      <?php foreach($project_report['chart'] as $day => $hours): ?>
        <li> <a href="<?php echo url_for('@index_logtime')?>" title="<?php echo $hours; ?> hours logged on <?php echo format_date($day, 'MMMM dd yyyy', $sf_user->getCulture()) ?>"> <span class="count" style="height: <?php echo calculate_proportion($hours, $max_logged_time); ?>%;">(49)</span> </a> </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>
</div>