<?php use_helper('AutoLink') ?>

<?php if (!empty($global_errors)): ?>
  <div class="flash">
    <div class="message error">
      <p><?php echo $global_errors ?></p>
    </div>
  </div>
<?php endif; ?>

<?php if (!empty($body_errors)): ?>
  <div class="flash">
    <div class="message error">
      <p><?php echo $body_errors ?></p>
    </div>
  </div>
<?php endif; ?>

<?php if ($issue->hasComments()) : ?>
  <h3>Comments:</h3>
  <ul>
  <?php foreach ($issue->getComments() as $id => $comment) : ?>
    <li>
      <p>
        <em>
          <?php echo __('Comment number : ').($id+1) ?> - <?php echo sprintf('Comment by %s on %s', $comment->getUserProfile()->getUser(), $comment->getCreatedAt()) ?>
        </em>
        <br/>
        <?php echo auto_link($comment->getBody()); ?>
      </p>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p><?php echo __('No comment') ?></p>
<?php endif; ?>