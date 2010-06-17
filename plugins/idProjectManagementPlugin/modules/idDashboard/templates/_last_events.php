<?php use_helper('Dashboard') ?>

<?php if (count($recent_activities) > 0): ?>
  <div class="span-full">
    <div class="title"><span>Recent Activity</span></div>
    <div class="menu">
      <div class="span-3">Name</div>
      <div class="span-15">Description</div>
      <div class="span-4 right last"><span>Project</span></div>
    </div>
    <ul class="action">
    <?php foreach($recent_activities as $day => $activities): ?>
      <?php foreach($activities as $activity):?>
      <li class="icon-<?php echo $activity->action ?>">
        <ul>
          <li class="span-3"><?php echo (is_null($activity->user_name)) ? 'Mr. Unknown' : $activity->user_name; ?></li>
          <li class="span-15">On <?php echo format_date($day, 'MMMM dd', $sf_user->getCulture()); ?>
                              <?php echo $activity->message ?>
          <li class="span-4 right last">
            <div><?php echo link_project($activity->getProject()->getName(), $activity->getProject()->getId(), 'project-name'); ?></div>
          </li>
        </ul>
      </li>
      <?php endforeach; ?>
    <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>