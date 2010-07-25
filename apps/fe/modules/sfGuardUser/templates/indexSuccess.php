<?php slot('title', __('Manage users')) ?>

<?php include_partial('idProject/sf_guard_filters', array(
                                                  'form' => $filters,
                                                  'configuration' => $configuration,
                                                  'module_name' => 'user',
                                                  'fields' => array('username',
                                                                    'groups_list'),
                                                  )); ?>

<div class="span-23" id="content">
  <div class="span-full last project-navigation">
    <ul>
      <li><?php echo link_to('Users', '@sf_guard_user'); ?></li>
      <li><?php echo link_to('Groups', '@sf_guard_group'); ?></li>
      <li><?php echo link_to('Permissions', '@sf_guard_permission'); ?></li>
    </ul>
  </div>

  <div class="span-full">
    <div class="title">
      <span>Users</span>
      <a id="add-user"class="button block-green medium-round" href="<?php echo url_for('@sf_guard_user_new') ?>">Add</a>
    </div>
    <div class="menu">
      <div class="span-5"><?php echo link_to(__('Username'), 'sfGuardUser/index?sort=s.username&sort_type='.('s.username' == $sort[0] && $sort[1] == 'asc' ? 'desc' : 'asc')) ?></div>
      <div class="span-5"><?php echo link_to(__('First Name'), 'sfGuardUser/index?sort=p.first_name&sort_type='.('p.first_name' == $sort[0] && $sort[1] == 'asc' ? 'desc' : 'asc')) ?></div>
      <div class="span-5"><?php echo link_to(__('Last Name'), 'sfGuardUser/index?sort=p.last_name&sort_type='.('p.last_name' == $sort[0] && $sort[1] == 'asc' ? 'desc' : 'asc')) ?></div>
      <div class="span-6 right last append-1">E-mail</div>
    </div>

    <ul class="action">
      <?php if ($pager->getNbResults() > 0): ?>
        <?php foreach ($pager->getResults() as $user): ?>
          <li class="icon-group">
            <ul>
              <li class="span-5"><?php echo link_to($user['username'], 'sf_guard_user_edit', $user) ?>&nbsp;</li>
              <li class="span-5"><?php echo $user->Profile->first_name ?>&nbsp;</li>
              <li class="span-5"><?php echo $user->Profile->last_name ?>&nbsp;</li>
              <li class="span-7 right last append-1"><?php echo $user->Profile->email ?>&nbsp;</li>
              <li class="edit-delete">
                <?php echo link_to(__('Edit'), '@sf_guard_user_edit?id='.$user->getId()) ?>
                <?php echo link_to(__('Delete'), '@sf_guard_user_delete?id='.$user->getId(), array('confirm' => __('Do you really want to delete this user?'))) ?>
              </li>
            </ul>
          </li>
          <?php endforeach; ?>
        <?php else: ?>
        <li>
          <ul>
            <li class="span-3"></li>
            <li class="span-15">No users</li>
            <li class="span-4 right last"></li>
          </ul>
        </li>
        <?php endif; ?>
    </ul>

    <?php if($pager->haveToPaginate()):?>
    <div class="span-full pagenation">
      <ul>
        <?php  echo pager_navigation_log_time($pager, '@collab_settings') ?>
      </ul>
    </div>
    <?php endif; ?>
    
  </div>
</div>