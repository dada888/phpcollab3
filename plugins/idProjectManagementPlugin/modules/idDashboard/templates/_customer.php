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
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $late_milestones, 'color' => 'red', 'label' => 'Late', 'days_message' => '%d days late'))?>
  <?php include_partial('idDashboard/milestone_boxes', array('milestones' => $upcoming_milestones, 'color' => 'green', 'label' => 'Upcoming', 'days_message' => 'Starts in %d days'))?>
</div>