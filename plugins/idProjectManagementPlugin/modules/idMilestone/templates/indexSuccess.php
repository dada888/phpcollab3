<?php slot('title', __('Manage milestones')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>

  <div class="span-full">
    <div class="title">
      <span><?php echo __('Milestones'); ?></span>
      <a id="add-log-time"class="button block-green medium-round" href="<?php echo url_for('@new_milestone?project_id='.$project->id) ?>">Add</a>
    </div>
    <div class="menu">
      <div class="span-4">Id</div>
      <div class="span-5">Name</div>
      <div class="span-4">Starting date</div>
      <div class="span-4">Ending date</div>
      <div class="span-5 last">Assigned To</div>
    </div>
    <ul class="action time">

  <?php if($pager->getNbResults() > 0): ?>
      <?php foreach($pager->getResults() as $milestone): ?>
        <li class="icon-<?php echo $milestone->isLate()? 'red' : 'green'; ?>">
          <ul>
            <li class="span-4"><?php echo link_to('#'.$milestone->id, '@show_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?></li>
            <li class="span-5"><?php echo link_to($milestone->title, '@show_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?></li>
            <li class="span-4"><?php echo format_date($milestone->starting_date, 'dd MMMM', $sf_user->getCulture()) ?>&nbsp;</li>
            <li class="span-4"><?php echo format_date($milestone->ending_date, 'dd MMMM', $sf_user->getCulture()) ?>&nbsp;</li>
            <li class="span-5 last"><?php echo !is_null($milestone->InCharge) ? short_name($milestone->InCharge) : 'Not defined'; ?>&nbsp;</li>
            <li class="edit-delete">
              <?php echo link_to(__('Edit'), '@edit_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?>&nbsp;&nbsp;
              <?php echo link_to(__('Delete'), '@delete_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id, array('confirm' => __('Do you really want to delete this milestone??'))) ?>
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
        <?php  echo pager_navigation_log_time($pager, '@index_issue?project_id='.$milestone->project_id) ?>
      </ul>
    </div>
    <?php endif; ?>
</div>


