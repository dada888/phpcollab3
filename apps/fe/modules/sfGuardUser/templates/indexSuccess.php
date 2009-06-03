

<?php slot('title', __('Manage users')) ?>

<?php include_partial('idProject/sf_guard_filters', array(
                                                  'form' => $filters,
                                                  'configuration' => $configuration,
                                                  'module_name' => 'user',
                                                  'fields' => array('username',
                                                                    'is_active',
                                                                    'groups_list',
                                                                    'permissions_list'),
                                                  )); ?>

<div class="block" id="block-tables">
  <?php include_partial('idProject/sf_guard_create_menu', array('module_name' => 'user')); ?>
  <div class="content">
  <h2 class="title"><?php echo __('Users list') ?></h2>
    <div class="inner">

      <form action="<?php echo url_for('sf_guard_user_collection', array('action' => 'batch')) ?>" method="post">
        <?php if (!$pager->getNbResults()): ?>
          <p><?php echo __('No result', array(), 'sf_admin') ?></p>
        <?php else: ?>

        <table class="table">
          <tr>
            <th class="first">&nbsp;</th>
            <?php include_partial('idProject/sf_guard_th_as_ordering_links', array(
                                                                            'sort' => $sort,
                                                                            'module_name' => 'user',
                                                                            'fields' => array(
                                                                                          'username',
                                                                                          'first_name',
                                                                                          'last_name',
                                                                                          'email',
                                                                                          'created_at'
                                                                            )
              )); ?>

            <th class="last"><?php echo __('Actions') ?></th>
          </tr>

          <?php foreach ($pager->getResults() as $i => $sf_guard_user): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
            <tr class="<?php echo $odd ?>">
              <td class="first">&nbsp;</td>
              <td>
                <?php echo link_to($sf_guard_user['username'], 'sf_guard_user_edit', $sf_guard_user) ?>
              </td>
              <td><?php echo $sf_guard_user->Profile->first_name ?></td>
              <td><?php echo $sf_guard_user->Profile->last_name ?></td>
              <td><?php echo $sf_guard_user->Profile->email ?></td>
              <td>
                <?php echo $sf_guard_user['created_at'] ? format_date($sf_guard_user['created_at'], "f") : '&nbsp;' ?>
              </td>
              
              <td>
                <?php include_partial('idProject/sf_guard_actions', array('sf_guard_object' => $sf_guard_user, 'module_name' => 'user')); ?>
              </td>
              
            </tr>
          <?php endforeach; ?>

          <!--tr colspan="6">
              <?php if ($pager->haveToPaginate()): ?>
                <?php include_partial('sfGuardUser/pagination', array('pager' => $pager)) ?>
              <?php endif; ?>

              <?php if ($pager->haveToPaginate()): ?>
                <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
              <?php endif; ?>
            </tr-->

        </table>
        
      <?php endif; ?>
      </form>

    </div>
  </div>
</div>