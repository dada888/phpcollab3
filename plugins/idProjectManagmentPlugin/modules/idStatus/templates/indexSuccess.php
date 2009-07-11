<?php slot('title', __('Manage statuses')) ?>
<?php use_helper('jQuery'); ?>

<div class="block" id="block-tables">
  <?php include_partial('create_status_menu'); ?>
  <div class="content">
    <div class="inner">
      <h2 class="title"><?php echo __('Statuses list') ?></h2>
      
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
          <tr>
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
                    <?php echo form_tag('idStatus/orderStatus') ?>
                      <?php echo input_hidden_tag('position', $status->position) ?>
                      <?php echo input_hidden_tag('move', 'up') ?>
                      <?php echo submit_tag('Up', 'class=button') ?>
                    </form>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($index < $count): ?>
                    <?php echo form_tag('idStatus/orderStatus') ?>
                      <?php echo input_hidden_tag('position', $status->position) ?>
                      <?php echo input_hidden_tag('move', 'down') ?>
                      <?php echo submit_tag('Down', 'class=button') ?>
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

      <?php jq_add_plugin(sfConfig::get('jquery_sortable',
    'jquery-ui-sortable-1.6rc6.min.js')); ?>
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
  </div>
</div>

