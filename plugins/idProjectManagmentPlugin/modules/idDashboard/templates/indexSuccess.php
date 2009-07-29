<?php slot('title', __('Dashboard')) ?>

<div class="block" id="my-issues">
  <div class="content">
    <h2 class="title"><?php echo __('My issues') ?></h2>
    <div class="inner">

      <?php include_partial('idIssue/issues_list', array('pager' => $pager, 'url' => '@dashboard')) ?>

    </div>
  </div>
</div>

<div class="block" id="my-issues">
  <div class="content">
    <h2 class="title"><?php echo __('Projects where I have assigned issues') ?></h2>
    <div class="inner">
      <ul class="list">
      <?php foreach ($projects as $project ): ?>
        <li>
          <div class="item">
            <p><?php echo link_to($project['name'],'@show_project?id='.$project['id']); ?></p>
          </div>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
