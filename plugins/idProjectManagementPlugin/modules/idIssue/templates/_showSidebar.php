<div class="span-8 prepend-1 last" id="sidebar">
  <?php if(count($issue->issues) > 0): ?>
    <div class="title"><span>Related issues</span></div>
    <?php foreach($issue->issues as $related_isue):?>
    <div class="span-2">
      <?php echo link_to('#'.$related_isue->id, '@show_issue?project_id='.$issue->project_id.'&issue_id='.$related_isue->getId())?>
    </div>
    <div class="span-6 last">
      <?php echo $related_isue->getTitle() ?>
    </div>
    <?php endforeach; ?>
    <div class="clear"></div>
  <?php endif; ?>
  <?php $milestone = $issue->getMilestone();
    if($milestone): ?>
    <div class="title"><span>Milestone</span></div>
    <?php include_partial('idDashboard/milestone_boxes', array('milestones' => array($milestone), 'color' => null, 'label' => null, 'days_message' => '%d days')); ?>
  <?php endif; ?>
</div>
