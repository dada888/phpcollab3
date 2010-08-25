<?php slot('title', __('Manage statuses')) ?>

<div class="span-23" id="content">
  <?php include_partial('idProject/sub_menu_settings')?>
  <div class="title">
    <span><?php echo __('Statuses'); ?></span>
    <a id="add-log-time"class="button block-green medium-round" href="<?php echo url_for('@new_status') ?>">Add</a>
  </div>
  
  <div class="flash" id="feedback2">
  <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="message notice">
      <?php echo __($sf_user->getFlash('notice')); ?>
    </div>
  <?php endif;?>

  <?php if ($sf_user->hasFlash('error')): ?>
    <div class="message error">
      <?php echo __($sf_user->getFlash('error')); ?>
    </div>
  <?php endif;?>
  </div>

      <table class="table"  id="statuses-list-table">
        <tr class="menu">
          <th class="first">&nbsp;</th>
          <th><?php echo __('Id') ?></th>
          <th><?php echo __('Name') ?></th>
          <th><?php echo __('Status type') ?></th>
          <th><?php echo __('Actions') ?></th>
          <th colspan="2"><?php echo __('Order Priorities') ?></th>
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
          <?php $count = count($status_list); ?>
          <?php $index = 1; ?>
          <?php foreach ($status_list as $status): ?>
          <tr class="sortable" id="status_<?php echo $status->getId() ?>" name="status_<?php echo $status->getId() ?>">
              <td>&nbsp;</td>
              <td><a href="<?php echo url_for('@edit_status?id='.$status->getId()) ?>"><?php echo $status->getId() ?></a></td>
              <td><?php echo $status->getName() ?></td>
              <td><?php echo $status->getStatusType() ?></td>
              <td><a href="<?php echo url_for('@edit_status?id='.$status->getId()) ?>" onClick="window.location = $(this).attr('href'); return false;" ><?php echo __('Edit') ?></a> | <?php echo link_to(__('Delete'), '@delete_status?id='.$status->getId(), array('onclick' => "var answer = confirm('".__("Do you really want to delete this status?")."'); if (answer) { window.location = \$(this).attr('href'); }; return false;")) ?></td>
              <td>
                <p style="display: none;" class="drag-me"><?php echo __('Drag me up and down'); ?></p>
                <?php if ($index > 1): ?>
                  <form action="<?php echo url_for("idStatus/orderStatus") ?>" method="post">
                    <input type="hidden" name="position" value="<?php echo $status->position ?>" />
                    <input type="hidden" name="move" value="up" />
                    <input type="submit" value="Up" class="button" />
                  </form>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($index < $count): ?>
                  <form action="<?php echo url_for("idStatus/orderStatus") ?>" method="post">
                    <input type="hidden" name="position" value="<?php echo $status->position ?>" />
                    <input type="hidden" name="move" value="down" />
                    <input type="submit" value="Down" class="button" />
                  </form>
                <?php endif; ?>
              </td>
              <td>&nbsp;</td>
            </tr>
            <?php $index++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>

<script type="text/javascript">
//<![CDATA[
$(document).ready(
  function()
  {
    $('#statuses-list-table .button').hide();
    $('#statuses-list-table .drag-me').show();

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

