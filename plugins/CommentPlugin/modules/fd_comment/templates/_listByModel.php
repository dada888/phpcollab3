<div id="comments-list">
  <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
    <div class="message warning">
      <p><?php echo __('No Results') ?></p>
    </div>
  <?php else: ?>
    <?php echo include_partial('fd_comment/comments', array('pager' => $pager, 'user_enabled' => $user_enabled)); ?>
  <?php endif; ?>
  <?php if($pager->haveToPaginate()): ?>
  <div class="pagenation">
    <ul>
      <?php echo pager_navigation_log_time($pager, url_for($module.'/'.$action.$parameters)) ?>
    </ul>
  </div>
  <?php endif; ?>
</div>