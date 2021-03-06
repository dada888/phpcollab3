<?php slot('title', __('Settings')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>

  <div class="span-full">
    <div class="title">
      <span><?php echo __('Settings'); ?></span>
    </div>
    <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="notice">
      <?php echo $sf_user->getFlash('notice'); ?>
    </div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('error')): ?>
    <div class="error">
      <?php echo $sf_user->getFlash('error'); ?>
    </div>
    <?php endif; ?>
    <div class="tabs">
      <ul class="tabNavigation">
        <li><a href="#overview">Overview</a></li>
        <li><a href="#trackers">Trackers</a></li>
        <!--li><a href="#modules">Modules</a></li-->
        <li><a href="#staff">Staff</a></li>
        <li><a href="#usersroles">Users roles</a></li>
        <!--li><a href="#invoicing">Invoicing</a></li>
        <li><a href="#wiki">Wiki</a></li>
        <li><a href="#repository">Repository</a></li-->
      </ul>
      <div id="overview" class="settings">
        <form action="<?php echo url_for('@edit_project_overview?id='.$form_overview->getObject()->getId()) ?>" method="post" >
          <?php echo $form_overview ?>
          <div class="confirm-box">
            <input id="update-overview" type="submit" value="Save" class="button block-green medium-round"/>
          </div>
        </form>
      </div>
      <div id="trackers" class="settings">
        <form action="<?php echo url_for('@edit_project_trackers?id='.$form_tracker->getObject()->getId()) ?>" method="post" >
          <?php echo $form_tracker ?>
          <div class="confirm-box">
            <input id="update-tracker" type="submit" value="Save" class="button block-green medium-round"/>
          </div>
        </form>
      </div>
      <div id="staff" class="settings">
        <?php include_partial('idProject/staff_form', array('form' => $form_staff,
                                                            'url' => '@edit_project_staff?id='.$project->id)); ?>
      </div>
      <div id="usersroles" class="settings">
        <?php foreach($forms_projectuser as $key => $form_projectuser): ?>
          <form id="project_user_<?php echo $key ?>" class="project-user" action="<?php echo url_for('@update_project_user_role?id='.$project->id.'&user_id='.$form_projectuser->getObject()->getUserId())?>" method="post">
            <div class="span-7" >
              <h4><?php echo $form_projectuser->getObject()->getSfGuardUser()->getUsername();?></h4>
              <?php echo $form_projectuser->getObject()->getSfGuardUser()->getEmailAddress();?>
            </div>
            <div class="span-12" >
              <?php echo $form_projectuser ?>
            </div>
            <div class="span-2 last" >
              <input type="submit" value="Save" class="button block-green medium-round"/>
            </div>
            <div class="clear"></div>
          </form>
          <hr/>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</div>

