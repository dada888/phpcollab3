<?php slot('title', __('Manage statuses')) ?>
<?php use_helper('jQuery'); ?>

<div class="block" id="block-tables">
  <?php include_partial('create_status_menu'); ?>
  <div class="content">
    <div class="inner">
      <h2 class="title"><?php echo __('Statuses list') ?></h2>

        <table class="table" id="order_table">
          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Id') ?></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Status type') ?></th>
            <th><?php echo __('Actions') ?></th>
            <th class="last">&nbsp;</th>
          </tr>

          <tbody class="sortable" id="ordered_statuses">
          <?php if ($status_list->count() !== false && $status_list->count() == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="4"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($status_list as $status): ?>
            <tr class="sortable" id="status_<?php echo $status->getId() ?>" name="status_<?php echo $status->getId() ?>">
                <td>&nbsp;</td>
                <td><a href="<?php echo url_for('@edit_status?id='.$status->getId()) ?>"><?php echo $status->getId() ?></a></td>
                <td><?php echo $status->getName() ?></td>
                <td><?php echo $status->getStatusType() ?></td>
                <td><?php echo link_to(__('Edit'), '@edit_status?id='.$status->getId()) ?> | <?php echo link_to(__('Delete'), '@delete_status?id='.$status->getId(), array('onclick' => "var answer = confirm('".__("Do you really want to delete this status?")."'); if (answer) { window.location = \$(this).attr('href'); }; return false;")) ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>

      <div class="flash" id="feedback2"></div>

      <?php jq_add_plugin(sfConfig::get('jquery_sortable',
    'jquery-ui-sortable-1.6rc6.min.js')); ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(
  function()
  {
    $("#ordered_statuses").sortable(
    {
      update: function(e, ui)
      {
        serial = $('#ordered_statuses').sortable('serialize', {});
        $("#feedback2").html('');
        $.ajax({
          url: <?php echo json_encode(url_for('idStatus/order')) ?>,
          success: function(html) { $("#feedback2").html(html); },
          type: 'POST',
          data: serial
          , only: "sortable", tag: "tr"
        });
      }
    } );
  });
//]]>
</script>
    </div>
  </div>
</div>

