<div class="message" id="comments_list">
  <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
    <div class="message warning">
      <p><?php echo __('No Results') ?></p>
    </div>
  <?php else: ?>
    <?php echo include_partial('fd_comment/comments', array('pager' => $pager, 'profile_enabled' => $profile_enabled)); ?>
  <?php endif; ?>
  <div class="navigation">
    <?php echo pager_navigation($pager, url_for($module.'/'.$action.$parameters)) ?>
  </div>
</div>