<?php slot('title', __('Manage project issues')) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_issue_menu', array('project_id' => $sf_request->getParameter('project_id'))); ?>
  <div class="content">
    <div class="inner">

      <?php include_partial('idIssue/issues_list', array('pager' => $pager, 'url' => '@index_issue?project_id='.$sf_request->getParameter('project_id'))) ?>

    </div>
  </div>
</div>

