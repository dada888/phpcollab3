<?php use_helper('Dashboard') ?>

<div id="sidebar-right" class="span-6 push-1 last">
  <h3>Open Projects</h3>
  <hr />
  <?php if (count($latest_projects_reports) > 0): ?>
    <?php foreach($latest_projects_reports as $project_id => $project_report):?>
      <div class="span-6 menuStatus last">
        <div class="statusTitle <?php echo get_cass_class_based_on_project_on_time($project_report['on_time']);?>Ball padding-3">
          <?php echo link_project($project_report['project_name'], $project_id); ?>
        </div>
      </div>

      <div class="span-6 grey-box last">
        <div class="span-6 last">
          <div class="span-1 percent"><?php echo $project_report['completion_percentage']; ?>%</div>
          <div class="span-5 last progress">
            <div class="progress-<?php echo get_cass_class_based_on_project_on_time($project_report['on_time']);?>" style="width: <?php echo $project_report['completion_percentage']; ?>%;"></div>
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
      </div>
    <?php endforeach;?>
  <?php endif; ?>
  <?php echo link_to(__('See all'), '@index_project') ?>
</div>