<?php foreach($recent_activities as $day => $activities):?>
<div class="span-17 recent last">
  <div class="span-17 menu last">
    <div class="colum span-4 append-8"><span class="padding-3"><strong><?php echo format_date($day, 'MMMM dd', $sf_user->getCulture()); ?></strong></span></div>
    <div class="span-5 right last"><span class="padding-3"><strong>Project</strong></span></div>
  </div>
  <?php foreach($activities as $activity):?>
  <div class="span-17 last dashboard-row">
    <div class="span-1"><img src="/images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
    <div class="span-3"><strong><?php echo (is_null($activity->user_name)) ? 'Mr. Unknown' : $activity->user_name; ?></strong></div>
    <div class="span-8"><?php echo $activity->message ?></div>
    <div class="span-5 right last">
      <span class="padding-3">
        <?php echo link_project($activity->getProject()->getName(), $activity->getProject()->getId()); ?>
      </span>
    </div>
  </div>
  <?php endforeach;?>
</div>
<hr />
<?php endforeach;?>