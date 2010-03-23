<?php use_helper('Dashboard') ?>
<?php $report = $project->getReport(); ?>
<div class="span-17 menuStatus last">
  <div class="span-11">
    <div class="statusTitle <?php echo get_css_class_based_on_project_on_time($project->isOnTime());?>Ball padding-3">
      <?php echo link_to($project->name, '@show_project?id='.$project->id); ?>
    </div>
  </div>
  <div class="span-6 last">
    <div class="span-1 percent"><?php echo $report['completion_percentage']; ?>%</div>
    <div class="span-5 last progress">
      <div class="progress-green" style="width: <?php echo $report['completion_percentage']; ?>%;"></div>
    </div>
  </div>
</div>

<div class="span-17 last">
  <div class="span-17 last report dashboard-row">
    <div class="span-5 append-1">
      <div class="square-<?php echo get_css_class_based_on_project_on_time($project->isOnTime());?>">&nbsp;</div>
      On Time
    </div>
    <div class="span-5 append-1">
      <span class="padding-3">
        <a href="<?php echo url_for('@index_issue?project_id='.$project->id) ?>"><?php echo $report['remaining_issues'] ?> <small>Tickets Remain</small></a>
      </span>
    </div>
    <div class="span-5 last">
      <span class="padding-3">
        <a href="<?php echo url_for('@index_issue?project_id='.$project->id) ?>"><?php echo $report['closed_issues'] ?> <small>Tickets Closed</small></a>
      </span>
    </div>
  </div>
  <div class="span-17 last report dashboard-row last-row">
    <div class="span-5 append-1">
      <?php if ($sf_user->canSeeBudget()): ?>
        <div class="square-<?php echo get_css_class_based_on_project_on_budget($project->isOnBudget());?>">&nbsp;</div>
        On Budget
      <?php else: ?>
        &nbsp;
      <?php endif; ?>
    </div>
    <div class="span-5 append-1">
      <span class="padding-3">
        <a href="<?php echo url_for('@index_messages?project_id='.$project->id) ?>"><?php echo $report['messages'] ?> <small>Discussions</small></a>
      </span>
    </div>
    <div class="span-5 last">
      <span class="padding-3">
        <a href="project-repo.html">258 <small>Commits</small></a>
      </span>
    </div>
  </div>
</div>