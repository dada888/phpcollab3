<?php slot('title', __('Messages for project')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>

  <div class="span-full">
    <div class="title">
      <span><?php echo __('Messages'); ?></span>
      <a id="add-log-time"class="button block-green medium-round" href="<?php echo url_for('@new_message?project_id='.$project->id) ?>">Add</a>
    </div>
    <div class="menu">
      <div class="span-5">Title</div>
      <div class="span-12">Description</div>
      <div class="span-3 last">Last reply</div>
    </div>
    <ul class="action time">
    <?php if($pager->getNbResults() > 0): ?>
      <?php foreach($pager->getResults() as $message): ?>
        <li class="icon-comment">
          <ul>
            <li class="span-5">
              <?php echo link_to($message->getTitle(), '@show_message?project_id='.$message->project_id.'&message_id='.$message->id); ?><br/>
              by <?php echo short_name($message->getSfGuardUser()) ?>
            </li>
            <li class="span-12"><?php echo $message->getBody() ?></li>
            <li class="span-5 last"><?php echo format_date($message->getLastCommentDate(), 'dd MMMM, HH:mm') ?>&nbsp;</li>
            <li class="edit-delete">
              <?php echo link_to(__('Edit'), '@edit_message?project_id='.$message->project_id.'&message_id='.$message->id) ?>&nbsp;&nbsp;
              <?php echo link_to(__('Delete'), '@delete_message?project_id='.$message->project_id.'&message_id='.$message->id, array('confirm' => __('Do you really want to delete this message?'))) ?>
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
        <?php  echo pager_navigation_log_time($pager, '@index_message?project_id='.$issue->project_id) ?>
      </ul>
    </div>
    <?php endif; ?>
</div>


