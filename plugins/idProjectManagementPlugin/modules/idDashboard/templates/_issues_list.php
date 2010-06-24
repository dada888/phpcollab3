<?php use_helper('Dashboard') ?>

<?php if(isset($issues) && count($issues) > 0): ?>
<ul class="action">
  <?php foreach ($issues as $key => $issue): ?>
  <li class="icon-<?php echo get_color_for_issue($issue); ?>">
    <ul>
      <li class="span-3"><?php echo link_to($issue->title, '@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->id); ?></li>
      <li class="span-15"><?php echo $issue->description; ?></li>
      <li class="span-4 right last">
        <div><?php echo link_project($issue->getProject()->getName(), $issue->getProject()->getId(), 'project-name'); ?></div>
      </li>
    </ul>
  </li>
  <?php endforeach;?>
</ul>
<?php endif;?>