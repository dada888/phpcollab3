<?php slot('title', __('Manage log time')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>

    <div class="span-full">
    <div class="title">
      <span>Time</span>
      <a id="add-log-time"class="button block-green medium-round" href="<?php echo url_for('@new_logtime') ?>">Add</a>
    </div>

    <div id="log-time">
      <?php include_partial('idLogtime/form', array('form' => $form)) ?>
    </div>

    <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
      <div class="span-full">
        <p>No results.</p>
      </div>
    <?php else: ?>
    <div class="span-full">
      <div class="menu">
        <div class="span-3">Name</div>
        <div class="span-9">Description</div>
        <div class="span-3">Date</div>
        <div class="span-2">Time</div>
        <div class="span-4 prepend-1 last"><span>Issue/Project</span></div>
      </div>
      <ul class="action time">
        <?php foreach ($pager->getResults() as $log_time): ?>
        <li class="icon-time span-22 last">
          <ul>
            <li class="span-3"><?php echo $log_time->getProfile()->getShortName() ?></li>
            <li class="span-9"><strong>&nbsp;<?php echo $log_time->getComment() ?></strong></li>
            <li class="span-3"><?php echo format_date($log_time->getCreatedAt(), 'MMMM dd yyyy', $sf_user->getCulture()) ?></li>
            <li class="span-2"><?php echo $log_time->getLogTime() ?></li>
            <li class="span-5 last">
              <?php echo link_to($log_time->getIssue(), '@show_issue?project_id='.$log_time->getIssue()->getProjectId().'&issue_id='.$log_time->getIssue()->getId()); ?><br/>
              (<?php echo $log_time->getIssue()->getProject()->getName(); ?> )
            </li>
            <li class="edit-delete">
              <?php if($sf_user->hasCredential('idLogtime-Edit')): ?>
                <?php echo link_to(__('Edit'), '@edit_logtime?id='.$log_time->getId()) ?>&nbsp;&nbsp;
                <?php echo link_to(__('Delete'), '@delete_logtime?id='.$log_time->getId(), array('confirm' => __('Do you really want to delete this log?'))) ?>
              <?php endif; ?>
            </li>
          </ul>
        </li>
        <?php endforeach; ?>
      </ul>
      <div class="clear"></div>
    </div>
    <?php endif; ?>
  </div>
  <?php if($pager->haveToPaginate()): ?>
  <div class="span-full pagenation">
    <ul>
      <?php  echo pager_navigation_log_time($pager, '@index_logtime') ?>
    </ul>
  </div>
  <?php endif; ?>
</div>

