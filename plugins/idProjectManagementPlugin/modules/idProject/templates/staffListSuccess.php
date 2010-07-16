<?php slot('title', __('Staff')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project)); ?>

  <div class="span-full">
    <div class="title">
      <span><?php echo __('Staff'); ?></span>
      <a id="add"class="button block-green medium-round" href="#">Edit</a>
    </div>

    <div id="add-form" >
      <?php include_partial('idProject/staff_form', array('form' => $form)); ?>
    </div>

    <div class="menu">
      <div class="span-7">Name</div>
      <div class="span-8">Email</div>
      <div class="span-7 last">Project role</div>
    </div>
    <ul class="action">
    <?php foreach ($project->getUsers() as $member):?>
      <li class="icon-group">
        <ul>
          <li class="span-7">
            <?php echo $member->getShortName() ?>
          </li>
          <li class="span-8">
            <?php echo mail_to($member->email) ?>
          </li>
          <li class="span-7 last">
            <?php echo $member->getRoleByProject($project->id)?>
          </li>
        </ul>
    <?php endforeach; ?>
    </ul>
  </div>
</div>