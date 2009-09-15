<?php use_helper('AutoLink') ?>
<?php foreach ($pager->getResults() as $key => $comment): ?>
  <div <?php echo ($key == 0) ? 'class="first"': ''; ?>>
    <h3>
      <?php echo $comment->getTitle(); ?>
    </h3>
    <p style="font-size: 76%;">
      <?php echo ($profile_enabled && $comment->profile_id) ? __('by ').$comment->getProfile() : ''; ?>
      <?php echo __('on').' '.$comment->created_at;?>
    </p>
    <p><?php echo auto_link($comment->getBody()); ?></p>
    <hr/>
  </div>
<?php endforeach; ?>