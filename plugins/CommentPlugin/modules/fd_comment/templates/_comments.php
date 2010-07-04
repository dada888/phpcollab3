<?php use_helper('AutoLink') ?>
<ul>
<?php foreach ($pager->getResults() as $key => $comment): ?>
  <li>
    <h4><?php echo $comment->getTitle(); ?></h4>
    <p style="font-size: 76%;">
      <?php echo ($profile_enabled && $comment->profile_id) ? __('by ').$comment->getProfile() : ''; ?>
      <?php echo __('on').' '.$comment->created_at;?>
    </p>
    <p><?php echo auto_link($comment->getBody()); ?></p>
  </li>
<?php endforeach; ?>
</ul>
