<?php slot('title', __('Milstone Details')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>

  <div class="span-full description">
    <div class="span-15">
      <div class="title">
        <span><?php echo __('Milestone').' "'.$milestone->getTitle().'"' ?></span>
      </div>
      <p><?php echo $milestone->getDescription() ?></p>
    </div>
    <div class="span-8 last specification">
      <ul>
        <li>
          <strong><?php echo __('Starting date')?></strong>: <?php echo format_date($milestone->getStartingDate(), 'dd MMMM')?>
        </li>
        <li>
          <strong><?php echo __('Ending date')?></strong>: <?php echo format_date($milestone->getEndingDate(), 'dd MMMM')?>
        </li>
        <li>
          <strong><?php echo __('Estimated time')?></strong>: <?php echo $milestone->getEstimatedTime() ?>
        </li>
        <li>
          <strong><?php echo __('Issues estimated time')?></strong>: <?php echo $issues_estimated_time['estimated_time']; ?>
        </li>
        <li class="actions">
          <?php echo link_to(__('Edit'), '@edit_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?>&nbsp;&nbsp;
          <?php echo link_to(__('Delete'), '@delete_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id, array('confirm' => __('Do you really want to delete this milestone?'))) ?>
        </li>
      </ul>
    </div>
  </div>

  <div class="span-full">
    <div class="title">
      <span><?php echo __('Issues'); ?></span>
      <a id="add-log-time"class="button block-green medium-round" href="<?php echo url_for('@new_issue?project_id='.$project->id) ?>">Add</a>
    </div>
    <div class="menu">
      <div class="span-3">Id</div>
      <div class="span-5">Name</div>
      <div class="span-3">Tracker</div>
      <div class="span-3">Status</div>
      <div class="span-3">Priority</div>
      <div class="span-5 last">Assigned To</div>
    </div>
    <ul class="action time">

  <?php if($pager->getNbResults() > 0): ?>
      <?php foreach($pager->getResults() as $issue): ?>
        <li class="icon-<?php echo $issue->isLate()? 'red' : 'green'; ?>">
          <ul>
            <li class="span-3"><?php echo link_to('#'.$issue->id, '@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id) ?></li>
            <li class="span-5"><?php echo $issue->title ?></li>
            <li class="span-3"><?php echo $issue->tracker ?>&nbsp;</li>
            <li class="span-3"><?php echo $issue->status ?>&nbsp;</li>
            <li class="span-3"><?php echo $issue->priority ?>&nbsp;</li>
            <li class="span-5 last">
            <?php if (count($issue->users) > 0): ?>
              <?php foreach ($issue->users as $user): ?>
                <?php echo $user->getShortName(); ?><br/>
              <?php endforeach; ?>
            <?php endif; ?>
            </li>
            <li class="edit-delete">
              <?php echo link_to(__('Edit'), '@edit_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id) ?>&nbsp;&nbsp;
              <?php echo link_to(__('Delete'), '@delete_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id, array('confirm' => __('Do you really want to delete this issue??'))) ?>
            </li>
          </ul>
        </li>
      <?php endforeach; ?>
  <?php else: ?>
        <li class="span-22 last">No results</li>
  <?php endif; ?>
      </ul>
    </div>
    <?php if($pager->haveToPaginate()):?>
    <div class="span-full pagenation">
      <ul>
        <?php  echo pager_navigation_log_time($pager, '@show_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?>
      </ul>
    </div>
    <?php endif; ?>

</div>
