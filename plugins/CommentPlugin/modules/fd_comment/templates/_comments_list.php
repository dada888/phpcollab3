<div id="comments_list">
  <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
    <div class="message warning">
      <p><?php echo __('No Results') ?></p>
    </div>
  <?php else: ?>
    <?php echo include_partial('fd_comment/comments', array('pager' => $pager, 'user_enabled' => $user_enabled)); ?>
  <?php endif; ?>
  <div id="pager_navigation">
    <?php echo ajax_pager_navigation($pager, url_for('@fd_ajax_comment_list'.$url_parameter)); ?>
  </div>
</div>