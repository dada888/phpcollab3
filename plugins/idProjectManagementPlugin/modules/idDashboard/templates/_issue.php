<div class="span-17 last report_issue dashboard-row<?php echo ($is_last) ? '-last': ''; ?>">
  <div class="span-14">
    <div class="issue-type"><?php echo link_to('#'.$issue->getId(), '@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId()) ?></div>
    <p><?php echo $issue->title ?> <?php echo link_to($issue->getProject()->getName(), '@show_project?id='.$issue->project_id) ?></p>
  </div>
  <div class="span-2 list-date"><?php echo format_date($issue->ending_date, 'MMMM dd', $sf_user->getCulture()); ?></div>
  <!--div class="span-1 last flag-green"> &nbsp; </div-->
</div>