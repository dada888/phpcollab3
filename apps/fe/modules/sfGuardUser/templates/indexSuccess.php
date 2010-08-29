<?php slot('title', __('Manage users')) ?>

<div class="span-23" id="content">
  <?php include_partial('idProject/sub_menu_settings')?>

  <div id="block-filters" class="span-full">
    <h2 class="title"><?php echo __('User filters') ?></h2>
    <?php if ($filters->hasGlobalErrors()): ?>
      <div class="error">
        <?php echo $filters->renderGlobalErrors() ?>
      </div>
    <?php endif; ?>
    <form action="<?php echo url_for('sf_guard_user_collection', array('action' => 'filter')) ?>" method="post">
      <div class="span-10">
        <?php echo $filters['username']->renderError() ?>
        <?php echo $filters['username']->renderLabel() ?> :
        <?php echo $filters['username'] ?>
      </div>
      <div class="span-10 last prepend-2">
        <?php echo $filters->renderHiddenFields() ?>
        <input type="submit" value="<?php echo __('Filter') ?>"  class="button" />
        <?php echo link_to(__('Reset'), 'sf_guard_user_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?>
      </div>
      <div class="clear"></div>
    </form>
  </div>

  <div class="span-full">
    <div class="title">
      <span>Users</span>
      <a id="add-user"class="button block-green medium-round" href="<?php echo url_for('@sf_guard_user_new') ?>">Add</a>
      <a class="button block-orange medium-round" href="#" id="filters">Filters</a>
    </div>
    <div class="menu">
      <div class="span-5"><?php echo link_to(__('Username'), 'sfGuardUser/index?sort=s.username&sort_type='.('s.username' == $sort[0] && $sort[1] == 'asc' ? 'desc' : 'asc')) ?></div>
      <div class="span-5"><?php echo link_to(__('First Name'), 'sfGuardUser/index?sort=s.first_name&sort_type='.('s.first_name' == $sort[0] && $sort[1] == 'asc' ? 'desc' : 'asc')) ?></div>
      <div class="span-5"><?php echo link_to(__('Last Name'), 'sfGuardUser/index?sort=s.last_name&sort_type='.('s.last_name' == $sort[0] && $sort[1] == 'asc' ? 'desc' : 'asc')) ?></div>
      <div class="span-6 right last append-1">E-mail</div>
    </div>

    <ul class="action time">
      <?php if ($pager->getNbResults() > 0): ?>
        <?php foreach ($pager->getResults() as $user): ?>
          <li class="icon-group">
            <ul>
              <li class="span-5"><?php echo link_to($user['username'], 'sf_guard_user_edit', $user) ?>&nbsp;</li>
              <li class="span-5"><?php echo $user->first_name ?>&nbsp;</li>
              <li class="span-5"><?php echo $user->last_name ?>&nbsp;</li>
              <li class="span-7 right last append-1"><?php echo $user->email_address ?>&nbsp;</li>
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

<script type="text/javascript">
  $(document).ready(function(){
    $('#block-filters').hide();
    $('#filters').toggle(function() {
      $('#block-filters').show();
    }, function() {
      $('#block-filters').hide();
    });
  });
</script>