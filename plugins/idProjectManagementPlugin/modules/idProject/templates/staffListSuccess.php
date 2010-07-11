<?php slot('title', __('Staff')) ?>

<?php include_partial('idProject/sub_menu', array('project' => $project))?>

<div class="span-17 dashboard">
  <h3 class="left">Staff</h3>
  <?php if ($sf_user->canAddUsersToProject()):?>
    <span class="actionsAdd">
      <a href="<?php echo url_for('@edit_project?id='.$project->id)?>">Add Members</a>
    </span>
  <?php endif; ?>
  <hr />
  <div class="span-17 recent last">
    <div class="span-17 menu last">
      <div class="colum span-6"><span class="padding-3"><strong>Project Members</strong></span></div>
      <div class="colum span-7"><span class="padding-3"><strong>email</strong></span></div>
      <div class="span-4 last"><span class="padding-3"><strong>Role</strong></span></div>
    </div>
    <?php foreach ($project->getUsers() as $member):?>
      <div class="span-17 last dashboard-row">
        <div class="span-1">
          <?php echo image_tag('icons/20-group.png', array('width' => "20", 'height' => "20", 'alt' => "Group")) ?>
        </div>
        <div class="span-5">
          <strong><?php echo $member->getShortName() ?></strong>
        </div>
        <div class="colum span-7">
          <span class="padding-3">
            <?php echo mail_to($member->email) ?>
          </span>
        </div>
        <div class="span-4 last"><?php echo $member->getRoleByProject($project->id)?></div>
      </div>
    <?php endforeach; ?>
  </div>
</div>