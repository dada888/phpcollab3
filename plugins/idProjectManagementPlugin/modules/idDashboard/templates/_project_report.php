<div class="span-6 menuStatus last">
  <div class="statusTitle <?php echo get_css_class_based_on_project_on_time($project_report['on_time']);?>Ball padding-3">
    <?php echo link_project($project_report['project_name'], $project_id); ?>
  </div>
</div>

<div class="span-6 grey-box last">
  <div class="span-6 last">
    <div class="span-1 percent"><?php echo $project_report['completion_percentage']; ?>%</div>
    <div class="span-5 last progress">
      <div class="progress-<?php echo get_css_class_based_on_project_on_time($project_report['on_time']);?>" style="width: <?php echo $project_report['completion_percentage']; ?>%;"></div>
      <div class="progress-grey" style="width: <?php echo $project_report['assigned_percentage']; ?>%;"></div>
    </div>
  </div>
  <div class="span-6 last report">
    <div class="span-3">
      <span class="padding-3">
        <?php echo link_to($project_report['remaining_issues'], '@index_issue?project_id='.$project_id); ?>
        <small>Tickets Remain</small>
      </span>
    </div>
    <div class="span-3 last">
      <span class="padding-3">
        <?php echo link_to($project_report['closed_issues'], '@index_issue?project_id='.$project_id); ?>
        <small>Tickets Closed</small>
      </span>
    </div>
  </div>
  <div class="span-6 last report">
    <div class="span-3">
      <span class="padding-3">
        <?php echo link_to($project_report['messages'], '@index_messages?project_id='.$project_id); ?>
        <small>Discussions</small>
      </span>
    </div>
    <div class="span-3 last">
      <span class="padding-3">
        <a href="#">999</a>
        <small>Commits</small>
      </span>
    </div>
  </div>

  <?php if (isset($project_report['chart'])): ?>
    <div class="span-6 last report">
      <ul style="float: left;" class="timeline">
        <?php $max_logged_time = calculate_max_logged_time($project_report['chart']);?>
        <?php foreach($project_report['chart'] as $day => $hours): ?>
        <li> <a href="<?php echo url_for('@index_logtime')?>" title="<?php echo $hours; ?> hours logged on <?php echo format_date($day, 'MMMM dd yyyy', $sf_user->getCulture()) ?>"> <span class="count" style="height: <?php echo calculate_proportion($hours, $max_logged_time); ?>%;">(49)</span> </a> </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
</div>