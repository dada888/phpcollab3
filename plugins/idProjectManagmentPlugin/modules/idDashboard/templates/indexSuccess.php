<?php slot('title', __('Dashboard')) ?>

<div class="block" id="my-issues">
  <div class="content">
    <h2 class="title"><?php echo __('My issues') ?></h2>
    <div class="inner">

      <?php include_partial('idIssue/issues_list', array('pager' => $pager, 'url' => '@dashboard')) ?>

    </div>
  </div>
</div>

