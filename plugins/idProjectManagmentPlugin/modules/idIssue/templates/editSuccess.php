<?php slot('title', __('Manage Projects')) ?>

<div class="block" id="block-forms">
  <?php include_partial('create_issue_menu', array('project_id'=>$sf_request->getParameter('project_id'))); ?>
  <div class="content">
    <div class="inner">

<?php include_partial('idIssue/form', array('form' => $form, 'project_id' => $sf_request->getParameter('project_id'))) ?>

    </div>
  </div>
</div>