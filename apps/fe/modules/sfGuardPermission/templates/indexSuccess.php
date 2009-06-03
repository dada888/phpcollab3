<?php slot('title', __('Manage permissions')) ?>

<?php include_partial('idProject/sf_guard_filters', array(
                                                  'form' => $filters,
                                                  'configuration' => $configuration,
                                                  'module_name' => 'permission',
                                                  'fields' => array('name',
                                                                    'description'),
                                                  )); ?>

<div class="block" id="block-tables">

  <?php include_partial('idProject/sf_guard_create_menu', array('module_name' => 'permission')); ?>

  <div class="content">
    <h2 class="title"><?php echo __('Permissions list') ?></h2>
    <div class="inner">
        <table class="table">
          
          <tr>
            <th class="first">&nbsp;</th>

            <?php include_partial('idProject/sf_guard_th_as_ordering_links', array(
                                                                            'sort' => $sort,
                                                                            'module_name' => 'permission',
                                                                            'fields' => array(
                                                                                          'name',
                                                                                          'description'
                                                                            )
              )); ?>

            <th class="last"><?php echo __('Actions') ?></th>
          </tr>

          <?php include_partial('idProject/content_table_list', array(
                                                                    'pager' => $pager,
                                                                    'module_name' => 'permission',
                                                                    'fields' => array(
                                                                                  'name',
                                                                                  'description'
                                                                    )
                                )); ?>

      </table>

    </div>
  </div>
</div>
