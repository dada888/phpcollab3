<?php slot('title', __('Manage priorities')) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_priority_menu'); ?>
  <div class="content">
    <div class="inner">
      <h2 class="title"><?php echo __('Priorities list') ?></h2>

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

        <table class="table" id="priorities-list-table">

          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Id') ?></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Actions') ?></th>
            <th colspan="2"><?php echo __('Order Priorities') ?></th>
            <th class="last">&nbsp;</th>
          </tr>
          
          <tbody class="sortable" id="ordered_priorities">
          <?php if ($priority_list->count() !== false && $priority_list->count() == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="3"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php $count = count($priority_list); ?>
            <?php $index = 1; ?>
            <?php foreach ($priority_list as $priority): ?>
              <tr class="sortable" id="priority_<?php echo $priority->getId() ?>" name="priority_<?php echo $priority->getId() ?>">
                <td>&nbsp;</td>
                <td><a href="<?php echo url_for('@edit_priority?id='.$priority->getId()) ?>"><?php echo $priority->getId() ?></a></td>
                <td><?php echo $priority->getName() ?></td>
                <td><a href="<?php echo url_for('@edit_priority?id='.$priority->getId()) ?>" onClick="window.location = $(this).attr('href'); return false;" ><?php echo __('Edit') ?></a> | <?php echo link_to(__('Delete'), '@delete_priority?id='.$priority->getId(), array('onclick' => "var answer = confirm('".__("Do you really want to delete this priority?")."'); if (answer) { window.location = \$(this).attr('href'); }; return false;")) ?></td>
                <td>
                  <p style="display: none;" class="drag-me hidden"><?php echo __('Drag me up and down'); ?></p>
                  <?php if ($index > 1): ?>
                    <?php echo form_tag('idPriority/orderPriority') ?>
                      <?php echo input_hidden_tag('position', $priority->position) ?>
                      <?php echo input_hidden_tag('move', 'up') ?>
                      <?php echo submit_tag('Up', 'class=button') ?>
                    </form>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($index < $count): ?>
                    <?php echo form_tag('idPriority/orderPriority') ?>
                      <?php echo input_hidden_tag('position', $priority->position) ?>
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

        

<script type="text/javascript">
//<![CDATA[
$(document).ready(
  function()
  {
    $('#priorities-list-table .button').hide();
    $('#priorities-list-table .drag-me').show();

    $("#ordered_priorities").sortable(
    {
      update: function(e, ui)
      {
        serial = $('#ordered_priorities').sortable('serialize', {});
        $("#feedback2").html('');
        $.ajax({
          url: <?php echo json_encode(url_for('idPriority/order')) ?>,
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

