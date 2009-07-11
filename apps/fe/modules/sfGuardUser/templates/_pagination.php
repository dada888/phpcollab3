  <a href="<?php echo url_for('@sf_guard_user') ?>?page=1"><?php echo __('First') ?></a>
  <a href="<?php echo url_for('@sf_guard_user') ?>?page=<?php echo $pager->getPreviousPage() ?>"><?php echo __('Prev') ?></a>

  <?php foreach ($pager->getLinks() as $page): ?>
    <?php if ($page == $pager->getPage()): ?>
      <span><?php echo $page ?></span>
    <?php else: ?>
      <a href="<?php echo url_for('@sf_guard_user') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
    <?php endif; ?>
  <?php endforeach; ?>

  <a href="<?php echo url_for('@sf_guard_user') ?>?page=<?php echo $pager->getNextPage() ?>"><?php echo __('Next') ?></a>

  <a href="<?php echo url_for('@sf_guard_user') ?>?page=<?php echo $pager->getLastPage() ?>"><?php echo __('Last') ?></a>
