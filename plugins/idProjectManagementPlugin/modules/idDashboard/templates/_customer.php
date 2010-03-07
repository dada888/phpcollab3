<?php use_helper('Dashboard') ?>
<div id="sidebar-right" class="span-6 push-1 last">
  <h3>Open Projects</h3>
  <hr />
  <?php foreach($sf_user->getMyProjects() as $project): ?>
    <?php $report = $project->getReport(); ?>
    <div class="span-6 menuStatus last">
      <div class="statusTitle <?php echo get_css_class_based_on_project_on_time($project->isOnTime());?>Ball padding-3">
        <?php echo link_to($project->name, '@show_project?id='.$project->id); ?>
      </div>
    </div>
    <div class="span-6 grey-box last">
      <div class="span-6 last">
        <div class="span-1 percent"><?php echo $report['completion_percentage']; ?>%</div>
        <div class="span-5 last progress">
          <div class="progress-<?php echo get_css_class_based_on_project_on_time($project->isOnTime());?>" style="width: <?php echo $report['completion_percentage']; ?>%;"></div>
        </div>
      </div>
      <div class="span-6 last report">
        <div class="span-3">
          <div class="square-<?php echo get_css_class_based_on_project_on_budget($project->isOnBudget());?>">&nbsp;</div>
          <small>On Budget</small></div>
        <div class="span-3 last">
          <div class="square-<?php echo get_css_class_based_on_project_on_time($project->isOnTime());?>">&nbsp;</div>
          <small>On Time</small></div>
      </div>
      <!--div class="span-6 last report">
        <div class="span-3"><span class="padding-3">
          <div class="square-spacer"><img src="/images/icons/16-rss.gif" width="16" height="16" alt="RSS" /></div>
          <a href="#">RSS Feed</a></span></div>
        <div class="span-3 last"><span class="padding-3">
          <div class="square-spacer"><img src="/images/icons/16-cal.png" width="16" height="16" alt="iCal" /></div>
          <a href="#">iCal Feed</a></span></div>
      </div-->
    </div>
  <?php endforeach; ?>
  
  <h3>Milestones</h3>
  <hr />
  <?php if(count($late_milestones) > 0): ?>
    <div class="span-6 last">
      <div class="milestone-red padding-3">
        <strong>Late</strong>
      </div>
    </div>
    <div class="span-6 milestone-thin-red last">
      <?php foreach($late_milestones as $milestone): ?>
        <div class="span-6 last report dashboard-row">
          <div class="span-6 last padding-3">
            <?php echo link_to($milestone->title, '@show_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?>
            for <?php echo link_to($milestone->project->name, '@show_project?id='.$milestone->project_id); ?>
          </div>
          <!--div class="span-6 padding-3">Assigned to <a href="#">Adam P</a></div-->
          <div class="span-6 last red padding-3"><strong><?php echo get_days_of_difference($milestone->ending_date, date('Y-m-d')); ?> days late</strong></div>
        </div>
      <?php endforeach;?>
    </div>
  <?php endif; ?>

  <?php if(count($upcoming_milestones) > 0): ?>
    <div class="span-6 last">
      <div class="milestone-green padding-3">
        <strong>Upcoming</strong>
      </div>
    </div>
    <div class="span-6 milestone-thin-green last">
      <?php foreach($upcoming_milestones as $milestone): ?>
        <div class="span-6 last report dashboard-row">
          <div class="span-6 last  padding-3">
            <?php echo link_to($milestone->title, '@show_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?>
            for <?php echo link_to($milestone->project->name, '@show_project?id='.$milestone->project_id); ?>
          </div>
          <!--div class="span-6 padding-3">Assigned to <a href="#">Simon J</a></div-->
          <div class="span-6 last green padding-3"><strong>Starts in <?php echo get_days_of_difference($milestone->ending_date, date('Y-m-d')); ?> days</strong></div>
        </div>
      <?php endforeach;?>
    </div>
  <?php endif; ?>
</div>